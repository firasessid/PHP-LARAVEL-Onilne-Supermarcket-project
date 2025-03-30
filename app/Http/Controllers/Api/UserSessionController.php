<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSession;
use App\Mail\SuspiciousLoginAlert;
use App\Services\GeolocationService;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class UserSessionController extends Controller
{
    private const ANOMALY_THRESHOLD = 0.65;
    
    protected $geolocationService;

    public function __construct(GeolocationService $geolocationService)
    {
        $this->geolocationService = $geolocationService;
    }

    public function handleLoginSecurity(Request $request, $userId)
    {
        try {
            $ipAddress = $this->getClientIp($request);
            $location = $this->geolocationService->getLocation($ipAddress);

            $sessions = $this->getRecentSessions($userId);
            $analysisResult = $this->analyzeSessions($sessions);

            if ($this->isSuspiciousActivity($analysisResult)) {
                $this->triggerSecurityActions($userId, $ipAddress, $analysisResult, $location);
                return $this->securityAlertResponse($analysisResult);
            }

            return $this->successResponse();

        } catch (\Exception $e) {
            report($e);
            return $this->errorResponse($e);
        }
    }
    private function getClientIp(Request $request)
    {
        return $request->server('HTTP_X_FORWARDED_FOR') 
            ? explode(',', $request->server('HTTP_X_FORWARDED_FOR'))[0]
            : $request->ip();
    }

    private function formatSessionForAnalysis(UserSession $session)
    {
        return [
            'login_time' => $session->login_time->toDateTimeString(),
            'ip_address' => $session->ip_address,
            'device_type' => $session->device_type,
            'browser' => $session->browser,
            'location' => $session->location,
            'action_type' => $session->action_type
        ];
    }

    private function analyzeSessions(array $sessions)
    {
        try {
            $process = new Process([
                'python3',
                base_path('app/scripts/anomalie.py'),
                escapeshellarg(json_encode($sessions))
            ]);

            $process->run();
            
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            return json_decode($process->getOutput(), true);

        } catch (\Exception $e) {
            logger()->error('Échec analyse anomalies : ' . $e->getMessage());
            return ['is_anomalous' => false, 'risk_score' => 0];
        }
    }

    private function isSuspiciousActivity(array $analysisResult)
    {
        return $analysisResult['is_anomalous'] && 
               $analysisResult['risk_score'] > self::ANOMALY_THRESHOLD;
    }

    private function triggerSecurityActions($userId, $ipAddress, $analysisResult, $location)
    {
        // Envoyer email d'alerte
        $this->sendSecurityAlert(
            $userId, 
            $ipAddress, 
            $analysisResult['risk_score'], 
            $location
        );

        // Journaliser l'incident
        UserSession::create([
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'action_type' => 'security_incident',
            'location' => 'SYSTEM ALERT: ' . $this->formatLocation($location),
            'metadata' => json_encode($analysisResult)
        ]);
    }

    private function sendSecurityAlert($userId, $ipAddress, $riskScore, $location)
    {
        $alertDetails = [
            'userId' => $userId,
            'ipAddress' => $ipAddress,
            'riskScore' => $riskScore,
            'location' => [
                'city' => $location['city'] ?? 'Inconnu',
                'region' => $location['region'] ?? 'Inconnu',
                'country' => $location['country'] ?? 'Inconnu',
                'coordinates' => $location['coordinates'] ?? null
            ]
        ];
    
        Mail::to(config('app.security_email'))
            ->send(new SuspiciousLoginAlert($alertDetails));
    }
    private function formatLocation(array $location)
    {
        return implode(', ', array_filter([
            $location['city'] ?? null,
            $location['region'] ?? null,
            $location['country'] ?? null
        ])) ?: 'Localisation inconnue';
    }

    private function generateMapUrl(array $location)
    {
        if (!empty($location['coordinates']['lat']) && !empty($location['coordinates']['lon'])) {
            return "https://www.openstreetmap.org/?mlat={$location['coordinates']['lat']}&mlon={$location['coordinates']['lon']}#map=15/{$location['coordinates']['lat']}/{$location['coordinates']['lon']}";
        }
        return null;
    }

    private function securityAlertResponse(array $analysisResult)
    {
        return response()->json([
            'status' => 'alert',
            'risk_score' => $analysisResult['risk_score'],
            'message' => 'Activité suspecte détectée',
            'actions' => [
                'require_2fa' => true,
                'log_out_devices' => true
            ]
        ], 403);
    }

    private function successResponse()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Connexion sécurisée'
        ]);
    }

    private function errorResponse(\Exception $e)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Échec de la vérification de sécurité',
            'error' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}
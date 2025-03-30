<?php

namespace App\Services;

use App\Models\UserSession;
use Illuminate\Support\Facades\Process;

class SessionAnalyzer
{
    public function analyzeUserSessions($userId)
    {
        try {
            $sessions = $this->getRecentSessions($userId);
            return $this->runPythonAnalysis($sessions);
        } catch (\Exception $e) {
            Log::error('Session analysis failed: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Analysis failed'
            ];
        }
    }
    private function getRecentSessions($userId)
    {
        return UserSession::where('user_id', $userId)
            ->orderBy('login_time', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($session) {
                return $this->formatSession($session);
            })
            ->toArray();
    }
    private function formatSession(UserSession $session)
    {
        return [
            'login_frequency' => $this->calculateLoginFrequency($session->user_id),
            'time_since_last_login' => $this->getTimeSinceLastLogin($session),
            'ip_change_count' => $this->countIpChanges($session->user_id),
            'location_change' => (int)$this->hasLocationChanged($session),
            'device_change' => (int)$this->hasDeviceChanged($session)
        ];
    }

    private function runPythonAnalysis(array $data)
    {
        $encodedData = base64_encode(json_encode($data));
        
        $result = Process::run([
            'python3',
            base_path('app/scripts/anomalie.py'),
            $encodedData
        ]);

        return json_decode($result->output(), true);
    }
    // Méthodes utilitaires pour calculer les métriques
    private function calculateLoginFrequency($userId)
    {
        return UserSession::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDay())
            ->count();
    }

    private function getTimeSinceLastLogin(UserSession $session)
    {
        $previous = UserSession::where('user_id', $session->user_id)
            ->where('login_time', '<', $session->login_time)
            ->latest('login_time')
            ->first();

        return $previous ? $session->login_time->diffInSeconds($previous->login_time) : 0;
    }

    private function countIpChanges($userId)
    {
        return UserSession::where('user_id', $userId)
            ->select('ip_address')
            ->distinct()
            ->count();
    }

    private function hasLocationChanged(UserSession $session)
    {
        $previous = UserSession::where('user_id', $session->user_id)
            ->where('login_time', '<', $session->login_time)
            ->latest('login_time')
            ->first();

        return $previous && $previous->location !== $session->location;
    }

    private function hasDeviceChanged(UserSession $session)
    {
        $previous = UserSession::where('user_id', $session->user_id)
            ->where('login_time', '<', $session->login_time)
            ->latest('login_time')
            ->first();

        return $previous && ($previous->device_type !== $session->device_type 
            || $previous->browser !== $session->browser);
    }
}
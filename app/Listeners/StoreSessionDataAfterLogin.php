<?php
namespace App\Listeners;

use App\Models\UserSession;
use Illuminate\Auth\Events\Login;
use App\Services\GeolocationService;
use Illuminate\Support\Facades\Log;

class StoreSessionDataAfterLogin
{
    protected $geolocationService;

    public function __construct(GeolocationService $geolocationService)
    {
        $this->geolocationService = $geolocationService;
    }

    public function handle(Login $event)
    {
        $user = $event->user;
        
        try {
            $ipAddress = $this->getClientIp();
            $location = $this->geolocationService->getLocation($ipAddress);
            
            UserSession::create([
                'user_id' => $user->id,
                'ip_address' => $ipAddress,
                'device_type' => $this->getDeviceType(request()),
                'browser' => $this->getBrowserType(request()),
                'location' => $this->formatLocation($location),
                'login_time' => now(),
                'action_type' => 'login',
                'metadata' => json_encode([
                    'user_agent' => request()->header('User-Agent'),
                    'geolocation' => $location
                ])
            ]);

        } catch (\Exception $e) {
            Log::error('Session tracking failed: ' . $e->getMessage());
            $this->createFallbackSession($user);
        }
    }

    private function getClientIp()
    {
        return request()->server('HTTP_X_FORWARDED_FOR') 
            ? explode(',', request()->server('HTTP_X_FORWARDED_FOR'))[0]
            : request()->ip();
    }

    private function formatLocation(array $location)
    {
        $parts = [];
        if (!empty($location['city']) && $location['city'] !== 'Inconnu') {
            $parts[] = $location['city'];
        }
        if (!empty($location['region']) && $location['region'] !== 'Inconnu') {
            $parts[] = $location['region'];
        }
        if (!empty($location['country']) && $location['country'] !== 'Inconnu') {
            $parts[] = $location['country'];
        }
        
        return $parts ? implode(', ', $parts) : 'Localisation inconnue';
    }

    private function createFallbackSession($user)
    {
        UserSession::create([
            'user_id' => $user->id,
            'ip_address' => request()->ip(),
            'device_type' => 'Inconnu',
            'browser' => 'Inconnu',
            'location' => 'Erreur de géolocalisation',
            'login_time' => now(),
            'action_type' => 'login'
        ]);
    }


    // Helper function to get the device type (you can modify as needed)
    private function getDeviceType($request)
    {
        $userAgent = $request->header('User-Agent');
        return strpos($userAgent, 'Mobile') !== false ? 'Mobile' : 'Desktop';
    }

    // Helper function to get the browser type
    private function getBrowserType($request)
    {
        $userAgent = $request->header('User-Agent');
        if (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } else {
            return 'Other';
        }
    }
}

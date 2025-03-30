<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeolocationService
{
    public function getLocation($ipAddress)
    {
        try {
            $apiKey = env('IPSTACK_KEY');
            $response = Http::get("http://api.ipstack.com/{$ipAddress}", [
                'access_key' => $apiKey,
                'fields' => 'city,region_name,country_name,latitude,longitude'
            ]);
    
            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'city' => $data['city'] ?? 'Inconnu',
                    'region' => $data['region_name'] ?? 'Inconnu',
                    'country' => $data['country_name'] ?? 'Inconnu',
                    'coordinates' => [
                        'lat' => $data['latitude'] ?? null,
                        'lon' => $data['longitude'] ?? null
                    ]
                ];
            }
    
            Log::error('Réponse IPStack : ' . $response->body());
    
        } catch (\Exception $e) {
            Log::error('Erreur géolocalisation : ' . $e->getMessage());
        }
    
        return $this->defaultLocation();
    }
    private function defaultLocation()
    {
        return [
            'city' => 'Inconnu',
            'region' => 'Inconnu',
            'country' => 'Inconnu',
            'coordinates' => null
        ];
    }
}
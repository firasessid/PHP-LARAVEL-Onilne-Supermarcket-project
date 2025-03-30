<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuspiciousLoginAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $alertData;

    public function __construct(array $alertData)
    {
        $this->alertData = $alertData;
    }

    public function build()
    {
        return $this->subject('🚨 ALERTE: Activité de connexion suspecte détectée')
                    ->view('Back-end.suspicious_login_alert')
                    ->with([
                        'riskLevel' => $this->getRiskLevel(),
                        'location' => $this->formatLocation(),
                        'mapUrl' => $this->getMapUrl()
                    ]);
    }

    private function getRiskLevel()
    {
        // Vérifie si 'riskScore' existe et est numérique
        if (!isset($this->alertData['riskScore']) || !is_numeric($this->alertData['riskScore'])) {
            return 'Inconnu';
        }

        $riskScore = (float)$this->alertData['riskScore'];

        return match(true) {
            $riskScore >= 80 => 'Critique',
            $riskScore >= 60 => 'Élevé',
            default => 'Moyen'
        };
    }

    private function formatLocation()
    {
        // Vérifie si 'location' existe
        if (!isset($this->alertData['location']) || !is_array($this->alertData['location'])) {
            return 'Localisation non disponible';
        }

        $loc = $this->alertData['location'];

        // Utilise des valeurs par défaut avec null coalescing
        $parts = [];
        if (!empty($loc['city']) && $loc['city'] !== 'Inconnu') $parts[] = $loc['city'];
        if (!empty($loc['region']) && $loc['region'] !== 'Inconnu') $parts[] = $loc['region'];
        if (!empty($loc['country']) && $loc['country'] !== 'Inconnu') $parts[] = $loc['country'];

        return $parts ? implode(', ', $parts) : 'Localisation inconnue';
    }

    private function getMapUrl()
    {
        // Vérifie si 'location' et 'coordinates' existent
        if (!isset($this->alertData['location']['coordinates']) || !is_array($this->alertData['location']['coordinates'])) {
            return null;
        }

        $coords = $this->alertData['location']['coordinates'];

        // Vérifie si les coordonnées sont valides
        if (!empty($coords['lat']) && !empty($coords['lon'])) {
            return "https://www.google.com/maps?q={$coords['lat']},{$coords['lon']}";
        }

        return null;
    }
}
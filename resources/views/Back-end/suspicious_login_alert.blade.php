<!DOCTYPE html>
<html>
<head>
    <style>
        .alert-box {
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 5px;
            max-width: 600px;
            margin: 0 auto;
        }
        .alert-title {
            color: #dc3545;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .details-section {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="alert-box">
        <div class="alert-title">🚨 Alerte de sécurité</div>
        
        <p><strong>Niveau de risque :</strong> {{ $riskLevel }}</p>
        
        <div class="details-section">
            <h3>Détails de la connexion :</h3>
            <p>📍 Localisation : {{ $location }}</p>
            
            @if($mapUrl)
            <p>
                <a href="{{ $mapUrl }}" target="_blank">
                    Voir sur la carte
                </a>
            </p>
            @endif

            <p>IP : {{ $alertData['ipAddress'] }}</p>
            <p>Utilisateur : {{ $alertData['userId'] }}</p>
            <p>Score de risque : {{ $alertData['riskScore'] }}%</p>
        </div>
    </div>
</body>
</html>
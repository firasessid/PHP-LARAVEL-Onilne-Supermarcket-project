<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AiServiceClient
{
    protected $client;

    public function __construct()
    {
        // Initialize Guzzle HTTP client
        $this->client = new Client([
            'base_uri' => 'https://api.cohere.ai/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('COHERE_API_KEY'),
                'X-Client-Name' => 'my-cool-project',
            ],
        ]);
    }

    public function getModelDetails(string $modelName): array
    {
        try {
            // Make a GET request to fetch model details
            $response = $this->client->get("models/{$modelName}");

            // Decode the JSON response
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Handle errors gracefully
            if ($e->hasResponse()) {
                $errorResponse = $e->getResponse()->getBody()->getContents();
                return ['error' => 'API Error: ' . $errorResponse];
            }

            return ['error' => 'Request Error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            return ['error' => 'Unexpected Error: ' . $e->getMessage()];
        }
    }public function analyzeSales(array $salesData): array
    {
        try {
            if (empty($salesData)) {
                return ['error' => 'Sales data is empty.'];
            }
    
            // Ensure the sales data is properly formatted as a string
            $salesDataJson = json_encode($salesData);
            if (empty($salesDataJson)) {
                return ['error' => 'Sales data could not be encoded to JSON.'];
            }
       // Define the prompt clearly
$prompt = "Voici un exemple de données de ventes :\n\n"
. '[{"product_id":123,"date":"2024-12-01","quantity_sold":10,"revenue":100},'
. '{"product_id":124,"date":"2024-12-02","quantity_sold":5,"revenue":50}]\n\n'
. "Analysez ces données pour les produits en régression et proposez des réductions.";

// Log the prompt content before request
\Log::info('Sending prompt:', ['prompt' => $prompt]);

// Check if the prompt is valid and non-empty
if (empty($prompt)) {
\Log::error('Prompt is empty or not valid.');
return response()->json(['error' => 'Prompt is empty or invalid.'], 400);
}

// Define the prompt clearly
$prompt = "Voici un exemple de données de ventes :\n\n"
    . '[{"product_id":123,"date":"2024-12-01","quantity_sold":10,"revenue":100},'
    . '{"product_id":124,"date":"2024-12-02","quantity_sold":5,"revenue":50}]\n\n'
    . "Analysez ces données pour les produits en régression et proposez des réductions.";

// Log the prompt content before request
\Log::info('Sending prompt:', ['prompt' => $prompt]);

// Check if the prompt is valid and non-empty
if (empty($prompt)) {
    \Log::error('Prompt is empty or not valid.');
    return response()->json(['error' => 'Prompt is empty or invalid.'], 400);
}

// Send the request to the 'chat' endpoint
$response = $this->client->post('chat', [
    'json' => [
        'model' => 'command-r',  // Using the 'command-r' model for chat
        'messages' => [
            ['role' => 'user', 'content' => $prompt], // Send the prompt in the message content
        ],
        'max_tokens' => 500, // Limit the response length
    ],
]);

// Log the API response for debugging
\Log::info('API Response from chat:', ['response' => $response->getBody()->getContents()]);
      // Decode the JSON response
            $responseBody = json_decode($response->getBody()->getContents(), true);
    
            // Check if the response contains valid content
            if (isset($responseBody['messages'][0]['content'])) {
                return json_decode($responseBody['messages'][0]['content'], true);
            }
    
            return ['error' => 'Invalid response format from AI service.'];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorResponse = $e->getResponse()->getBody()->getContents();
                return ['error' => 'API Error: ' . $errorResponse];
            }
    
            return ['error' => 'Request Error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            return ['error' => 'Unexpected Error: ' . $e->getMessage()];
        }
    }
    
    
    
}

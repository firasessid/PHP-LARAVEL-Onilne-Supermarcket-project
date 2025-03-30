<?php
namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\UserInteraction;
use App\Events\ProductClicked;

class LogProductClick
{
    public function __construct()
    {
        //
    }

    public function handle(ProductClicked $event)
    {
        // Load the KMeans model and scaler
        $model = $this->loadModel();
        $scaler = $this->loadScaler();

        $interactionFeature = $this->actionToFeature('click');
        $scaledFeature = $scaler->transform(new \Rubix\ML\Datasets\Unlabeled([[$event->productId, $interactionFeature]]));

        $predictedCluster = $model->predict($scaledFeature)[0]; // Predict cluster ID based on interaction data

        UserInteraction::create([
            'user_id' => auth()->id(),
            'product_id' => $event->productId,
            'action_type' => 'click',
            'interaction_time' => now(),
            'cluster_id' => $predictedCluster, // Save predicted cluster ID
        ]);
    }

    private function loadModel()
    {
        $modelFile = storage_path('model.dat');
        return unserialize(file_get_contents($modelFile));
    }

    private function loadScaler()
    {
        $scalerFile = storage_path('scaler.dat');
        return unserialize(file_get_contents($scalerFile));
    }

    private function actionToFeature($action)
    {
        return match ($action) {
            'view' => 1,
            'click' => 2,
            default => 0,
        };
    }
}

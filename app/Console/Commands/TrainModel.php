<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RecommendationController;

class TrainModel extends Command
{
    protected $signature = 'recommendations:train';
    protected $description = 'Train the recommendation model';

    public function handle()
    {
        try {
            $controller = new RecommendationController();
            $controller->trainModel();
            $this->info('Model trained successfully.');
        } catch (\Exception $e) {
            $this->error('Error during training: ' . $e->getMessage());
        }
    }
}

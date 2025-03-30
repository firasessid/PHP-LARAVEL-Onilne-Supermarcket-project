<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExportInteractions extends Command
{
    protected $signature = 'app:export-interactions';
    protected $description = 'Export user interactions to a CSV file';

    public function handle()
    {
        $interactions = DB::table('user_interactions')->get();

        if ($interactions->isEmpty()) {
            $this->error("No data found in the interactions table.");
            return;
        }

        $csvData = "user_id,product_id,action_type,interaction_time\n";
        foreach ($interactions as $interaction) {
            $csvData .= "{$interaction->user_id},{$interaction->product_id},{$interaction->action_type},{$interaction->interaction_time}\n";
        }

        $filePath = storage_path('app/interactions.csv');
        file_put_contents($filePath, $csvData);

        $this->info("Data exported to {$filePath}");
    }
}

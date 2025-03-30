<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestPythonScriptPath extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-python-script-path';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pythonScriptPath = base_path('app/scripts/sales_analysis.py');
        $this->info('Python Script Path: ' . $pythonScriptPath);
        
        if (file_exists($pythonScriptPath)) {
            $this->info('Script exists at path: ' . $pythonScriptPath);
        } else {
            $this->error('Script not found at path: ' . $pythonScriptPath);
        }
    }
    
}

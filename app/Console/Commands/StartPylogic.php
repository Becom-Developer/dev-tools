<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class StartPylogic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start-pylogic';

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
        $path = base_path('pylogic');
        $commond = 'python3 -m venv .venv && .venv/bin/python3 -m pip install -r requirements.txt';
        logger('commond start: ', [$commond]);
        $result = Process::path($path)->run($commond, function (string $type, string $output) {
            echo $output;
        });
        logger('commond end: ', [
            'successful' => $result->successful(),
            'failed' => $result->failed(),
            'exitCode' => $result->exitCode(),
            // 'output' => $result->output(),
            // 'errorOutput' => $result->errorOutput(),
        ]);
    }
}

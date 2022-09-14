<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repository\EscortRankingRepository;

class EscortRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'escort:ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate escort ranking daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $repository = app(EscortRankingRepository::class);
        $result = $repository->generateRanking();
        if ($result) {
            $this->info('Escort Ranking Generated successfully');
        } else {
            $this->info('Failed to generate escort ranking');
        }
    }
}

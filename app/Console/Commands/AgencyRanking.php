<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repository\AgencyRankingRepository;

class AgencyRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agency:ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate agency ranking daily';

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
        $repository = app(AgencyRankingRepository::class);
        $result = $repository->generateRanking();
        if ($result) {
            $this->info('Agency Ranking Generated successfully');
        } else {
            $this->info('Failed to generate agency ranking');
        }
    }
}

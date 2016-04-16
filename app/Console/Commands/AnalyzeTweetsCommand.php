<?php

namespace KandiData\Console\Commands;

use Illuminate\Console\Command;
use KandiData\Tweet;

class AnalyzeTweetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kandidata:tweet-analyzer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyzes Tweets';

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
        
    }
}

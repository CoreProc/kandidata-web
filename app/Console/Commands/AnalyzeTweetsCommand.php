<?php

namespace KandiData\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use KandiData\Jobs\ProcessFeels;
use KandiData\Jobs\ProcessKeywords;
use KandiData\Jobs\ProcessSentiments;
use KandiData\Tweet;

class AnalyzeTweetsCommand extends Command
{
    use DispatchesJobs;
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
        $this->dispatch(new ProcessSentiments);
        $this->dispatch(new ProcessFeels);
        $this->dispatch(new ProcessKeywords);
    }
}

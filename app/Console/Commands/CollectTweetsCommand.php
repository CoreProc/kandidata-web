<?php

namespace KandiData\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use KandiData\Candidate;
use KandiData\Jobs\CollectTweets;

class CollectTweetsCommand extends Command {
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kandidata:tweet-collector';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collects tweets';

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
        $candidates = Candidate::all();

        foreach ($candidates as $candidate) {
            $this->dispatch(new CollectTweets($candidate->hashtag . ' OR ' . $candidate->twitter_mention, $candidate->id));
        }
    }
}

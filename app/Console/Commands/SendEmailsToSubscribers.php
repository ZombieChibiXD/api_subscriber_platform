<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class SendEmailsToSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribers:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to subscribers of new posts';

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
     * @return int
     */
    public function handle()
    {
        // Get all post with the website, and the subscribers of the website
        Post::with('website.subscribers')->get()->each(function ($post) {
            // Send email to each subscriber
            $post->website->subscribers->each(function ($subscriber) use ($post) {
                $subscriber->notify(new \App\Notifications\NewPost($post));
            });
        });

        return 0;
    }
}

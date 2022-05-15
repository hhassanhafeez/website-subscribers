<?php

namespace App\Console\Commands;

use App\Jobs\SendEmail;
use App\Models\Post;
use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendPostEmailToWebsiteSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:website-subscribers {post}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send an email to all website subscribers upon creating new post.';

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
        $post = $this->argument('post');
        Website::find($post->website_id)->users()->chunk(500, function ($users) use ($post) {
            foreach ($users as $user) {
                dispatch(new SendEmail($user->email, $post));
            }
        });
    }
}

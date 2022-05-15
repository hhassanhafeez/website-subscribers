<?php

namespace App\Jobs;

use App\Mail\WebsitePostSubscribers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $post)
    {
        $this->email = $email;
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new WebsitePostSubscribers($this->post);
        Mail::to($this->email)->send($email);
    }
}

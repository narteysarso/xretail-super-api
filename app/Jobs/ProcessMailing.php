<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessMailing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subject;

    protected $body;

    protected $toAddress;

    protected $fromAddress;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(String $subject, String $body, array $config)
    {
        //
        $this->subject = $subject;
        $this->body = $body;
        $this->toAddress = $config["toAddress"];
        $this->fromAddress = $config["fromAddress"];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            "toAddress" => $this->toAddress,
            "fromAddress" => $this->fromAddress,
            "subject" => $this->subject,
            "body" => $this->body,
            "_token" => @csrf_field()
        ];

        \App\Utility\PostCall::run(env('EMAILURL', 'http://localhost:8002/mail'), http_build_query($data), "");
    }
}

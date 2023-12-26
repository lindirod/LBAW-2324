<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invitation extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;
    protected $project;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($project,$url)
    {
        $this->url = $url;
        $this->project =$project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.project-invitation',['url'=>$this->url,'project'=>$this->project]);
    }
}
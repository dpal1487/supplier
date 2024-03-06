<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountMail extends Mailable
{
    use Queueable, SerializesModels;

      public $title; 
      public $user; 
      public function __construct($title, $user) 
      {
      // 
      $this->title = $title; 
      $this->user= $user; 
      }
      public function build() 
      { 
          return $this->subject($this->title)->view('mail');
      }
}

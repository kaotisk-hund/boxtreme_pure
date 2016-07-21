<?php

namespace BoxTreme\Tests;
use BoxTreme\Core;


class MailTest extends Core\Generic{
    
    private $from = 'ccc2007chaos@gmail.com';
    private $to = 'ccc2007chaos@gmail.com';
    private $subject = 'Test on mail!';
    private $body = 'Hi! This is a test mail from our mail class. Have a nice day! :)';
    
    private $mailer;
    
    
    function init(){
        $this->mailer = new Core\Mailer();
        $this->mailer->sendMail($this->from, $this->to, $this->subject, $this->body);
    }
    
}
<?php
/*
 * Mailer class. Send mail with gmail.
 * 
 * Requires:
 *  pear
 *  pear/Net_SMTP
 *  pear/Mail
 *  pear/Net_Socket
 * 
 */
namespace BoxTreme\Core;

use BoxTreme\Settings;

class Mailer extends Generic{
    private $data = [];
    
    function init(){
        // Pear Mail Library
        $this->getSettings();
    }
    
    function getSettings(){
        $this->data = Settings\MailSettings::getSettings();
        
    }
    
    function sendMail($from, $to, $subject, $body){


        $headers = array(
            'From' => $from,
            'To' => $to,
            'Subject' => $subject
        );

        $smtp = \Mail::factory('smtp', array(
                'host' => 'ssl://smtp.gmail.com',
                'port' => '465',
                'auth' => true,
                'username' => $this->data['username'],
                'password' => $this->data['password']
            ));

        $mail = $smtp->send($to, $headers, $body);

        if (PEAR::isError($mail)) {
            echo('<p>' . $mail->getMessage() . '</p>');
        } else {
            echo('<p>Message successfully sent!</p>');
        }
    }
}


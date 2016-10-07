<?php

// Autoload files using Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

// Email Structure Instance with Template Path and Optional Data
$email = new \Xcytek\EmailLibrary\Email('templates/basic.php', [
    // Optional Data for the template
    'author'  => 'Alex Acosta',
    'email'   => 'alexcytek@gmail.com',
    'twitter' => '@xcytek',
]);

// Use data necessary (MANDATORY) to send the email
$email->setUse([
    'subject' => 'Xcytek Easy Email Library',

    // Can add more than one
    'to' => [
        [
            'email' => 'alexcytek@gmail.com',
            'name'  => 'Alex Acosta',
        ]
    ]
]);

// Email Sender Instance
$emailSender = new \Xcytek\EmailLibrary\EmailSender();

// Try sending the email
if ($emailSender->send($email)) {
    echo 'Mail sent to ' . $email->getData()['email'];
} else {
    echo 'Mail cannot be delivered to ' . $email->getData()['email'];
}
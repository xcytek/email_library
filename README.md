# email_library
Easy Email Library based on PHPMailer

Example How To Use:

```php
// Autoload files using Composer autoload.
require_once __DIR__ . '/../vendor/autoload.php';

// Configuration data as Array.
$configurationArray = [
  // This is the Required data
  'host'          => 'smtp.gmail.com',
  'smtp_auth'     => true,
  'username'      => 'your_email_account',
  'password'      => 'you_password',
  'who_sent'      => 'Xcytek Easy Email Library',
  'smtp_secure'   => 'ssl',
  'port'          => 465,
  'charset'       => 'UTF-8',
  'is_html'       => true,
  'smtp_options'  => [
      'ssl' => [
          'verify_peer'       => false,
          'verify_peer_name'  => false,
          'allow_self_signed' => true,
      ]
  ]
];

// Email Structure Instance with Template Path and Optional Data.
$email = new \Xcytek\EmailLibrary\Email('templates/basic.php', [
    'author'  => 'Alex Acosta',
    'email'   => 'alexcytek@gmail.com',
    'twitter' => '@xcytek',
]);

// Use data necessary (MANDATORY) to send the email.
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

// Email Sender Instance with 2 params (or no params here), $email and configuration.
$emailSender = new \Xcytek\EmailLibrary\EmailSender($email, $configurationFile);

// Try sending the email.
if ($emailSender->send()) {
    echo 'Mail sent to ' . $email->getData()['email'];
} else {
    echo 'Mail cannot be delivered to ' . $email->getData()['email'];
}
```

Another Example
```php

// Autoload files using Composer autoload.
require_once __DIR__ . '/../vendor/autoload.php';

// Configuration data file as JSON (valid format and readable file).
$configurationFile = '/path/to/config_file.json'; 

// Email Structure Instance with Template Path and Optional Data.
$email = new \Xcytek\EmailLibrary\Email('templates/basic.php', [
    'author'  => 'Alex Acosta',
    'email'   => 'alexcytek@gmail.com',
    'twitter' => '@xcytek',
]);

// Use data necessary (MANDATORY) to send the email.
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

// Email Sender Instance with 2 params (or no params here), $email and configuration.
$emailSender = new \Xcytek\EmailLibrary\EmailSender();

// Set configuration needed in this method as json file (full path) or array (shown above) with same structure that the array above.
// This approach is useful for scenarios when you need to use another configuration using the same instance.  

$emailSender->setConfig($configurationFile);

// Try sending the email. $email instance can be specified at this point too.
// This approach is useful for scenarios when you need to use the same instance across many methods,
// Avoiding create the sender instance and configuration every time, just specify the $email and send.

if ($emailSender->send($email)) {
    echo 'Mail sent to ' . $email->getData()['email'];
} else {
    echo 'Mail cannot be delivered to ' . $email->getData()['email'];
}

```
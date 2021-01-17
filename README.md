# email_library
Easy Email Library based on PHPMailer

Example How To Use:

```php
// Autoload files using Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';

// Email Structure Instance with Template Path and Optional Data
$email = new \Xcytek\EmailLibrary\Email('templates/basic.php', [
    'author'  => 'Alex Acosta',
    'email'   => 'alexcytek@gmail.com',
    'twitter' => '@xcytek',
]);

// Set SMTP account params
$email->config['username'] = 'your@email.com';
$email->config['password'] = 'your_password';
$email->config['who_sent'] = 'Who is sending';

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
```
<?php

namespace Xcytek\EmailLibrary;

use PHPMailer;

/**
 * Class EmailSender
 *
 * @package Xcytek\EmailLibrary
 * @author Alex Acosta <alexcytek@gmail.com>
 * @license MIT
 */
class EmailSender
{
    /**
     * Send email using a template, data and use options for closure function
     *
     * @param \Xcytek\EmailLibrary\Email $email
     * @return bool
     */
    public function send(Email $email)
    {
        // Create PHPMailer Instance
        $mail = new PHPMailer();

        // Set Configuration Params
        $email->setConfigurationParams($mail);

        // Add Recipients
        if (count($email->getUse()['to']) > 0) {
            foreach ($email->getUse()['to'] as $recipient) {
                $mail->addAddress($recipient['email'], $recipient['name']);
            }
        }

        // HTML Email View
        $view = $email->getHtml();

        // Subject and Email Body
        $mail->Subject = $email->getUse()['subject'];
        $mail->Body    = $view;

        // Send email
        return $mail->send();
    }
}
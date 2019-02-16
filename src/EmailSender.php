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
     * Email instance
     *
     * @var Email
     */
    private $email;

    /**
     * Debug Level
     *
     * Check for different Debug values at https://github.com/PHPMailer/PHPMailer/wiki/SMTP-Debugging
     *
     * @var int
     */
    private $debugLevel = 0;

    /**
     * Configuration Params
     *
     * Check for more configuration parameters  http://phpmailer.github.io/PHPMailer/classes/PHPMailer.PHPMailer.PHPMailer.html
     *
     * @var
     */
    private $config = [
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

    /**
     * EmailSender constructor.
     *
     * @param Email $email
     * @param mixed $config
     */
    public function __construct(Email $email = null, $config = null)
    {
        $this->email = $email;
        $this->setConfig($config);
    }

    /**
     * Send email using a template, data and use options for closure function
     *
     * @param \Xcytek\EmailLibrary\Email $email
     *
     * @return bool
     * @throws \Exception
     */
    public function send(Email $email = null)
    {
        // Create PHPMailer Instance
        $mail = new PHPMailer();

        // Email instance should be passed by constructor or directly through this method.
        if (($email instanceof Email === false) || (is_null($this->email) === true && is_null($email) === true)) {

            throw new \Exception('Invalid email instance. Please provide one.');

        }

        // In case the $email attribute is null, get from private attribute
        elseif (is_null($email) === true) {

            $email = $this->email;

        }

        // Set Configuration Params
        $this->setConfigurationParams($mail);


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

    /**
     * Set Basic Configurations
     *
     * @param \PHPMailer $mail
     * @param EmailSender $sender
     *
     * @throws \Exception
     */
    public function setConfigurationParams(\PHPMailer &$mail)
    {
        // Check for config not being null value
        if (is_null($this->config) === null) {

            throw new \Exception("Invalid configuration data. Please check the documentation.");

        }

        $mail->SMTPDebug = $this->debugLevel;
        $mail->isSMTP();
        $mail->isHTML(
            $this->getConfigValue('is_html')
        );

        // Try set configuration params as safe block
        try {

            $mail->Host         = $this->getConfigValue('host');
            $mail->SMTPAuth     = $this->getConfigValue('smtp_auth');
            $mail->Username     = $this->getConfigValue('username');
            $mail->Password     = $this->getConfigValue('password');
            $mail->SMTPSecure   = $this->getConfigValue('smtp_secure');
            $mail->Port         = $this->getConfigValue('port');
            $mail->CharSet      = $this->getConfigValue('charset');
            $mail->SMTPOptions  = $this->getConfigValue('smtp_options');

        }

            // If any problem, throw the error
        catch (\Exception $e) {

            throw new \Exception($e->getMessage());

        }

        $mail->setFrom(
            $this->config['username'], $this->config['who_sent']
        );
    }

    /**
     * Set Configuration
     *
     * @param $config
     *
     * @return EmailSender
     */
    public function setConfig($config)
    {
        // Verify when its an array so can be set directly
        if (is_array($config) === true) {

            $this->config = $config;

        }

        // Verify when a string is passed as JSON config file path
        // Validate the file is writable and exists
        elseif (is_string($config) === true && is_writable($config) === true && file_exists($config) === true) {

            $this->config = json_decode(file_get_contents($config), true);

        }

        // None of the above apply, so set config as null
        else {

            $this->config = null;

        }

        return $this;
    }

    /**
     * Get Configuration data
     *
     * @return array
     */
    public function getConfig() : array
    {
        return $this->config;
    }

    /**
     * Get Configuration value
     *
     * @param $key
     * @return array
     * @throws \Exception
     */
    public function getConfigValue($key)
    {
        if (isset($this->config[$key]) === true) {
            return $this->config[$key];
        }

        throw new \Exception("Invalid configuration param");
    }
}
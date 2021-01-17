<?php

namespace Xcytek\EmailLibrary;

/**
 * Class Email
 *
 * @package Xcytek\EmailLibrary
 * @author Alex Acosta <alexcytek@gmail.com>
 * @license MIT
 */
class Email
{
    /**
     * HTML Email Template
     *
     * @var
     */
    private $template;

    /**
     * Data used in the HTML Template
     *
     * @var
     */
    private $data;

    /**
     * Closure Function Use Data
     *
     * @var
     */
    private $use;

    /**
     * HTML String
     *
     * @var
     */
    private $html;

    /**
     * Configuration Params
     *
     * @var
     */
    public $config = [
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
     * Email constructor.
     *
     * @param $template
     * @param array $data (optional)
     */
    public function __construct($template, array $data = null)
    {
        $this->template = $template;
        $this->data     = $data;

        // Get HTML String
        $this->html = $this->renderViewIntoHtml($this->template, $this->data);
    }

    /**
     * Set View and Data
     *
     * @param $template
     * @param array $data (optional)
     */
    public function setView($template, array $data = null)
    {
        $this->template = $template;
        $this->data     = $data;
    }

    /**
     * Set Use data
     *
     * @param array $use
     */
    public function setUse(array $use)
    {
        $this->use = $use;
    }

    /**
     * Return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Return Template Data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set Use data
     */
    public function getUse()
    {
        return $this->use;
    }

    /**
     * Get Html
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set Basic Configurations
     *
     * @param \PHPMailer $mail
     */
    public function setConfigurationParams(\PHPMailer &$mail)
    {
        //$mail->SMTPDebug = 1;
        $mail->isSMTP();
        $mail->isHTML($this->config['is_html']);

        $mail->Host         = $this->config['host'];
        $mail->SMTPAuth     = $this->config['smtp_auth'];
        $mail->Username     = $this->config['username'];
        $mail->Password     = $this->config['password'];
        $mail->SMTPSecure   = $this->config['smtp_secure'];
        $mail->Port         = $this->config['port'];
        $mail->CharSet      = $this->config['charset'];
        $mail->SMTPOptions  = $this->config['smtp_options'];

        $mail->setFrom($this->config['username'], $this->config['who_sent']);
    }

    /**
     * Basic method to convert HTML code into HTML string
     *
     * @param            $template
     * @param array|null $data
     *
     * @return $html
     */
    public function renderViewIntoHtml($template, array $data = null)
    {
        // Start Buffering
        ob_start();

        // Validate if some Data exist
        if (! is_null($data)) {
            extract($data);
        }
        // Inlude HTML Template
        include($template);

        // Get Template String
        $html = ob_get_contents();

        // Clean Buffer
        ob_end_clean();

        return $html;
    }
}
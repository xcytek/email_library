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
     *
     * @return Email
     */
    public function setUse(array $use)
    {
        $this->use = $use;

        return $this;
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
        // Include HTML Template
        include($template);

        // Get Template String
        $html = ob_get_contents();

        // Clean Buffer
        ob_end_clean();

        return $html;
    }
}
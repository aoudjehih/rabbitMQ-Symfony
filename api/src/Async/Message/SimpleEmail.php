<?php

namespace App\Async\Message;

/**
 * Class SimpleEmail
 */
class SimpleEmail
{
    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @var string
     */
    private $emailSubject;

    /**
     * @var string
     */
    private $emailBody;

    /**
     * SimpleEmail constructor.
     * @param string $emailAddress
     * @param string $emailBody
     * @param string $emailObject
     */
    public function __construct(string $emailAddress, string $emailBody, string $emailObject)
    {
        $this->emailAddress = $emailAddress;
        $this->emailBody    = $emailBody;
        $this->emailSubject  = $emailObject;
    }

    /**
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    /**
     * @return string
     */
    public function getEmailSubject(): string
    {
        return $this->emailSubject;
    }

    /**
     * @return string
     */
    public function getEmailBody(): string
    {
        return $this->emailBody;
    }
}

<?php

namespace OpenAPIServer\Services;

use Exception;
use DateTime;
use DateTimeInterface;
use OpenAPIServer\Model;

class MailService
{
    public static function sendMail(object $report)
    {
        $mailText = MailService::formatText($report);
    }

    public static function formatText(object $report)
    {

    }
}

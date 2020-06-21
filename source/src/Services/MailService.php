<?php

namespace OpenAPIServer\Services;

use Exception;
use DateTime;
use DateTimeInterface;
use OpenAPIServer\Model;
use OpenAPIServer\DTOs;

class MailService
{
    public static function sendMail(\OpenAPIServer\DTOs\Report $report)
    {
        $mailText = MailService::formatText($report);
        $to = \Environment\Environment::mailReceivers();
        $subject = "Anzeige Geruchsbelästigung";
        $from = "From: {$report->reporter->name} <{$report->reporter->email}>\r\n";
        $from .= "Reply-To: {$report->reporter->email} \r\n";
        $from .= "Content-Type: text/html\r\n";
        $mailToSenateSuccess =  $to == "" || mail($to, $subject, $mailText, $from);
        $mailToReporterSuccess =  MailService::sendCc($report);
        return $mailToSenateSuccess && $mailToReporterSuccess;
    }

    public static function sendCc(\OpenAPIServer\DTOs\Report $report)
    {
        $mailText = <<<EOD
        <p>Hallo {$report->reporter->name},</p>
        <p>danke, dass du dich für saubere Luft im Kiez einsetzt! Wir haben in deinem Namen unten stehende Email an den Senat gesendet.</p>
        <hr />
        EOD;
        $mailText .=  MailService::formatText($report);
        $subject = "Danke für deine Gestank-Meldung";
        $from = "From: Wilhelm Gibt Keine Ruh <no-reply@wilhelm-gibt-keine-ruh.de>\r\n";
        $from .= "Reply-To: <no-reply@wilhelm-gibt-keine-ruh.de> \r\n";
        $from .= "Content-Type: text/html\r\n";
        return mail($report->reporter->email, $subject, $mailText, $from);
    }

    public static function formatText(\OpenApiServer\DTOs\Report $report): string
    {
        $numberFormatter = new \NumberFormatter("de-DE", \NumberFormatter::DECIMAL);
        $numberFormatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, 5);
        $berlinTime = $report->time->setTimezone(new \DateTimeZone('Europe/Berlin'));

        $text = <<<EOD
        <p>Sehr geehrte Damen und Herren,</p>
        <p>Hiermit zeige ich – mit der Bitte um Weiterverfolgung durch Ihr Amt – folgende Geruchsbelästigung an:</p>
        <p>Geruchsstärke: {$report->stink->intensity}/5<br />
        mit Belästigung: ja</p>
        <table>
            <tr>
                <td>Ort:</td>
                <td>Breitengrad: {$numberFormatter->format($report->location->coordinates->longitude)}&#730; n.B.</td>
            </tr>
            <tr>
                <td></td>
                <td>Längengrad: {$numberFormatter->format($report->location->coordinates->latitude)}&#730; ö.L.</td>
            </tr>
        EOD;

        if (!is_null($report->location->address)) {
            $address = $report->location->address;
            $text .= <<<EOD
            <tr>
                <td></td>
                <td>{$address->street} {$address->number}<br />
                {$address->zip} {$address->city}</td>
            </tr>
            EOD;
        }

        $text .= <<<EOD
            <tr>
                <td>Geruchsart:</td>
                <td>{$report->stink->kind}</td>
            </tr>
            <tr>
                <td>Zeit:</td>
                <td>{$berlinTime->format('d.m.Y H:i')} Uhr</td>
            </tr>
        </table>
        <p>Danke, dass Sie sich durch Weiterverfolgung oben angezeigter Geruchsbelästigung für mehr Lebensqualität, saubere Luft und eine bessere Stadt einsetzen!</p>
        <p>Mit freundlichen Grüßen</p>
        <p>{$report->reporter->name}<br />
        {$report->reporter->email}</p>
        EOD;

        return $text;
    }
}

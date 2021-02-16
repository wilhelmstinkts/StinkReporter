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
        $coordinates = $report->location->coordinates;
        $temperatureCelsius = $report->weather->temperature - 273.15;
        $includeTimeFrame = !is_null($report->timeFrame);

        $text = <<<EOD
        <p>Sehr geehrte Damen und Herren,</p>
        <p>Hiermit zeige ich – mit der Bitte um Weiterverfolgung durch Ihr Amt – folgende Geruchsbelästigung an:</p>
        <table>
            <thead>
                <tr>
                    <th rowspan=2>Datum</th>
        EOD;
        $text .= $includeTimeFrame ? "<th colspan=2>Uhrzeit</th>" : "<th rowspan=2>Uhrzeit</th>";
        $text .= <<<EOD
                    <th rowspan=2>Geruchsart</th>
                    <th rowspan=2>Geruchsintensität</th>
                    <th colspan=2>Ort</th>
                    <th colspan=3>Wind</th>
                    <th rowspan=2>Temperatur</th>
                </tr>
                <tr>
        EOD;
        $text .= $includeTimeFrame ? "<th>Von</th><th>Bis</th>" : "";
        $text .= <<<EOD
                    <th>Adresse</th>
                    <th>Koordinaten</th>
                    <th>Richtung</th>
                    <th>Geschwindigkeit</th>
                    <th>Böen</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$berlinTime->format('d.m.Y')}</td>
        EOD;
        $text .= $includeTimeFrame ? "<td>{$report->timeFrame->startTime->setTimezone(new \DateTimeZone('Europe/Berlin'))->format('H:i')}</td><td>{$report->timeFrame->endTime->setTimezone(new \DateTimeZone('Europe/Berlin'))->format('H:i')}</td>" : "<td>{$berlinTime->format('H:i')} Uhr</td>";
        $text .= <<<EOD
                    <td>{$report->stink->kind}</td>
                    <td>{$report->stink->intensity}</td>
        EOD;

        if (!is_null($report->location->address)) {
            $address = $report->location->address;
            $text .= <<<EOD
            <td>{$address->street} {$address->number}<br />
            {$address->zip} {$address->city}</td>
            EOD;
        } else {
            $text .= "<td></td>";
        }
        $text .= <<<EOD
            <td>{$coordinates->latitude}° Breite<br />
            {$coordinates->longitude}° Länge</td>
            EOD;

        $text .= <<<EOD
                    <td>{$report->weather->wind->direction}°</td>
                    <td>{$report->weather->wind->speed} m/s</td>
        EOD;
        if (!is_null($report->weather->wind->gustSpeed)) {
            $text .= "<td>{$report->weather->wind->gustSpeed} m/s</td>";
        } else {
            $text .= "<td></td>";
        }

        $text .= "
                    <td>{$temperatureCelsius}° C</td>
                </tr>
            </tbody>
        </table>
        <p>Die gemeldete Addresse ist " . ($report->location->isHome ? "" : "nicht ") . "meine Wohnanschrift.</p>
        <p>Danke, dass Sie sich durch Weiterverfolgung oben angezeigter Geruchsbelästigung für mehr Lebensqualität, saubere Luft und eine bessere Stadt einsetzen!</p>
        <p>Mit freundlichen Grüßen</p>
        <p>{$report->reporter->name}<br />
        {$report->reporter->email}</p>
        ";

        return $text;
    }
}

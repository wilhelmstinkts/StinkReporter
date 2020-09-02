<?php

namespace OpenAPIServer\Api;

use PHPUnit\Framework\TestCase;
use OpenAPIServer\Services;
use OpenAPIServer\DTOs;

class MailServiceTest extends TestCase
{

    public function testFormatWithoutAddressWintertime()
    {
        $time = \DateTime::createFromFormat(\DateTimeInterface::ISO8601, '2020-03-10T12:00:00Z', new \DateTimeZone('UTC'));
        $coordinates = new \OpenAPIServer\DTOs\Coordinates(13.36086, 52.58412);
        $location = new \OpenAPIServer\DTOs\Location(null, $coordinates);
        $stink = new \OpenAPIServer\DTOs\Stink('Biomüll', 3);
        $reporter = new \OpenAPIServer\DTOs\Reporter('Jane Doe', 'jane.doe@provider.org');
        $wind = new \OpenAPIServer\DTOs\Wind(270, 5, 9.1);
        $temperature = 20.45 + 273.15;
        $weather = new \OpenAPIServer\DTOs\Weather($temperature, $wind);
        $report = new \OpenAPIServer\DTOs\Report($location, $time, $stink, $weather, $reporter);

        $expectedMessage = <<<'EOD'
        <p>Sehr geehrte Damen und Herren,</p>
        <p>Hiermit zeige ich – mit der Bitte um Weiterverfolgung durch Ihr Amt – folgende Geruchsbelästigung an:</p>
        <table>
            <thead>
                <tr>
                    <th rowspan=2>Datum</th>
                    <th rowspan=2>Uhrzeit</th>
                    <th rowspan=2>Geruchsart</th>
                    <th rowspan=2>Geruchsintensität</th>
                    <th colspan=2>Ort</th>
                    <th colspan=3>Wind</th>
                    <th rowspan=2>Temperatur</th>
                </tr>
                <tr>                    
                    <th>Adresse</th>
                    <th>Koordinaten</th>
                    <th>Richtung</th>
                    <th>Geschwindigkeit</th>
                    <th>Böen</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>10.03.2020</td>
                    <td>13:00 Uhr</td>
                    <td>Biomüll</td>
                    <td>3</td>
                    <td></td>
                    <td>52.58412° Breite<br />
                    13.36086° Länge</td>
                    <td>270°</td>
                    <td>5 m/s</td>
                    <td>9.1 m/s</td>
                    <td>20.45° C</td>
                </tr>
            </tbody>
        </table>
        <p>Danke, dass Sie sich durch Weiterverfolgung oben angezeigter Geruchsbelästigung für mehr Lebensqualität, saubere Luft und eine bessere Stadt einsetzen!</p>
        <p>Mit freundlichen Grüßen</p>
        <p>Jane Doe<br />
        jane.doe@provider.org</p>
        EOD;

        $generatedMessage = \OpenAPIServer\Services\MailService::formatText($report);
        $generatedMessage = preg_replace("/\r|\n/", "", $generatedMessage);
        $generatedMessage = str_replace("    ", "", $generatedMessage);
        $expectedMessage = preg_replace("/\r|\n/", "", $expectedMessage);
        $expectedMessage = str_replace("    ", "", $expectedMessage);
        $this->assertEquals($expectedMessage, $generatedMessage);
    }

    public function testFormatWithAddressSummertime()
    {
        $time = \DateTime::createFromFormat(\DateTimeInterface::ISO8601, '2020-04-13T12:05:31Z', new \DateTimeZone('UTC'));
        $coordinates = new \OpenAPIServer\DTOs\Coordinates(13.36086, 52.58412);
        $adress = new \OpenAPIServer\DTOs\Address('Hertzstraße', '1', '13158', 'Berlin', 'Germany');
        $location = new \OpenAPIServer\DTOs\Location($adress, $coordinates);
        $stink = new \OpenAPIServer\DTOs\Stink('Biomüll', 3);
        $reporter = new \OpenAPIServer\DTOs\Reporter('Jane Doe', 'jane.doe@provider.org');
        $wind = new \OpenAPIServer\DTOs\Wind(270, 5, null);
        $temperature = -3.5 + 273.15;
        $weather = new \OpenAPIServer\DTOs\Weather($temperature, $wind);
        $report = new \OpenAPIServer\DTOs\Report($location, $time, $stink, $weather, $reporter);

        $expectedMessage = <<<'EOD'
        <p>Sehr geehrte Damen und Herren,</p>
        <p>Hiermit zeige ich – mit der Bitte um Weiterverfolgung durch Ihr Amt – folgende Geruchsbelästigung an:</p>
        <table>
            <thead>
                <tr>
                    <th rowspan=2>Datum</th>
                    <th rowspan=2>Uhrzeit</th>
                    <th rowspan=2>Geruchsart</th>
                    <th rowspan=2>Geruchsintensität</th>
                    <th colspan=2>Ort</th>
                    <th colspan=3>Wind</th>
                    <th rowspan=2>Temperatur</th>
                </tr>
                <tr>                    
                    <th>Adresse</th>
                    <th>Koordinaten</th>
                    <th>Richtung</th>
                    <th>Geschwindigkeit</th>
                    <th>Böen</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>13.04.2020</td>
                    <td>14:05 Uhr</td>
                    <td>Biomüll</td>
                    <td>3</td>
                    <td>Hertzstraße 1<br />
                    13158 Berlin</td>
                    <td>52.58412° Breite<br />
                    13.36086° Länge</td>
                    <td>270°</td>
                    <td>5 m/s</td>
                    <td></td>
                    <td>-3.5° C</td>
                </tr>
            </tbody>
        </table>
        <p>Danke, dass Sie sich durch Weiterverfolgung oben angezeigter Geruchsbelästigung für mehr Lebensqualität, saubere Luft und eine bessere Stadt einsetzen!</p>
        <p>Mit freundlichen Grüßen</p>
        <p>Jane Doe<br />
        jane.doe@provider.org</p>
        EOD;

        $generatedMessage = \OpenAPIServer\Services\MailService::formatText($report);
        $generatedMessage = preg_replace("/\r|\n/", "", $generatedMessage);
        $generatedMessage = str_replace("    ", "", $generatedMessage);
        $expectedMessage = preg_replace("/\r|\n/", "", $expectedMessage);
        $expectedMessage = str_replace("    ", "", $expectedMessage);
        $this->assertEquals($expectedMessage, $generatedMessage);
    }
}

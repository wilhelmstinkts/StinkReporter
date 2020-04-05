<?php

namespace OpenAPIServer\Api;

use PHPUnit\Framework\TestCase;
use OpenAPIServer\Services;

class MailServiceTest extends TestCase
{    
    public function testFormatWithoutAddress()
    {
        $report = array (
            'time' => '2020-03-10T12:00:00Z',
            'location' =>
            array (
            'coordinates' =>
            array (
            'longitude' => 52.58412,
            'latitude' => 13.36086,
            ),
            ),
            'stink' =>
            array (
            'kind' => 'Biomüll',
            'intensity' => 3,
            ),
            'reporter' =>
            array (
            'name' => 'Jane Doe',
            'email' => 'jane.doe@provider.org',
            ),
        );

        $expectedMessage=<<<'EOD'
        <p>Sehr geehrte Damen und Herren,</p>
        <p>Hiermit zeige ich – mit der Bitte um Weiterverfolgung durch Ihr Amt – folgende Geruchsbelästigung an:</p>
        <p>Geruchsstärke: 3/5<br />
        mit Belästigung: ja</p>
        <table>
            <tr>
                <td>Ort:</td>
                <td>Breitengrad: 52,58412&#730; n.B.</td>                
            </tr>
            <tr>
                <td></td>
                <td>Längengrad: 13.36086&#730; ö.L.</td>
            </tr>
            <tr>
                <td>Geruchsart:</td>
                <td>Biomüll</td>
            </tr>
            <tr>
                <td>Zeit:</td>
                <td>10.03.2020 13:00:00 Uhr</td>
            </tr>
        </table>
        <p>Danke, dass Sie sich durch Weiterverfolgung oben angezeigter Geruchsbelästigung für mehr Lebensqualität, saubere Luft und eine bessere Stadt einsetzen!</p>
        <p>Für etwaige Gerichtsverhandlungen stehe ich als Zeuge zur Verfügung. Meine oben gemachten Angaben einschließlich meiner Personalien sind zutreffend und vollständig (§ 111 OWiG). Mir ist bewusst, dass ich als Zeugin oder Zeuge zur wahrheitsgemäßen Aussage (§ 57 und § 3 161a StPO i. V. m § 46 OWiG) und auch zu einem möglichen Erscheinen vor Gericht verpflichtet bin. Vorsätzlich falsche Angaben zu angeblichen Ordnungswidrigkeiten können eine Straftat sein.</p>
        <p>Mit freundlichen Grüßen</p>
        <p>Jane Doe <br />
        jane.doe@provider.org</p>
        EOD;

        $generatedMessage = \OpenAPIServer\Services\MailService::formatText($report);
        $this->assertEquals($expectedMessage, $generatedMessage);
    }
}

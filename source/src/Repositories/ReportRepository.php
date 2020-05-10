<?php

namespace OpenAPIServer\Repositories;

use Exception;
use DateTime;
use DateTimeInterface;
use OpenAPIServer\Model;
use OpenAPIServer\DTOs;

class ReportRepository
{
    private \PDO $pdo;

    private static function dateFormat():string{
        return "Y-m-d H:i:s";
    }

    public function __construct(string $server, string $username, string $password)
    {
        $this->pdo = new \PDO($server, $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }

    public function saveReport(\OpenAPIServer\DTOs\Report $report)
    {
        $sql = "CALL InsertReport(:time, :stinkKind, :intensity, ST_GeomFromText(:coordinates, 4326), :street, :number, :zip, :city, :country)";
        $statement = $this->pdo->prepare($sql);
        $success = $statement->execute(array(
            ':time' =>  $report->time->format(ReportRepository::dateFormat()),
            ':stinkKind' => $report->stink->kind,
            ':intensity' => $report->stink->intensity,
            ':coordinates' => "POINT({$report->location->coordinates->latitude} {$report->location->coordinates->longitude})",
            ':street' => $report->location->address->street,
            ':number' => $report->location->address->number,
            ':zip' => $report->location->address->zip,
            ':city' => $report->location->address->city,
            ':country' => $report->location->address->country
        ));
        if (!$success) {
            throw new Exception("Error while writing report to database.", 1);
        }
    }

    public function getReports(): array
    {
        $sql = <<<EOD
        SELECT reports.time, reports.intensity, stink_kinds.name as stink_kind,
        ST_X(locations.coordinates) as latitude, ST_Y(locations.coordinates) as longitude,
        locations.street, locations.number, locations.zip, locations.city, locations.country
        FROM reports
        INNER JOIN locations ON reports.location_id=locations.id
        INNER JOIN stink_kinds ON reports.stink_kind_id=stink_kinds.id;
        EOD;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $arrayResult=$statement->fetchAll();
        $reports = array();
        foreach ($arrayResult as $key => $value) {
            array_push($reports, ReportRepository::toReport($value));
        }
        return $reports;
    }

    private static function toReport(array $inputArray):\OpenAPIServer\DTOs\Report
    {
        $address = new \OpenAPIServer\DTOs\Address(
            $inputArray["street"], 
            $inputArray["number"], 
            $inputArray["zip"], 
            $inputArray["city"], 
            $inputArray["country"]
        );

        $coordinates = new \OpenAPIServer\DTOs\Coordinates(
            $inputArray["longitude"],
            $inputArray["latitude"]
        );

        $location = new \OpenAPIServer\DTOs\Location(
            $address,
            $coordinates
        );

        $stink = new \OpenAPIServer\DTOs\Stink(
            $inputArray["stink_kind"],
            $inputArray["intensity"]
        );

        $datetime =  \DateTime::createFromFormat(ReportRepository::dateFormat(), $inputArray["time"], new \DateTimeZone("UTC"));

        return new \OpenAPIServer\DTOs\Report(
            $location,
            $datetime,
            $stink,
            null        
        );
    }
}

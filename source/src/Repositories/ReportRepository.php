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

    public function __construct(string $server, string $username, string $password)
    {
        $this->pdo = new \PDO($server, $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }

    public function saveReport(\OpenAPIServer\DTOs\Report $report)
    {
        $sql = "CALL InsertReport(:time, :stinkKind, :intensity, ST_GeomFromText(:coordinates, 4326), :street, :number, :zip, :city, :country)";
        $statement = $this->pdo->prepare($sql);
        $success = $statement->execute(array(
            ':time' =>  $report->time->format("Y-m-d H:i:s"),
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

    public function getReports()
    {
        $sql = <<<EOD
        SELECT reports.time, reports.intensity, stink_kinds.name as stink_kind, ST_AsText(locations.coordinates) as coordinates, 
        locations.street, locations.number, locations.zip, locations.city, locations.country
        FROM reports
        INNER JOIN locations ON reports.location_id=locations.id
        INNER JOIN stink_kinds ON reports.stink_kind_id=stink_kinds.id;
        EOD;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $arrayResult=$statement->fetchAll();
        return $arrayResult;
    }    
}

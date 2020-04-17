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

    public function __construct(string $server, string $username, string $password) {
        $this->pdo = new \PDO($server, $username, $password);
    }

    public function saveReport(\OpenAPIServer\DTOs\Report $report)
    {
       $locationId = $this->saveLocation($report->location);
       $kindId = $this->saveStinkKind($report->stink->kind);
    //    $statement = $pdo->prepare("INSERT INTO tabelle (spalte1, spalte2, splate3) VALUES (?, ?, ?)");
    //     $statement->execute(array('wert1', 'wert2', 'wert3'));
    }
}

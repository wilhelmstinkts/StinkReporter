<?php
// For test purposes only! Do not put production variables in here!
namespace Environment;
class Environment{
    public static function reportRepository() : \OpenAPIServer\Repositories\ReportRepository {
        return new \OpenAPIServer\Repositories\ReportRepository("mysql:dbname=stink_db;host=172.17.0.2", "root", "totallyunsafe");
    }
} 

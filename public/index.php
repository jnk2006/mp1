<?php
/**
 * Created by PhpStorm.
 * User: naveena
 * Date: 10/5/18
 * Time: 9:18 PM
 */

main::startcsv("student.csv");

class main
{
    public static function startcsv($filename)
    {
        $records = csv::getRecords($filename);
    }
}

class csv
{
    public static function getRecords($filename)
    {
        $file = fopen($filename, "r");
        while(!feof($file))
        {
            $record = fgetcsv($file);
            $records[] = recordFactory::create($record);
        }
        fclose($file);
        return $records;
    }
}

class record
{
    public function __construct($record)
    {
        print_r($record);
    }
}

class recordFactory
{
    public static function create(Array $array = null)
    {
        $record = new record($array);
        return $record;
    }
}
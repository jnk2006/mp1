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
        $record = recordFactory::create();
        print_r($record);
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
            $records[] = $record;
        }
        fclose($file);
        return $records;
    }
}

class record
{

}

class recordFactory
{
    public static function create(Array $array = null)
    {
        $record = new record();
        return $record;
    }
}
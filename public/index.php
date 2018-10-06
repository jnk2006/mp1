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
        $fieldNames = array();
        $count = 0;
        while(!feof($file))
        {
            $record = fgetcsv($file);
            if($count == 0)
            {
                $fieldNames = $record;
            }
            else
            {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }
        fclose($file);
        return $records;
    }
}

class record
{
    public function __construct(Array $fieldNames = null, Array $values = null)
    {
        print_r($fieldNames);
        print_r($values);
        $this->createProperty();
    }

    public function createProperty($name, $value)
    {
        $this->{$name} = $value;
    }
}

class recordFactory
{
    public static function create(Array $fieldNames = null, Array $values = null)
    {
        $record = new record($fieldNames, $values);
        return $record;
    }
}
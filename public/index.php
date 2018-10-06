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
        $table = html::generateTable($records);
        system::htmlPage($table);
    }
}

class system
{
    public static function htmlPage($page)
    {
        $fpage = '<html><head><title>CSV Table</title><link rel="stylesheet" type="text/css"
 href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/></head>';
        $fpage .= '<body>';
        $fpage .= '<table class = "table table-striped">';
        $fpage .= $page;
        $fpage .= '</table></body></html>';
        print $fpage;
    }
}

class html
{
    public static function generateTable($records)
    {
        $htmlOutput = '';
        $count = 0;
        foreach($records as $record)
        {
            if($count == 0)
            {
                $array = $record->returnArray();

                $fields = array_keys($array);
                $tablehead = self::returnHeadings($fields);
                $htmlOutput .= '<thead><tr>'.$tablehead.'</tr></thead><tbody>';

                $values = array_values($array);
                $tablerow = self::returnValues($values);
                //$htmlOutput .= '<tbody>'.$tablerow.'</tbody>';
                $htmlOutput .= $tablerow;
            }
            else
            {
                $array = $record->returnArray();
                $values = array_values($array);
                $tablerow = self::returnValues($values);
                //$htmlOutput .= '<tbody>'.$tablerow.'</tbody>';
                $htmlOutput .= $tablerow;
            }
            $count++;

            //$htmlOutput .= '</tbody>';
        }
        $htmlOutput .= '</tbody>';
        return $htmlOutput;
    }

    static public function returnHeadings($fields)
    {
        $num = count($fields);
        $tablehead = '';
        for($c = 0; $c < $num; $c++)
        {
            if(!empty($fields[$c]))
            {
                $head = $fields[$c];
            }
            else
            {
                $head = "&nbsp;";
            }
            $tablehead .= '<th>'.$head.'</th>';
        }
        return $tablehead;
    }

    static public function returnValues($values)
    {
        $tablerow = '<tr>';
        $num = count($values);
        for($c = 0; $c < $num; $c++)
        {
            if(!empty($values[$c]))
            {
                $data = $values[$c];
            }
            else
            {
                $data = "&nbsp;";
            }
            $tablerow .= '<td>'.$data.'</td>';

        }
        $tablerow .= '</tr>';
        return $tablerow;
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
        $record = array_combine($fieldNames, $values);
        foreach($record as $property => $value)
        {
            $this->createProperty($property, $value);
        }
    }

    public function returnArray()
    {
        $array = (array) $this;
        return $array;
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
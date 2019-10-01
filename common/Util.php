<?php

namespace app\common;

use Yii;


class Util
{



    public static function cleanStr($str)

    {

        $str = str_replace("\r",'', $str);
        $str = str_replace("\n",'', $str);
        $str = preg_replace('/\s+/', ' ', $str);
        $str = trim($str);

        return  $str;

    }


    public static function dateBRtoUS($data)
    {
        $output = $data ? DateTime::createFromFormat("d/m/Y", $data)->format("Y-m-d") : null;
        return $output;

    }

    public static function dateTimeUStoBR($data)
    {

        return date('d/m/Y H:i:s', strtotime($data));

    }


    public static function getExcerpt($text, $lenght)
    {


        if (strlen($text)> $lenght) {
            $text = substr($text, 0, $lenght) . "...";
        }

        return $text;

    }


    public static function getNewIdTable($tableName,$id, $enterpriseCode=null)

    {

        $sql = "
                    SELECT
                        MAX(".$id.") as max
                        FROM ".$tableName."                       
                ";

        if ($enterpriseCode){
            $sql .= " WHERE 
                    EnterpriseCode = ".$enterpriseCode."
                    ";
        }


        $sql = Util::cleanStr($sql);
        //error_log("***". $sql);

        $query_data = Yii::$app->db->createCommand($sql)->queryAll();

        $data=array();
        $data =  $query_data[0]['max']+1;
        return  $data;

    }






}

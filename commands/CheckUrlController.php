<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CheckUrlController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */

    public function getUrls()

    {

        $sql = "
                  SELECT 
                        EnterpriseCode,
                        UserCode,
                        Code,
                        Address
                    FROM 
						  Url
					WHERE 
						  Status = 1
						  
					ORDER BY Code	  					
                ";

        $sql = str_replace("\r\n",'', $sql);
        //echo "<br>".$sql;

        $query_data = Yii::$app->db->createCommand($sql)->queryAll();

        $data=array();
        $data =  $query_data;
        return  $data;

    }

    public function updateUrl($enterpriseCode, $code, $userCode, $statusCode, $response)
    {


        if ($code !== "")     {


            $query = Yii::$app->db->createCommand()->insert('Log',
                [
                    'EnterpriseCode'                    => $enterpriseCode,
                    'UserCode'                          => $userCode,
                    'UrlCode'                           => $code,
                    'DateTime'                          => date("Y-m-d H:i:s"),
                    'StatusCode'                        => $statusCode,
                    'Ip'                                => isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : '127.0.0.1',
                ]);
            //error_log("*********" . $query->getRawSql() . "**************");
            $query->execute();


            $query = Yii::$app->db->createCommand()->update('Url',
                [
                    'StatusCode'                                => $statusCode,
                    'Response'                                  => $response,
                    'DateTimeLastCheck'                         => date("Y-m-d H:i:s"),
                ],
                [
                    'EnterpriseCode' => $enterpriseCode,
                    'Code' => $code
                ]);
            //error_log("*********" . $query->getRawSql() . "**************");
            $query->execute();

        }


    }




    public function actionIndex()
    {

        $urlList = $this->getUrls();

        foreach ($urlList as $field) {

            $enterpriseCode = $field['EnterpriseCode'];
            $userCode = $field['UserCode'];
            $code = $field['Code'];
            $address = $field['Address'];




            $handle = curl_init($address);
            curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($handle, CURLOPT_TIMEOUT, 3); //timeout in seconds

            /* Get the HTML or whatever is linked in $url. */
            $response = curl_exec($handle);

            $statusCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

            curl_close($handle);





            try {

                $this->updateUrl($enterpriseCode, $code, $userCode, $statusCode, $response);

            } catch (Exception $e) {

                echo "********* Error trying update response" . $e->getMessage() . "**************";

            }



            echo "EnterpriseCode:" . $enterpriseCode . "\n";
            echo "UserCode:" . $userCode . "\n";
            echo "Code:" . $code . "\n";
            echo "Address:" . $address . "\n";
            echo "StatusCode:" . $statusCode . "\n\n\n";


        }



        return ExitCode::OK;
    }
}

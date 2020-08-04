<?php
namespace Api;

class MalformedRequestException extends \Exception
{
    function __construct($e){
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo json_encode(array('error' => $e));
        exit;
    }
}

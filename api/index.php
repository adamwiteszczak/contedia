<?php

namespace Api;

use Classes\Request;

require '../bootstrap.php';

try {
    $uri = $_SERVER['REQUEST_URI'];

    //validate the request is in the correct format, e.g. api/?method=menu.get
    $parts = explode ('?', $uri);
    if (count($parts) != 2) {
        throw new \Api\MalformedRequestException('Api request is malformed');
    }
    $method = explode('=', $parts[1]);

    if (count($method) < 2) {
        throw new \Api\MalformedRequestException('Invalid method: ' . $method[0]);
    }

    $method_parts = explode('.', $method[1]);

    if (count($method_parts) != 2) {
        throw new \Api\MalformedRequestException('Method is malformed');
    }

    $class_name = '\api\endpoint\\' . $method_parts[0];

    if (!class_exists($class_name, true)) {
        throw new \Api\MalformedRequestException('Endpoint does not exist');
    }

    $endpoint = new $class_name();
    $method = explode('&', $method_parts[1])[0];

    if (!$endpoint->methodExists($method)) {
        throw new \Api\MalformedRequestException('Requested method does not exist');
    }

    $allowed_method = $endpoint->allowedType($method);
    $request = new Request();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($allowed_method != 'POST') {
            throw new \API\MalformedRequestException('Request must be of type ' . $allowed_method );
        }

        $request->setParams($_POST);
        $request->setType('POST');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($allowed_method != 'GET') {
            throw new \API\MalformedRequestException('Request must be of type ' . $allowed_method);
        }

        $request->setParams($_GET);
        $request->setType('GET');
    }

    echo json_encode($endpoint->$method($request));

} catch (MalformedRequestException $e) {

}
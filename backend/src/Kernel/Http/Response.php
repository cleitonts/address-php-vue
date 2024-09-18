<?php

namespace App\Kernel\Http;

class Response
{
    public static function response($data): string
    {
        header('Content-Type: application/json');
        if (empty($data)) {
            http_response_code(404);
            exit();
        }

        if (is_array($data))
        {
            return json_encode($data);
        }
        return $data;
    }

    public static function xmlResponse($data): string
    {
        header('Content-Type: application/xml');
        if (empty($data)) {
            http_response_code(404);
            exit();
        }
        if (is_array($data))
        {
            $xml = new \SimpleXMLElement('<root/>');
            array_walk_recursive($data, function($value, $key) use ($xml) {
                $xml->addChild($key, $value);
            });
            return $xml->asXML();
        }
        return $data;
    }
}
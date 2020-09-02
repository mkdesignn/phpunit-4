<?php

namespace App\Api\V1\Factories;

use Exception;

class ServiceFactory
{

    public static function build($serviceClass)
    {
        $serviceClassNameSpace = 'App\\Services\\Payment\\' . $serviceClass;
        if (class_exists($serviceClassNameSpace)) {
            return new $serviceClassNameSpace;
        } else {
            new Exception("Did not find any service.");
        }

    }
}

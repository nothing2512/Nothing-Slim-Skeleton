<?php

class Validator
{

    public static function validate($data, $params, $i = 0)
    {
        $keys = array_keys($params);
        $key = $keys[$i];
        $reg = explode("|", $params[$key]);

        if(!isset($data->$key)) $data->$key = "";
        
        $checker = Validator::check($key, $data->$key, $reg);

        if($checker->status == false) return $checker;

        if ($i < sizeof($params) - 1) return Validator::validate($data, $params, $i + 1);

        return (object) ["status" => true];
    }

    private static function check($key, $data, $reg, $i = 0)
    {
        if($reg[$i] == "required" && ($data == "" || $data == null)) return (object) [
            "status"    => false,
            "message"   => "$key must not be null"
        ];

        if($reg[$i] == "text" && is_numeric($data)) return (object) [
            "status"    => false,
            "message"   => "$key must not be numeric"
        ];

        if($reg[$i] == "email" && !filter_var($data, FILTER_VALIDATE_EMAIL)) return (object) [
            "status"    => false,
            "message"   => "email address is not valid"
        ];

        if(($reg[$i] == "number" || $reg[$i] == "num" || $reg[$i] == "numeric") && !is_numeric($data))  return (object) [
            "status"    => false,
            "message"   => "$key must be numeric"
        ];

        if ($reg[$i] == "not_space" && strpos($data, ' ') !== false) return (object) [
            "status"    => false,
            "message"   => "$key must not contain space"
        ];

        if ($reg[$i] == "special" && !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $data)) return (object) [
            "status"    => false,
            "message"   => "$key must contains special characters"
        ];

        if ($reg[$i] == "not_special" && preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $data)) return (object) [
            "status"    => false,
            "message"   => "$key must not contains special characters"
        ];

        if (strpos($reg[$i], "min") !== false) {
            try {
                
                $size = explode(":", $reg[$i]);
                $size = end($size);

                if (strlen($data) < $size) return (object) [
                    "status"    => false,
                    "message"   => "$key length must $size or more"
                ];
            } catch(Exception $e) {}
        }

        if (strpos($reg[$i], "max") !== false) {
            try {
                
                $size = explode(":", $reg[$i]);
                $size = end($size);

                if (strlen($data) > $size) return (object) [
                    "status"    => false,
                    "message"   => "$key length must $size or less"
                ];
            } catch(Exception $e) {}
        }

        if ($i < sizeof($reg) - 1) return Validator::check($key, $data, $reg, $i + 1);

        return (object) ["status" => true];
    }
}

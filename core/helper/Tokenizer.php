<?php

class Tokenizer 
{

    public static function generate($data)
    {
        $path = Tokenizer::getPath($data);
        $generated = encrypt($data . date("YmdHis"));
        $file = fopen($path, "w");
        fwrite($file, $generated);
        fclose($file);
        return $generated;
    }

    public static function get($data)
    {
        $path = Tokenizer::getPath($data);

        if (!file_exists($path)) return Tokenizer::generate($data);

        $file = fopen($path, "r");
        $data = fread($file, filesize($path));
        fclose($file);

        return $data;
    }

    private static function getPath($data)
    {
        $path = str_replace("helper", "temp\\", __DIR__);
        $filename = encrypt($data);
        return $path . $filename;
    }
}
<?php

class RequestFile 
{

    private $ext;
    private $location;
    private $host;
    private $path;

    public $uri;

    public function __construct($file)
    {
        $ext = explode(".", $file['name']);
        $path = explode("core", __DIR__);

        $this->ext = end($ext);
        $this->location = $file['tmp_name'];
        $this->uri = "";
        $this->path = $path[0] . "storage\\";
        $this->host = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/" . explode("/", $_SERVER['REQUEST_URI'])[1];
    }

    public function upload($folder)
    {
        $dir = $this->path . $folder . "\\";

        if(!file_exists($dir)) mkdir($dir);

        $filename = date("YmdHis") . "." . $this->ext;
        move_uploaded_file($this->location, $dir . $filename);
        $this->uri = $this->host . "/storage/$folder/$filename";
    }
}
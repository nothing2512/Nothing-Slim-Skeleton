<?php

function encrypt($data) 
{
    $project = explode('/', $_SERVER['REQUEST_URI'])[1];
    $project = base64_encode($project);
    return base64_encode(md5($data) . md5($project));
}
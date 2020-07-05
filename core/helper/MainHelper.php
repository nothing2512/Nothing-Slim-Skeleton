<?php

function encrypt($data) 
{
    $project = explode('/', $_SERVER['REQUEST_URI'])[1];
    $project = base64_encode($project);
    return base64_encode(md5($data) . md5($project));
}

function paging($data, $page, $length)
{
    $size = sizeof($data);
    $offsetStart = ($page - 1) * $length;
    $offsetEnd = $page * $length;

    $total = ceil($size / $length);
    array_splice($data, $offsetEnd, $size);
    array_splice($data, 0, $offsetStart);

    return [
        "page"      => $page,
        "totalPage" => $total,
        "totalData" => $size,
        "data"      => $data
    ];
}
<?php
return function ($mname) {
    $tempPath = "./core/template/middleware";
    $tempFile = fopen($tempPath, 'r');
    $tempData = fread($tempFile, filesize($tempPath));
    fclose($tempFile);

    $data = str_replace("{{MW}}", $mname, $tempData);

    $file = fopen("./public/middlewares/$mname.php", 'w');
    fwrite($file, $data);
    fclose($file);
};

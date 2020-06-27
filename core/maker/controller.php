<?php
return function ($cname) {
    $tempPath = "./core/template/controller";
    $tempFile = fopen($tempPath, 'r');
    $tempData = fread($tempFile, filesize($tempPath));
    fclose($tempFile);

    $data = str_replace("{{CONTROLLER_NAME}}", $cname, $tempData);

    $file = fopen("./public/controllers/${cname}Controller.php", 'w');
    fwrite($file, $data);
    fclose($file);
};

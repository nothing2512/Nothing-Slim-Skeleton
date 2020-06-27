<?php
return function ($mname) {
    $tempPath = "./core/template/model";
    $tempFile = fopen($tempPath, 'r');
    $tempData = fread($tempFile, filesize($tempPath));
    fclose($tempFile);

    $data = str_replace("{{MODEL_NAME}}", $mname, $tempData);

    $file = fopen("./public/models/$mname.php", 'w');
    fwrite($file, $data);
    fclose($file);
};

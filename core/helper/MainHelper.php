<?php

function encrypt($data) 
{
    return base64_encode(md5($data) . md5($data));
}
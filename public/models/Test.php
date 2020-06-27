<?php

namespace App\Models;

use Connection;

class Test extends Connection
{
    public function test()
    {
        $this->query("SELECT * FROM `data`");
        return $this->fetchAll();
    }
}
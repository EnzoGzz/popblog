<?php

namespace Utils\Database\Gateway;

use Utils\Database\DB;

class Gateway
{
    protected DB $con;

    public function __construct(DB $con){
        $this->con = $con;
    }
}
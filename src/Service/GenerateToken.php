<?php

namespace App\Service;


class GenerateToken
{
    public function generateToken()
    {
        return md5(time());
    }
}
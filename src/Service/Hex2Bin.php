<?php

declare(strict_types=1);

namespace App\Service;

class Hex2Bin {
    /**
     * @param string hexa
     * @return string
     */
    public function setHex2Bin(string $hexa = null): string
    {
        return hex2bin(str_replace('-','', $hexa));
    }
}
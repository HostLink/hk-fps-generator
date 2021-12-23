<?php

namespace HL\FPS;

use HL\FPS\Util\CRC;

class Generator
{
    function generate(EMV $emv): string
    {
        $encoder = new Encoder();


        $msg = $encoder->encode($emv);

        $crc = CRC::Calculate($msg);

        //to hex
        $crc = dechex($crc);
        $crc = str_pad($crc, 4, '0', STR_PAD_LEFT);
        $crc = strtoupper($crc);
        return $msg . $crc;
    }
}

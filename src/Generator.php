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
        return $msg . $crc;
    }
}

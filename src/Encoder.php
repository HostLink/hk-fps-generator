<?php


namespace HL\FPS;

class Encoder
{



    function pad($str, $len)
    {
        return str_pad($str, $len, '0', STR_PAD_LEFT);
    }

    function dataObj($id, $value)
    {

        $paddedLength = $this->pad(strlen($value), 2);
        return $id . $paddedLength . $value;
    }


    function encode(EMV $obj)
    {
        $payloadFormatIndicator = $this->dataObj("00", "01");
        $pointOfInitiationMethod = $this->dataObj("01", ($obj->amount == "") ? "11" : "12");

        $guid = $this->dataObj("00", "hk.com.hkicl");
        $merchantAccountInformationTemplate = "";

        switch ($obj->account) {
            case "02":
                $merchantAccountInformationTemplate = $this->dataObj("02", $obj->fps_id);
                break;
            case "03":
                $merchantAccountInformationTemplate = $this->dataObj("01", $obj->bank_code) + $this->dataObj("03", $obj->mobile);
                break;
            case "04":
                $merchantAccountInformationTemplate = $this->dataObj("01", $obj->bank_code) + $this->dataObj("04", strtoupper($obj->email));
                break;
        }

        $merchantAccountInformation = $this->dataObj("26", $guid . $merchantAccountInformationTemplate);
        $merchantCategoryCode = $this->dataObj("52", $obj->mcc);
        $transactionCurrency = $this->dataObj("53", $obj->currency);
        $countryCode = $this->dataObj("58", "HK");
        $merchantName = $this->dataObj("59", "NA");
        $merchantCity = $this->dataObj("60", "HK");
        $transactionAmount = ($obj->amount == "") ? "" : $this->dataObj("54", $obj->amount);
        $reference = ($obj->reference == "") ? "" : $this->dataObj("05", $obj->reference);
        $additionalDataTemplate = ($reference == "") ? "" : $this->dataObj("62", $reference);

        $msg = "";
        $msg .= $payloadFormatIndicator;
        $msg .= $pointOfInitiationMethod;
        $msg .= $merchantAccountInformation;

        $msg .= $merchantCategoryCode;
        $msg .= $transactionCurrency;
        $msg .= $countryCode;
        $msg .= $merchantName;
        $msg .= $merchantCity;
        $msg .= $transactionAmount;
        $msg .= $additionalDataTemplate;
        $msg .= "6304";

        return $msg;
    }
}

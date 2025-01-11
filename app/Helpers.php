<?php

namespace App;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class Helpers
{
    public static function mb_ucfirst (string $string, string $encoding = "UTF-8") {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_strtolower(mb_substr($string, 1));
    }

    public static function generateRandomPassword ($length = 10) : string {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&^*()\/_|§~¢";
        $password = "";
        for ((int)$i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
    }

    public static function formatPhoneNumber ($phoneNumber) : string
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $phoneProto = $phoneUtil->parse($phoneNumber);
        $formattedPhone = $phoneUtil->format($phoneProto, PhoneNumberFormat::E164);
        return $formattedPhone;
    }

}

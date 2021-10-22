<?php

declare(strict_types=1);

namespace App\Enums;

abstract class CountriesEnum
{
    const COUNTRIES_CODES = [
        '237' => [
            "regex" => "\(237\)\ ?[2368]\d{7,8}$",
            "country" => "Cameroon",
        ],
        '251' => [
            "regex" => "\(251\)\ ?[1-59]\d{8}$",
            "country" => "Ethiopia",
        ],
        '212' => [
            "regex" => "\(212\)\ ?[5-9]\d{8}$",
            "country" => "Morocco",
        ],
        '258' => [
            "regex" => "\(258\)\ ?[28]\d{7,8}$",
            "country" => "Mozambique",
        ],
        '256' => [
            "regex" => "\(256\)\ ?\d{9}$",
            "country" => "Mozambique",
        ],
    ];


    public static function getAllRegex($imploded=false)
    {
        $countriesCodes = self::COUNTRIES_CODES;
        $regex = [];
        foreach ($countriesCodes as $code => $value) {
            $regex[] = $value['regex'];
        }
        if($regex){
            return implode("|",$regex);
        }
        return $regex;
    }
}

<?php
namespace App\Lang;

enum Lang:string{
    case En = 'en';
    case Ar = 'ar';
    case Tr = 'tr';
    public function label():string{
        return match($this){
            self::En => 'English',
            self::Ar => 'عربي',
    };
}}



<?php

namespace Pion;

class Color{
    
    public static function red (){
        echo "\e[31m";
    }
    public static function green (){
        echo "\e[32m";
    }
    public static function blue (){
        echo "\e[34m";
    }
    
    public static function yellow (){
        echo "\e[33m";
    }
    
    public static function black (){
        echo "\e[30m";
    }

    
    public static function white (){
        echo "\e[97";
    }
    

    public static function reset (){
        echo "\e[39m";
    }


    
    public static function redBG(){
        echo "\e[41m";
    }
    public static function greenBG(){
        echo "\e[42m";
    }
    public static function blueBG(){
        echo "\e[44m";
    }
    
    public static function yellowBG(){
        echo "\e[43m";
    }
    
    public static function blackBG(){
        echo "\e[40m";
    }

    
    public static function whiteBG(){
        echo "\e[107";
    }

    
    public static function resetBG(){
        echo "\e[49m";
    }
    
}
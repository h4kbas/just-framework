<?php namespace Just\Util;

class Time {
    public static function now($format = "Y-m-d h:i:s"){
        return date($format);
    }
}
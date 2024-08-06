<?php

namespace app;

class Commons {
    
    public static function stringIdsToArray($s){
        return explode(",", str_replace(["\"", " "], "", substr($s, 1, strlen($s) - 2)));
    }
}
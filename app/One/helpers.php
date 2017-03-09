<?php

/**
 * Author: hefengbao
 * Date: 2016/11/8
 * Time: 17:00
 */

if(!function_exists('makeExcerpt')){
    function makeExcerpt($html)
    {
        $excerpt = trim(preg_replace('/\s\s+/', ' ', strip_tags($html)));
        return str_limit($excerpt, 200);
    }
}
/*
if(!function_exists('isActiveRoute')){
    function isActiveRoute($route, $output='active'){
           if (Route::current() == $route){
               return $output;
           }
    }
}*/

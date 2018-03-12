<?php

if (!function_exists('makeExcerpt')) {
    function makeExcerpt($html)
    {
        $excerpt = trim(preg_replace('/\s\s+/', ' ', strip_tags($html)));
        return str_limit($excerpt, 200);
    }
}

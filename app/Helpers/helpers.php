<?php

if (! function_exists('convert_image')) {
    function convert_image($path): String
    {
        if ($path) {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $image = base64_encode(file_get_contents($path));
            return "data:image/" . $ext . ";base64," . $image;
        } else {
            return "";
        }
    }
}
if (! function_exists('bong_format')) {
    function bong_format($value): String
    {
        $number = number_format($value, 2);
        if (fmod($value, 1) == 0) {
            return number_format($value);
        }
        return  $number;
    }
}
if (! function_exists('bong_ordinal')) {
    function bong_ordinal($number): String
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13))
            return $number . 'th';
        else
            return $number . $ends[$number % 10];
    }
}

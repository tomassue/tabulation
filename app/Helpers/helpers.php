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
if (! function_exists('bong_ordinal_new')) {
    function bong_ordinal_new($number): String
    {
        if ($number == 1) {
            return "GRAND CHAMPION";
        } else if ($number == 2) {
            return "1ST RUNNER UP";
        } else if ($number == 3) {
            return "2ND RUNNER UP";
        }
        $number -= 1;
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13))
            return $number . 'th';
        else
            return $number . $ends[$number % 10];
    }
}
if (! function_exists('bong_font_changer')) {
    function bong_font_changer($participants): String
    {
        if (strlen($participants) <= 16) {
            $font = '11rem';
        } elseif (strlen($participants) > 16 && strlen($participants) <= 30) {
            $font = '8rem';
        } elseif (strlen($participants) > 30 && strlen($participants) <= 40) {
            $font = '6rem';
        } else {
            $font = '4rem';
        }
        return $font;
    }
}

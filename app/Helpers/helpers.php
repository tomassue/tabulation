<?php

use PhpParser\Node\Expr\Array_;

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
        } else if ($number == 4) {
            return "3RD RUNNER UP";
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
if (! function_exists('bong_rank_arranger')) {
    function bong_rank_arranger($grands, $label, $ordinalLabel, $skip = false, $sort = "ASC"): array
    {
        //$label = 'grand_total';
        //$ordinalLabel = 'ordinal_rank';

        // After collecting all participants, sort by grand total to get rankings
        if ($sort == "ASC") {
            usort($grands, function ($a, $b) use ($label) {
                return $a[$label] <=> $b[$label]; // Ascending order (lowest first)
            });
        } else if ($sort == "DESC") {
            usort($grands, function ($a, $b) use ($label) {
                return $b[$label] <=> $a[$label]; // Descending order (highest first)
            });
        }

        $rank = 1;
        $previousScore = null;

        // Add ordinal ranking
        foreach ($grands as $index => &$participantData) {
            if ($skip) {
                if ($previousScore !== null && $participantData[$label] != $previousScore) {
                    $rank = $index + 1;
                }
            } else {
                if ($previousScore === null) {
                    // First participant
                    $participantData[$ordinalLabel] = $rank;
                } else {
                    if ($participantData[$label] == $previousScore) {
                        // Same grand total, same rank
                        $participantData[$ordinalLabel] = $rank;
                    } else {
                        // Different grand total, next sequential rank
                        $rank++;
                        $participantData[$ordinalLabel] = $rank;
                    }
                }
            }

            $participantData[$ordinalLabel] = $rank;
            $previousScore = $participantData[$label];
        }
        return $grands;
    }
}

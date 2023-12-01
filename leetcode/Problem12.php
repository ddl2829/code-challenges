<?php


function intToRoman($num) {
    $numeralMap = [
        1000 => 'M',
        900 => 'CM',
        500 => 'D',
        400 => 'CD',
        100 => 'C',
        90 => 'XC',
        50 => 'L',
        40 => 'XL',
        10 => 'X',
        9 => 'IX',
        5 => 'V',
        4 => 'IV',
        1 => 'I'
    ];
    $stringOut = "";
    foreach($numeralMap as $value => $numeral) {
        while($num >= $value) {
            $stringOut .= $numeral;
            $num -= $value;
        }
    }
    return $stringOut;
}

echo intToRoman(3) . "\n";
echo intToRoman(58) . "\n";
echo intToRoman(1994) . "\n";
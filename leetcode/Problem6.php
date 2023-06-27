<?php


function convert($s, $numRows) {
    $rows = array_fill(0, $numRows, '');
    $currentRow = 0;
    $dir = 1;
    $characters = str_split($s);
    while(count($characters) > 0) {
        $rows[$currentRow] .= array_shift($characters);
        if($dir === 1 && $currentRow === $numRows - 1) {
            $dir = -1;
        } else if($dir === -1 && $currentRow === 0) {
            $dir = 1;
        }
        $currentRow += $dir;
    }
    return implode('', $rows);
}

echo convert("PAYPALISHIRING", 3) . "\n";
echo "PAHNAPLSIIGYIR";
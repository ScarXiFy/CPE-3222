<?php

$number = 1234567.8910;

$format1 = number_format($number);

$format2 = number_format($number, 2);

$format3 = number_format($number, 2, '.', ',');

echo "Original Number: " . $number . "<br>";

echo "Format 1 (default): " . $format1 . "<br>";
echo "Format 2 (2 decimal places): " . $format2 . "<br>";
echo "Format 3 (2 decimal places with custom separators): " . $format3 . "<br>";

?>
<?php

$i = 1;
$fontSize = 1;

do {
    echo "<p style='font-size: {$fontSize}px;'>$i</p>";
    $i++;
    $fontSize++;
} while ($i <= 30 && $fontSize <= 30);

?>
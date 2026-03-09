<?php

echo "<table border='1' style='border-collapse: collapse;'>";

echo "<tr>";
echo "<th style='background-color: green; color: white;'>Odd Numbers</th>";
echo "<th style='background-color: green; color: white;'>Even Numbers</th>";
echo "</tr>";

for ($i = 1; $i <= 100; $i += 2) {

    echo "<tr>";

    echo "<td style='background-color: white;'>" . $i . "</td>";

    if ($i + 1 <= 100) {
        echo "<td style='background-color: white;'>" . ($i + 1) . "</td>";
    }

    echo "</tr>";
}

echo "</table>";

?>
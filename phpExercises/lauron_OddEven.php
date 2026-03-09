<?php

echo "<table style='border-collapse: collapse; width: 50%; margin: 20px auto; font-family: Arial, sans-serif;'>";
echo "<tr>";
echo "<th style='border: 2px solid black; padding: 8px; text-align: center; background-color: green; color: white; font-size: 18px;'>Odd Numbers</th>";
echo "<th style='border: 2px solid black; padding: 8px; text-align: center; background-color: green; color: white; font-size: 18px;'>Even Numbers</th>";
echo "</tr>";

for ($i = 1; $i <= 100; $i += 2) {
    echo "<tr>";
    echo "<td style='border: 2px solid black; padding: 8px; text-align: center; background-color: white;'>" . $i . "</td>";
    if (($i + 1) <= 100) {
        echo "<td style='border: 2px solid black; padding: 8px; text-align: center; background-color: white;'>" . ($i + 1) . "</td>";
    }
    echo "</tr>";
}

echo "</table>";

?>
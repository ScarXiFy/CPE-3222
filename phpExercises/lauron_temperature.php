<?php

echo "<table border = 1>";
echo "<tr>";
echo "<th>Temperature (°C)</th>";
echo "<th>Temperature (°F)</th>";
echo "</tr>";

for ($celsius = 0; $celsius <= 100; $celsius++) {

    $farenheit = ($celsius * 9 / 5) + 32;

    echo "<tr>";
    echo "<td>$celsius</td>";
    echo "<td>$farenheit</td>";
    echo "</tr>";
}

echo "</table>";

?>
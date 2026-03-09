<?php

$quarantineNumber = 21700003;
$lastDigit = $quarantineNumber % 10;

$today = date("l");

$allowed = false;

if ($today == "Sunday") {
    $allowed = false;
} elseif ($lastDigit % 2 != 0) {
    if ($today == "Monday" || $today == "Wednesday" || $today == "Friday") {
        $allowed = true;
    }
} else {
    if ($today == "Tuesday" || $today == "Thursday" || $today == "Saturday") {
        $allowed = true;
    }
}

echo "<p>Quarantine Number: $quarantineNumber</p>";
echo "<p>Today's Day: $today</p>";
echo "<p>Last Digit: $lastDigit</p>";

if ($allowed) {
    echo "You are allowed to go outside today.";
} else {
    echo "You are NOT allowed to go outside today.";
}

?>
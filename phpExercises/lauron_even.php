<?php

$number = 8.2;

$result = is_numeric($number)
	? (
		(round($number) % 2 == 0)
		? "The number " . round($number) . " is EVEN."
		: "The number " . round($number) . " is ODD."
	 ) : "The value is NOT a numeric number.";

echo "Original Number: " . $number . "<br>";
echo $result;

?>
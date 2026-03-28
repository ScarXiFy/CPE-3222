<?php
    $creditCardNumber = "1234 - 5678 - 9101 - 1213";
    echo "Credit Card Number: " . $creditCardNumber . "<br>";

    // Removing the dashes and spaces from the credit card number
    $creditCardNumber = str_replace(['-', ' '], '', $creditCardNumber);

    // Checking if the credit card number is 16 digits long
    if (preg_match('/^\d{16}$/', $creditCardNumber)) 
        echo "TRANSACTION SUCCESSFUL";
    else 
        echo "TRANSACTION FAILED";
?>
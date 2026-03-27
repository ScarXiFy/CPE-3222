<?php
    $hashes = 
    [
        'f4552671f8909587cf485ea990207f3b',
        '647bba344396e7c8170902bcf2e15551',
        '2afe4567e1bf64d32a5527244d104cea'
    ];

    $pins = [];

    foreach ($hashes as $hash) {
        
        // Printing the Hash value onto screen
        echo "Hash: $hash<br>";

        for ($pin = 0; $pin <= 999; $pin++) {
            if (md5(str_pad($pin, 3, '0', STR_PAD_LEFT)) === $hash) 
            {
                $pins[] = $pin;
                break;
            }
        }
    }
    foreach ($pins as $pin) {
        echo "PIN: $pin<br>";
    }
?>
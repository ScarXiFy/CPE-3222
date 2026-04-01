<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $creditCardNumber = $_POST["creditCardNumber"];
        echo "Credit Card Number: " . $creditCardNumber . "<br>";
        // Removing the dashes and spaces from the credit card number
        $creditCardNumber = str_replace(['-', ' '], '', $creditCardNumber);

        // Checking if the credit card number is 16 digits long
        if (preg_match('/^\d{16}$/', $creditCardNumber)) 
            echo "TRANSACTION SUCCESSFUL";
        else 
            echo "TRANSACTION FAILED";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What's my Card Number Again? | 7-1 | Ratificar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>What's my Card Number Again?</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="creditCardNumber">Enter Credit Card Number:</label>
        <input type="text" id="creditCardNumber" name="creditCardNumber" required>
        <button type="submit">Submit</button>
    </form>

    <?php if (!empty($result)): ?>
    <p><?php echo $result; ?></p>
    <?php endif; ?>
    
</body>
</html>
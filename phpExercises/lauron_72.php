<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiplication Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        h2 {
            margin-top: 20px;
            text-align: center;
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
            text-align: center;
            border: 1px solid #ccc;
        }
        form {
            text-align: center;
            margin-top: 20px;
            position: sticky;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="submit"] {
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <h1>Multiplication Table</h1>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="number">Enter a number:</label>
        <input type="text" name="number" id="number">
        <input type="submit" value="Generate Table">
    </form>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $n = $_POST["number"];
            
            // Validate: must be numeric, positive, and a whole number
            if (is_numeric($n) && $n > 0 && $n == round($n)) 
            {
                $n = intval($n);
                echo "<h2>Multiplication Table for $n</h2>";
                echo "<table>";
                for ($i = 1; $i <= $n; $i++) 
                {
                    echo "<tr>";
                    for ($j = 1; $j <= $n; $j++) 
                        echo "<td>" . ($i * $j) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } 
            else 
                echo "<p style='text-align: center; color: red;'>Please enter a valid positive whole number.</p>";
        }
    ?>
</body>
</html>
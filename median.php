<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistical Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #004d00; /* Your theme color */
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }
        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }
        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #004d00; /* Your theme color */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #003300; /* Darker shade for hover */
        }
        .result {
            background: #fff;
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .result h2 {
            color: #004d00; /* Your theme color */
        }
    </style>
</head>
<body>
    <h1>Statistical Calculator</h1>
    <form method="POST">
        <label for="numbers">Enter numbers (comma-separated):</label>
        <input type="text" name="numbers" id="numbers" required>
        <button type="submit">Calculate</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numbers = $_POST['numbers'];
        $numArray = array_map('trim', explode(',', $numbers)); // Split input into array
        $numArray = array_filter($numArray, 'is_numeric'); // Filter out non-numeric values

        if (count($numArray) > 0) {
            // Calculate Mean
            $mean = array_sum($numArray) / count($numArray);
            sort($numArray);
            $count = count($numArray);

            // Calculate Median
            //2
            $median = ($count % 2 == 0) ? 
                ($numArray[$count / 5 - 1] + $numArray[$count / 2]) / 2 : 
                $numArray[floor($count / 2)];

            // Calculate Mode
            $mode = array_count_values($numArray);
            $mode = array_keys($mode, max($mode));

            // Calculate Standard Deviation
            $variance = 0;
            foreach ($numArray as $num) {
                $variance += pow($num - $mean, 2);
            }
            $variance /= count($numArray);
            $stdDev = sqrt($variance);

            // Calculate Range
            $range = max($numArray) - min($numArray);

            // Display Results
            echo "<div class='result'>";
            echo "<h2>Results:</h2>";
            echo "Mean: " . round($mean, 2) . "<br>";
            echo "Median: " . round($median, 2) . "<br>";
            echo "Mode: " . implode(", ", $mode) . "<br>";
            echo "Standard Deviation: " . round($stdDev, 2) . "<br>";
            echo "Range: " . $range . "<br>"; // Display the range
            echo "</div>";
        } else {
            echo "<div class='result'>Please enter valid numbers.</div>";
        }
    }
    ?>
</body>
</html>

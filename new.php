<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistical Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="submit"] {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .result {
            background-color: #e7ffe7;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Statistical Calculator</h1>
        <form method="post">
            <label for="numbers">Enter at least 10 numbers (comma-separated):</label>
            <input type="text" id="numbers" name="numbers" placeholder="e.g. 5.6, 3, 7.8, 10.5" required>
            <input type="submit" value="Calculate Statistics">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $numbersInput = $_POST["numbers"];
            $numbersArray = explode(',', $numbersInput);

            // Filter and validate numbers (allow integers and decimals)
            $numbers = [];
            $invalidInput = false;

            foreach ($numbersArray as $number) {
                $number = trim($number); // Remove any extra spaces

                // Validate if the input is a valid number (integer or decimal)
                if (is_numeric($number)) {
                    $numbers[] = floatval($number); // Convert to float for calculations
                } else {
                    $invalidInput = true;
                    break;
                }
            }

            // Check if there are fewer than 10 numbers or if any invalid input was entered
            if (count($numbers) < 10) {
                echo "<p class='error'>Please enter at least 10 numbers.</p>";
            } elseif ($invalidInput) {
                echo "<p class='error'>Invalid input! Please enter only numeric values (whole numbers or decimals).</p>";
            } else {
                // Calculate the Mean
                $mean = array_sum($numbers) / count($numbers);

                // Calculate the Median
                sort($numbers);
                $middleIndex = floor((count($numbers) - 1) / 2);
                if (count($numbers) % 2 == 0) {
                    $median = ($numbers[$middleIndex] + $numbers[$middleIndex + 1]) / 2;
                } else {
                    $median = $numbers[$middleIndex];
                }

                // Calculate the Mode (Handle floats by rounding to 2 decimal places)
                $roundedNumbers = array_map(function($num) {
                    return round($num, 2); // Round to 2 decimal places for mode calculation
                }, $numbers);

                $valuesCount = array_count_values($roundedNumbers);
                $maxFrequency = max($valuesCount);
                $modes = array_keys($valuesCount, $maxFrequency);

                if ($maxFrequency == 1) {
                    $mode = "No mode";
                } else {
                    $mode = implode(', ', $modes);
                }

                // Calculate the Range
                $range = max($numbers) - min($numbers);

                // Calculate the Standard Deviation
                $meanDiffs = array_map(fn($num) => pow($num - $mean, 2), $numbers);
                $variance = array_sum($meanDiffs) / count($numbers);
                $standardDeviation = sqrt($variance);

                // Display results
                echo "<div class='result'>
                        <h3>Results</h3>
                        <p><strong>Mean:</strong> " . round($mean, 2) . "</p>
                        <p><strong>Median:</strong> " . round($median, 2) . "</p>
                        <p><strong>Mode:</strong> " . $mode . "</p>
                        <p><strong>Range:</strong> " . round($range, 2) . "</p>
                        <p><strong>Standard Deviation:</strong> " . round($standardDeviation, 2) . "</p>
                      </div>";
            }
        }
        ?>
    </div>
</body>
</html>

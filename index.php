<!DOCTYPE html>
<html>
<head>
    <title>rabiatul_assignment_junior</title>
    <style>
        body {
            font-family: Verdana, sans-serif;
            font-size: 10px;
        }
        .container {
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        table {
            width: 50%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        input[type="text"] {
            width: 100%;
            padding: 5px;
        }
        input[type="submit"] {
            display: block;
            margin: 20px auto;
            padding: 10px;
            border: 2px solid blue;
            border-radius: 5px;
            background-color: white;
            color: grey;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: blue;
            color: white;
        }
        p {
            font-size: 15px;
        }
        form {
            width: 50%;
        }
        .box {
            color: blue;
            margin-top: 10px;
            border: 1px solid blue;
            padding-left: 10px;
            width: 50%;
        }
    </style>
</head>
<body>
    <main>
        <div class="container">
            <h1 style="margin-bottom: 30px;">Calculate</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <p>Voltage</p>
                <input type="text" name="voltage" required> Voltage (V)
                <p>Current</p>
                <input type="text" name="current" required> Ampere (A)
                <p>Current Rate</p>
                <input type="text" name="current_rate" required> sen/kWh
                <input type="submit" value="Calculate">
            </form>

            <?php
            function calculate_power($voltage, $current) {
                return $voltage * $current;
            }

            function convert_rate_to_rm($current_rate) {
                return $current_rate / 100;
            }

            function calculate_energy($power, $hours) {
                return ($power * $hours) / 1000;
            }

            function calculate_total_cost($energy, $rate_rm) {
                return $energy * $rate_rm;
            }

            function display_results($voltage, $current, $current_rate) {
                if (is_numeric($voltage) && is_numeric($current) && is_numeric($current_rate)) {
                    $voltage = floatval($voltage);
                    $current = floatval($current);
                    $current_rate = floatval($current_rate);

                    $power = calculate_power($voltage, $current);
                    $power_kw = $power / 1000;
                    $rate_rm = convert_rate_to_rm($current_rate);

                    echo "<div class='box'>";
                    echo "<p>POWER: $power_kw kW</p>";
                    echo "<p>RATE: $rate_rm RM</p>";
                    echo "</div>";
                    echo "<br>";

                    echo "<table>";
                    echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>Hour</th>";
                    echo "<th>Energy (kWh)</th>";
                    echo "<th>Total (RM)</th>";
                    echo "</tr>";

                    for ($hour = 1; $hour <= 24; $hour++) {
                        $index = $hour;
                        $energy_kWh = calculate_energy($power, $hour);
                        $total_cost = number_format(calculate_total_cost($energy_kWh, $rate_rm), 2);

                        echo "<tr>";
                        echo "<td><strong>$index</strong></td>";
                        echo "<td>$hour</td>";
                        echo "<td>$energy_kWh</td>";
                        echo "<td>$total_cost</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p style='color: red;'>Invalid input. Please ensure all inputs are numeric.</p>";
                }
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $voltage = $_POST["voltage"];
                $current = $_POST["current"];
                $current_rate = $_POST["current_rate"];
                display_results($voltage, $current, $current_rate);
            }
            ?>
        </div>
    </main>
</body>
</html>

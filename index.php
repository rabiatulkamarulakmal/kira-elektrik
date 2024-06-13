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
        p{
            font-size: 15px;
        }
        form{
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
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <p>Voltage</p>
                <input type="text" name="voltage" required>Voltage(V)
                <p>Current</p>
                <input type="text" name="current" required>Ampere(A)
                <p>CURRENT RATE</p>
                <input type="text" name="current_rate" required>sen/kWh
                <input type="submit" value="Calculate">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // from input
                $voltage = $_POST["voltage"];
                $current = $_POST["current"];
                $current_rate = $_POST["current_rate"];

                // is_numeric = numbering
                if (is_numeric($voltage) && is_numeric($current) && is_numeric($current_rate)) {
                    $voltage = floatval($voltage);
                    $current = floatval($current);
                    $current_rate = floatval($current_rate);

                    // power in kW
                    $power = $voltage * $current;
                    $power_kw = $power/1000;

                    // Calculate rate in RM
                    $rate_rm = $current_rate / 100; // Convert cents to RM

                    echo "<div class='box'>";
                    echo "<p>POWER: $power_kw kw</p>";
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

                    // Loop through each hour and calculate Energy and Total cost
                    for ($hour = 1; $hour <= 24; $hour++) {
                        $index = $hour; // Use the loop index for the numbering
                        $energy_kWh = ($power * $hour) / 1000; 
                        $total_cost = number_format($energy_kWh * ($current_rate/100), 2); // Total cost in RM

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
            ?>
        </div>
    </main>
</body>
</html>

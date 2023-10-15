<?php
require_once "Dice.php";

// Initialize variables
$totalRolls = 0;
$rollsByDice = array();
$rolledValues = array(); // Initialize an empty array to store rolled dice
$maxDice = 500; // Define the maximum allowed dice

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["num_dice"]) &&
        is_numeric($_POST["num_dice"]) &&
        $_POST["num_dice"] > 0 &&
        $_POST["num_dice"] <= $maxDice
    ) {
        $totalRolls++;

        // Get the selected number of sides from the form
        $numSides = (int)$_POST["num_sides"];

        // Create Dice objects and roll them
        for ($i = 0; $i < $_POST["num_dice"]; $i++) {
            $dice = new Dice($numSides);
            $dice->roll(); // Roll the dice
            $rolledValues[] = $dice; // Store the Dice object, not just the result

            // Store the number of times each type of dice was rolled
            if (!isset($rollsByDice[$numSides])) {
                $rollsByDice[$numSides] = 1;
            } else {
                $rollsByDice[$numSides]++;
            }
        }
    } else {
        // Display an error message if the entered value exceeds the limit
        echo "<p>Max $maxDice dice allowed.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Document</title>
</head>
<body>

    
    
    <div class="form_div">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for "num_sides"><strong>Number of Sides:</strong></label>
            <br>
            <select name="num_sides">
                <option value="4">4</option>
                <option value="6" selected>6</option>
                <option value="10">10</option>
                <option value="20">20</option>
            </select>
            <br>
            <br>
            <label for="num_dice"><strong>Number of Dice:</strong></label>
            <br>
            <input class="dice_input_field" type="text" name="num_dice" id="num_dice">
            <input class="roll_button" type="submit" value="Roll Dice">
        </form>
    </div>

    <div class="rolled_values-div">
        <h2><strong>Rolled Values:</strong></h2>
        <?php
        if (count($rolledValues) > 0) {
            foreach ($rolledValues as $dice) {
                echo $dice->displayInDiv(); // Display each Dice object using displayInDiv
            }
        }
        ?>
    </div>

    <div class="roll_statistics-div">
        <h2>Roll Statistics:</h2>
        <p>Total Rolls: <?php echo $totalRolls; ?></p>
        <p>Most Often Thrown Dice: <?php echo !empty($rollsByDice) ? array_search(max($rollsByDice), $rollsByDice) : 'N/A'; ?></p>
    </div>
</body>
</html>

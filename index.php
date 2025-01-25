<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple calculator</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="decimal" name="numOne" placeholder="Input First Number...">

        <select name="operator">
            <option value="add">+</option>
            <option value="minus">-</option>
            <option value="multiply">*</option>
            <option value="divide">/</option>
        </select>
        
        <input type="decimal" name="numTwo" placeholder="Input Second Number...">
        <button type="submit" name="calculate">Calculate</button>
        <button type="submit" name="clear">Clear</button>

        <?php 
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Handle the clear button first
                if (isset($_POST["clear"])) {
                    $result = "0";
                    echo "<p>Result: $result </p>";
                } else {
                    // Allow decimal and negative numbers
                    $firstNumber = filter_input(INPUT_POST, 'numOne', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_SCIENTIFIC);
                    $secondNumber = filter_input(INPUT_POST, 'numTwo', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_SCIENTIFIC);
                    
                    $operator = htmlspecialchars($_POST["operator"]);

                    // ERROR HANDLING
                    $errors = false;
                    $result = 0;

                    if ($firstNumber === false || $secondNumber === false || empty($operator)) {
                        echo "<p>Please fill out all fields!</p>";
                        $errors = true;
                    }

                    if (!is_numeric($firstNumber) || !is_numeric($secondNumber)) {
                        echo "<p>Please fill out all fields in numeric way!</p>";
                        $errors = true;
                    }

                    if (!$errors) {
                        switch ($operator) {
                            case "add":
                                $result = $firstNumber + $secondNumber;
                                break;
                            case "minus":
                                $result = $firstNumber - $secondNumber;
                                break;
                            case "multiply":
                                $result = $firstNumber * $secondNumber;
                                break;
                            case "divide":
                                if ($secondNumber != 0) {
                                    $result = $firstNumber / $secondNumber;
                                } else {
                                    echo "<p>Cannot divide by zero!</p>";
                                    $errors = true;
                                }
                                break;
                            default:
                                echo "<p>Error!</p>";
                                $errors = true;
                        }

                        if (!$errors) {
                            echo "<p>Result: " . $result . "</p>";
                        }
                    }
                }
            }
            ?>



    </form>
</body>
</html>

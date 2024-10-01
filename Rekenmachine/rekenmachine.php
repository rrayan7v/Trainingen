<?php
session_start(); // Start a session to store values

// Function to get a number from POST data
function getNumber($inputName) {
    return isset($_POST[$inputName]) ? (float)$_POST[$inputName] : null;
}

// Function to get an operation from POST data
function getOperation() {
    return isset($_POST['operation']) ? $_POST['operation'] : null;
}

// Function to perform the calculation
function calculate($num1, $num2, $operation) {
    switch ($operation) {
        case '+':
            return $num1 + $num2;
        case '-':
            return $num1 - $num2;
        case '*':
            return $num1 * $num2;
        case '/':
            return $num2 != 0 ? $num1 / $num2 : "Error: Division by zero!";
        default:
            return "Invalid operation!";
    }
}

// Handle button actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'clear') {
        $_SESSION['num1'] = '';
        $_SESSION['num2'] = '';
        $_SESSION['operation'] = '';
    } elseif (isset($_POST['num'])) {
        if (!isset($_SESSION['num1'])) {
            $_SESSION['num1'] = $_POST['num'];
        } elseif (!isset($_SESSION['operation'])) {
            $_SESSION['num2'] = $_POST['num'];
        }
    } elseif (isset($_POST['operation'])) {
        $_SESSION['operation'] = $_POST['operation'];
    } elseif (isset($_POST['action']) && $_POST['action'] == 'calculate') {
        $num1 = isset($_SESSION['num1']) ? (float)$_SESSION['num1'] : null;
        $num2 = isset($_SESSION['num2']) ? (float)$_SESSION['num2'] : null;
        $operation = isset($_SESSION['operation']) ? $_SESSION['operation'] : null;
        if ($num1 !== null && $operation !== null && $num2 !== null) {
            $result = calculate($num1, $num2, $operation);
        } else {
            $result = "Please fill in all fields.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="calculator">
        <div class="display">
            <?php
            if (isset($result)) {
                echo "<p>$result</p>";
            } else {
                echo "<p>";
                if (isset($_SESSION['num1'])) {
                    echo htmlspecialchars($_SESSION['num1']) . ' ';
                }
                if (isset($_SESSION['operation'])) {
                    echo htmlspecialchars($_SESSION['operation']) . ' ';
                }
                if (isset($_SESSION['num2'])) {
                    echo htmlspecialchars($_SESSION['num2']);
                }
                echo "</p>";
            }
            ?>
        </div>
        <form method="post">
            <div class="buttons">
                <button type="submit" name="num" value="7">7</button>
                <button type="submit" name="num" value="8">8</button>
                <button type="submit" name="num" value="9">9</button>
                <button type="submit" name="operation" value="/">/</button>
                <button type="submit" name="num" value="4">4</button>
                <button type="submit" name="num" value="5">5</button>
                <button type="submit" name="num" value="6">6</button>
                <button type="submit" name="operation" value="*">*</button>
                <button type="submit" name="num" value="1">1</button>
                <button type="submit" name="num" value="2">2</button>
                <button type="submit" name="num" value="3">3</button>
                <button type="submit" name="operation" value="-">-</button>
                <button type="submit" name="action" value="clear" class="clear">C</button>
                <button type="submit" name="num" value="0">0</button>
                <button type="submit" name="action" value="calculate" class="equals">=</button>
                <button type="submit" name="operation" value="+">+</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
// db.php: Configureer de databaseverbinding
$dsn = 'mysql:host=localhost;dbname=hash_je_wachtwoord;charset=utf8';
$username = 'root';
$password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);

    // Creëer de users-tabel als deze niet bestaat
    $pdo->exec('CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )');
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Functies
function registerUser($email, $password, $confirmPassword, $pdo)
{
    try {
        // Controleer op lege invoer
        if (empty($email) || empty($password) || empty($confirmPassword)) {
            return 'Alle velden zijn verplicht!';
        }

        // Controleer of wachtwoorden overeenkomen
        if ($password !== $confirmPassword) {
            return 'De wachtwoorden komen niet overeen!';
        }

        // Controleer of de gebruiker al bestaat
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            return 'E-mailadres is al geregistreerd!';
        }

        // Hash het wachtwoord
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$hashedPassword) {
            return 'Fout bij het hashen van het wachtwoord!';
        }

        // Voeg de gebruiker toe
        $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
        $stmt->execute([$email, $hashedPassword]);

        return 'Registratie succesvol!';
    } catch (Exception $e) {
        return 'Fout tijdens registratie: ' . $e->getMessage();
    }
}

function loginUser($email, $password, $pdo)
{
    try {
        // Controleer op lege invoer
        if (empty($email) || empty($password)) {
            return 'Alle velden zijn verplicht!';
        }

        // Zoek de gebruiker
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            return 'Onjuist e-mailadres of wachtwoord!';
        }

        // Controleer het wachtwoord
        if (password_verify($password, $user['password'])) {
            return 'Login succesvol!';
        } else {
            return 'Onjuist e-mailadres of wachtwoord!';
        }
    } catch (Exception $e) {
        return 'Fout tijdens inloggen: ' . $e->getMessage();
    }
}

// Verwerk het formulier
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if (isset($_POST['register'])) {
        $message = registerUser($email, $password, $confirmPassword, $pdo);
    } elseif (isset($_POST['login'])) {
        $message = loginUser($email, $password, $pdo);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login en Registratie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid red;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login en Registratie</h1>
        <?php if ($message): ?>
            <div class="message">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <h2>Registreren</h2>
            <input type="text" name="email" placeholder="E-mailadres" required>
            <input type="password" name="password" placeholder="Wachtwoord" required>
            <input type="password" name="confirm_password" placeholder="Bevestig wachtwoord" required>
            <button type="submit" name="register">Registreren</button>
        </form>

        <form method="POST">
            <h2>Inloggen</h2>
            <input type="text" name="email" placeholder="E-mailadres" required>
            <input type="password" name="password" placeholder="Wachtwoord" required>
            <button type="submit" name="login">Inloggen</button>
        </form>
    </div>
</body>
</html>
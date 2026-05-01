<?php
include "../computer/db.php";

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password)
            VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql)) {
        header("Location: login.php");
    } else {
        echo "<p class='error'>Erreur: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Sign Up</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container {
    background: #111;
    padding: 30px;
    border-radius: 15px;
    width: 320px;
    box-shadow: 0 0 20px rgba(0,255,150,0.4);
    text-align: center;
}

h2 {
    color: #00ff99;
    margin-bottom: 20px;
}

input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 8px;
    outline: none;
    background: #222;
    color: white;
}

input:focus {
    border: 1px solid #00ff99;
}

button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(90deg, #00ff99, #007bff);
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    opacity: 0.8;
}

a {
    display: block;
    margin-top: 15px;
    color: #00c3ff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.error {
    color: red;
    margin-bottom: 10px;
}
</style>

</head>

<body>

<div class="container">
    <h2>Créer un compte</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="signup">Sign Up</button>
    </form>

    <a href="login.php">Déjà un compte ? Login</a>
</div>

</body>
</html>
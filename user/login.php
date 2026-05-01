<?php 
session_start(); 
include "../computer/db.php"; 

if (isset($_POST['login'])) { 
    $email = $_POST['email']; 
    $password = $_POST['password']; 

    $sql = "SELECT * FROM users WHERE email='$email'"; 
    $result = $conn->query($sql); 

    if ($result->num_rows > 0) { 
        $user = $result->fetch_assoc(); 

        if (password_verify($password, $user['password'])) { 
            $_SESSION['user'] = $user['username']; 
            header("Location: index.php"); 
        } else { 
            echo "<p class='error'>Mot de passe incorrect</p>"; 
        } 
    } else { 
        echo "<p class='error'>Utilisateur non trouvé</p>"; 
    } 
} 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Login</title>

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
    <h2>Login</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login">Login</button>
    </form>

    <a href="signup.php">Créer un compte</a>
</div>

</body>
</html>
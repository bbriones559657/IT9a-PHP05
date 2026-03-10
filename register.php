<?php
require 'db.php';
if(isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(!empty($username) && !empty($email) && !empty($password)){

        
        $check = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $check->execute([$username, $email]);

        if($check->rowCount() > 0){
            $error = "Username or Email already exists.";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword]);

            header("Location: login.php");
            exit();
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5" style="max-width:500px;">
<div class="card shadow">
<div class="card-body">

<h3 class="text-center mb-4">Create Account</h3>

<form method="POST">

<div class="mb-3">
<label class="form-label">Username</label>
<input type="text" name="username" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button class="btn btn-primary w-100">Register</button>

<p class="text-center mt-3">
Already have an account? <a href="login.php">Login</a>
</p>

</form>

</div>
</div>
</div>

</body>
</html>
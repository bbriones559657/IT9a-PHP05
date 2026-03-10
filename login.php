<?php
session_start();
require 'db.php';

if(isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])){

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Cookie example (last login)
        setcookie("last_login", date("Y-m-d H:i:s"), time()+3600*24*7);

        header("Location: index.php");
        exit();

    }else{
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5" style="max-width:500px;">
<div class="card shadow">
<div class="card-body">

<h3 class="text-center mb-4">Login</h3>

<?php if(isset($error)): ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button class="btn btn-success w-100">Login</button>

<p class="text-center mt-3">
No account? <a href="register.php">Register</a>
</p>

</form>

</div>
</div>
</div>

</body>
</html>

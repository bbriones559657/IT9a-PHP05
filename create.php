<?php
require 'db.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $status = $_POST['status'];

    if($name && $breed && $age >= 0 && $status){
        $stmt = $pdo->prepare("INSERT INTO pets (name, breed, age, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $breed, $age, $status]);
        header("Location: index.php");
    }
}

?>
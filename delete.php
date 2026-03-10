<?php
require 'db.php';
$id = $_GET['id'];
if(isset($_POST['confirm'])){
    $stmt = $pdo->prepare("DELETE FROM pets WHERE id=?");
    $stmt->execute([$id]);
    header("Location: index.php");
}
?>
<form method="post">
    <button name="confirm">Yes, Delete</button>
</form>
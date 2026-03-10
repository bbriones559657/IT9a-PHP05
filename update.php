<?php
require 'db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM pets WHERE id = ?");
$stmt->execute([$id]);
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE pets SET name=?, breed=?, age=?, status=? WHERE id=?");
    $stmt->execute([$name, $breed, $age, $status, $id]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Update Pet</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-body">

<h3 class="mb-4">Update Pet</h3>

<form method="POST">

<div class="mb-3">
<label class="form-label">Pet Name</label>
<input type="text" name="name" class="form-control" value="<?php echo $pet['name']; ?>" required>
</div>

<div class="mb-3">
<label class="form-label">Breed</label>
<input type="text" name="breed" class="form-control" value="<?php echo $pet['breed']; ?>" required>
</div>

<div class="mb-3">
<label class="form-label">Age</label>
<input type="number" name="age" class="form-control" value="<?php echo $pet['age']; ?>" min="0" required>
</div>

<div class="mb-3">
<label class="form-label">Status</label>
<select name="status" class="form-control">

<option value="available" <?php if($pet['status']=='available') echo 'selected'; ?>>Available</option>

<option value="adopted" <?php if($pet['status']=='adopted') echo 'selected'; ?>>Adopted</option>

</select>
</div>

<button type="submit" class="btn btn-primary">Update Pet</button>

<a href="index.php" class="btn btn-secondary">Cancel</a>

</form>

</div>
</div>

</div>

</body>
</html>
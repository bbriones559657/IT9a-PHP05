<?php
require 'session-check.php';
require 'db.php';

$stmt = $pdo->query("SELECT * FROM pets");
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm rounded">
            <div>
                <h5 class="mb-0">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h5>
                <p class="text-muted mb-0 small">Role: <?php echo htmlspecialchars($_SESSION['role']); ?></p>
            </div>
            <div>
                <a href="logout.php" class="btn btn-outline-danger">Logout</a>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold">Pet Adoption System</h1>
            <p class="lead text-secondary">Add pets, view available pets, and manage adoptions easily.</p>
        </div>

        <div class="card shadow-sm mb-5">
            <div class="card-body p-4">
                <h4 class="card-title mb-4">Add a Pet for Adoption</h4>
                <form action="create.php" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Pet Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Buddy" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="breed" class="form-label">Breed</label>
                            <input type="text" class="form-control" id="breed" name="breed" placeholder="e.g. Golden Retriever" required>
                        </div>
                        <div class="col-md-3">
                            <label for="age" class="form-label">Age (Years)</label>
                            <input type="number" class="form-control" id="age" name="age" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="available" selected>Available</option>
                                <option value="adopted">Adopted</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2">Add Pet</button>
                </form>
            </div>
        </div>

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Available Pets</h3>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover table-bordered bg-white shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pets)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No pets found in the database.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($pets as $pet): ?>
                            <tr>
                                <td class="fw-bold"><?php echo $pet['id']; ?></td>
                                <td><?php echo htmlspecialchars($pet['name']); ?></td>
                                <td><?php echo htmlspecialchars($pet['breed']); ?></td>
                                <td><?php echo $pet['age']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $pet['status'] == 'available' ? 'success' : 'secondary'; ?>">
                                        <?php echo ucfirst($pet['status']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="update.php?id=<?php echo $pet['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete.php?id=<?php echo $pet['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Table - Restaurant Reservation System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php require __DIR__ . '/../layouts/navbar.php'; ?>

<main class="container">

    <div class="page-heading">
        <h1>Add New Table</h1>
        <p>Enter the details of the new restaurant table.</p>
    </div>

    <div class="form-card table-form-card">

        <?php if (!empty($error)): ?>
            <div class="form-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="index.php?url=tables/store"
              method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <div class="form-group">
                <label for="table_number">Table Number</label>

                <input type="text"
                       id="table_number"
                       name="table_number"
                       placeholder="e.g. T09"
                       maxlength="10"
                       required>
            </div>

            <div class="form-group">
                <label for="capacity">Seating Capacity</label>

                <input type="number"
                       id="capacity"
                       name="capacity"
                       placeholder="Enter number of seats"
                       min="1"
                       required>
            </div>

            <div class="form-actions">
                <a href="index.php?url=tables"
                   class="cancel-button">
                    Cancel
                </a>

                <button type="submit">
                    Save Table
                </button>
            </div>

        </form>

    </div>

</main>

<script src="assets/js/app.js"></script>

</body>
</html>

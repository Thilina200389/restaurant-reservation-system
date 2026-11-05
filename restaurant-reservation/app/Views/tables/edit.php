<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Table - Restaurant Reservation System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php require __DIR__ . '/../layouts/navbar.php'; ?>

<main class="container">

    <div class="page-heading">
        <h1>Edit Restaurant Table</h1>
        <p>Update the table number or seating capacity.</p>
    </div>

    <div class="form-card table-form-card">

        <?php if (!empty($error)): ?>
            <div class="form-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="index.php?url=tables/update"
              method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <input type="hidden"
                   name="id"
                   value="<?= (int) $table['id'] ?>">

            <div class="form-group">
                <label for="table_number">Table Number</label>

                <input type="text"
                       id="table_number"
                       name="table_number"
                       value="<?= htmlspecialchars($table['table_number']) ?>"
                       maxlength="10"
                       required>
            </div>

            <div class="form-group">
                <label for="capacity">Seating Capacity</label>

                <input type="number"
                       id="capacity"
                       name="capacity"
                       value="<?= (int) $table['capacity'] ?>"
                       min="1"
                       required>
            </div>

            <div class="form-actions">
                <a href="index.php?url=tables"
                   class="cancel-button">
                    Cancel
                </a>

                <button type="submit">
                    Update Table
                </button>
            </div>

        </form>

    </div>

</main>

<script src="assets/js/app.js"></script>

</body>
</html>

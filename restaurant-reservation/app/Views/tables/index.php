<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurant Tables - Restaurant Reservation System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php require __DIR__ . '/../layouts/navbar.php'; ?>

<main class="container">

    <div class="page-top">
        <div class="page-heading">
            <h1>Restaurant Tables</h1>
            <p>Manage restaurant tables and seating capacity.</p>
        </div>

        <a href="index.php?url=tables/create"
           class="action-btn">
            + Add New Table
        </a>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Table Number</th>
                    <th>Seating Capacity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($tables as $table): ?>
                    <tr>
                        <td>
                            <strong>
                                <?= htmlspecialchars($table['table_number']) ?>
                            </strong>
                        </td>

                        <td>
                            <?= (int) $table['capacity'] ?> Seats
                        </td>

                        <td>
                            <?php if ($table['is_active']): ?>
                                <span class="status-badge status-confirmed">
                                    Active
                                </span>
                            <?php else: ?>
                                <span class="status-badge status-cancelled">
                                    Inactive
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div class="table-actions">

                                <a class="edit-link"
                                   href="index.php?url=tables/edit&id=<?= (int) $table['id'] ?>">
                                    Edit
                                </a>

                                <form action="index.php?url=tables/toggle"
                                      method="POST"
                                      class="inline-form"
                                      onsubmit="return confirm('Change this table status?');">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                                    <input type="hidden"
                                           name="id"
                                           value="<?= (int) $table['id'] ?>">

                                    <?php if ($table['is_active']): ?>
                                        <button type="submit"
                                                class="btn-danger">
                                            Deactivate
                                        </button>
                                    <?php else: ?>
                                        <button type="submit"
                                                class="btn-success">
                                            Activate
                                        </button>
                                    <?php endif; ?>

                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($tables)): ?>
                    <tr>
                        <td colspan="4" class="empty-state">
                            No restaurant tables found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</main>

<script src="assets/js/app.js"></script>

</body>
</html>
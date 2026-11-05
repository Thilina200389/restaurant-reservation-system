
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservations - Restaurant Reservation System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php require __DIR__ . '/../layouts/navbar.php'; ?>

<main class="container">

    <div class="page-top">
        <div class="page-heading">
            <h1>Restaurant Reservations</h1>
            <p>View and manage customer table bookings.</p>
        </div>

        <a href="index.php?url=reservations/create"
           class="action-btn">
            + New Reservation
        </a>
    </div>

    <!-- Search Reservations -->
    <div class="search-section">
        <form action="index.php" method="GET"
              class="search-form">

            <input type="hidden"
                   name="url"
                   value="reservations">

            <input type="text"
                   name="search"
                   placeholder="Search customer, phone or table..."
                   value="<?= htmlspecialchars($keyword ?? '') ?>">

            <button type="submit">Search</button>

            <a href="index.php?url=reservations"
               class="clear-button">
                Clear
            </a>
        </form>
    </div>

    <!-- Reservations Table -->
    <div class="table-wrapper">

        <table class="data-table reservations-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Table</th>
                    <th>Guests</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                    <th>Staff</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if (empty($reservations)): ?>
                    <tr>
                        <td colspan="9" class="empty-state">
                            No reservations found.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($reservations as $reservation): ?>
                    <tr>

                        <td>
                            <strong>
                                <?= htmlspecialchars($reservation['customer_name']) ?>
                            </strong>
                        </td>

                        <td>
                            <?= htmlspecialchars($reservation['customer_phone']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($reservation['table_number']) ?>
                        </td>

                        <td>
                            <?= (int) $reservation['guest_count'] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                date('M d, Y h:i A',
                                    strtotime($reservation['start_time']))
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                date('M d, Y h:i A',
                                    strtotime($reservation['end_time']))
                            ) ?>
                        </td>

                        <td>
                            <?php
                                $status = $reservation['status'];

                                $allowedStatuses = [
                                    'pending',
                                    'confirmed',
                                    'seated',
                                    'completed',
                                    'cancelled'
                                ];

                                $statusClass = in_array(
                                    $status,
                                    $allowedStatuses,
                                    true
                                ) ? $status : 'unknown';
                            ?>

                            <span class="status-badge status-<?= $statusClass ?>">
                                <?= htmlspecialchars(ucfirst($status)) ?>
                            </span>
                        </td>

                        <td>
                            <?= htmlspecialchars($reservation['staff_name']) ?>
                        </td>

                        <td>
                            <?php if ($reservation['status'] !== 'cancelled'): ?>

                                <div class="table-actions">

                                    <a class="edit-link"
                                       href="index.php?url=reservations/edit&id=<?= (int) $reservation['id'] ?>">
                                        Edit
                                    </a>

                                    <form
                                        action="index.php?url=reservations/cancel"
                                        method="POST"
                                        class="inline-form"
                                        onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                                        <input type="hidden"
                                               name="id"
                                               value="<?= (int) $reservation['id'] ?>">

                                        <button type="submit"
                                                class="btn-danger">
                                            Cancel
                                        </button>
                                    </form>

                                </div>

                            <?php else: ?>
                                <span class="muted-text">
                                    Cancelled
                                </span>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

    </div>

</main>

<script src="assets/js/app.js"></script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Restaurant Reservation System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require __DIR__ . '/../layouts/navbar.php'; ?>
<main class="container dashboard-page">
    <section class="welcome-card">
        <h1>Welcome back!</h1>
        <p>Manage restaurant tables and customer reservations.</p>
    </section>
    <section class="dashboard-section">
        <h2>Overview</h2>
        <div class="stats-grid">
            <div class="stat-card"><strong><?= (int) $totalTables ?></strong><span>Total Tables</span></div>
            <div class="stat-card"><strong><?= (int) $activeTables ?></strong><span>Active Tables</span></div>
            <div class="stat-card"><strong><?= (int) $todayReservations ?></strong><span>Today's Reservations</span></div>
        </div>
    </section>
    <section class="dashboard-section">
        <h2>Quick Actions</h2>
        <div class="dashboard-actions">
            <a class="dashboard-action primary-action" href="index.php?url=reservations/create">New Reservation</a>
            <a class="dashboard-action" href="index.php?url=reservations">View Reservations</a>
            <a class="dashboard-action" href="index.php?url=tables">Manage Tables</a>
        </div>
    </section>
</main>
<script src="assets/js/app.js"></script>
</body>
</html>

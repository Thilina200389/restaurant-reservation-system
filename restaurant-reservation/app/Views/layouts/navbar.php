<?php
$currentPage = $_GET['url'] ?? 'dashboard';

function navActive($page, $currentPage)
{
    if ($page === 'reservations/create') {
        return $currentPage === 'reservations/create' ? 'active' : '';
    }

    if ($page === 'reservations') {
        return $currentPage === 'reservations' ||
               strpos($currentPage, 'reservations/edit') === 0
               ? 'active' : '';
    }

    if ($page === 'tables') {
        return strpos($currentPage, 'tables') === 0
               ? 'active' : '';
    }

    return $currentPage === $page ? 'active' : '';
}
?>

<nav class="navbar modern-navbar">
    <a class="brand" href="index.php?url=dashboard">
        <span>Restaurant Reservation System</span>
    </a>

    <div class="nav-links">

        <a href="index.php?url=dashboard"
           class="nav-item <?= navActive('dashboard', $currentPage) ?>">
            Dashboard
        </a>

        <a href="index.php?url=tables"
           class="nav-item <?= navActive('tables', $currentPage) ?>">
            Tables
        </a>

        <a href="index.php?url=reservations"
           class="nav-item <?= navActive('reservations', $currentPage) ?>">
            Reservations
        </a>

        <a href="index.php?url=reservations/create"
           class="nav-item <?= navActive('reservations/create', $currentPage) ?>">
            New Booking
        </a>

        <button type="button"
                class="logout-btn"
                id="logoutTrigger">
            Logout
        </button>
    </div>
</nav>

<!-- Logout Confirmation -->
<dialog id="logoutDialog" class="logout-dialog">

    <h2>Confirm Logout</h2>

    <p>
        Are you sure you want to log out?
    </p>

    <div class="dialog-actions">

        <form method="dialog">
            <button type="submit" class="cancel-button">
                Stay Here
            </button>
        </form>

        <form action="index.php?url=logout" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <button type="submit" class="confirm-logout">
                Yes, Logout
            </button>
        </form>

    </div>
</dialog>

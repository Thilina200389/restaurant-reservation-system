<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Reservation - Restaurant Reservation System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php require __DIR__ . '/../layouts/navbar.php'; ?>

<main class="container compact-booking">

    <div class="booking-heading">
        <h1>Edit Reservation</h1>
        <p>Update customer and booking details.</p>
    </div>

    <div class="booking-card">

        <?php if (!empty($error)): ?>
            <div class="form-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="index.php?url=reservations/update"
              method="POST" class="booking-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <input type="hidden"
                   name="id"
                   value="<?= (int) $reservation['id'] ?>">

            <div class="booking-grid">

                <div class="form-group">
                    <label for="customer_name">Customer Name</label>
                    <input type="text"
                           id="customer_name"
                           name="customer_name"
                           maxlength="100"
                           value="<?= htmlspecialchars($reservation['customer_name']) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label for="customer_phone">Phone Number</label>
                    <input type="tel"
                           id="customer_phone"
                           name="customer_phone"
                           maxlength="20"
                           value="<?= htmlspecialchars($reservation['customer_phone']) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label for="table_id">Restaurant Table</label>
                    <select id="table_id" name="table_id" required>

                        <?php foreach ($tables as $table): ?>
                            <?php if ($table['is_active'] ||
                                $table['id'] == $reservation['table_id']): ?>

                                <option
                                    value="<?= (int) $table['id'] ?>"
                                    <?= $table['id'] == $reservation['table_id']
                                        ? 'selected' : '' ?>>

                                    <?= htmlspecialchars($table['table_number']) ?>
                                    - <?= (int) $table['capacity'] ?> Seats
                                </option>

                            <?php endif; ?>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="guest_count">Number of Guests</label>
                    <input type="number"
                           id="guest_count"
                           name="guest_count"
                           min="1"
                           value="<?= (int) $reservation['guest_count'] ?>"
                           required>
                </div>

                <div class="form-group booking-datetime">
                    <label for="start_date">Reservation Start</label>
                    <div class="date-time-row">
                        <input type="date" id="start_date" aria-label="Start date" required>
                        <select id="start_clock" aria-label="Start time" required></select>
                    </div>
                    <input type="hidden" id="start_time" name="start_time"
                           value="<?= htmlspecialchars(str_replace(' ', 'T', substr($reservation['start_time'], 0, 16))) ?>">
                </div>

                <div class="form-group booking-datetime">
                    <label for="end_date">Reservation End</label>
                    <div class="date-time-row">
                        <input type="date" id="end_date" aria-label="End date" required>
                        <select id="end_clock" aria-label="End time" required></select>
                    </div>
                    <input type="hidden" id="end_time" name="end_time"
                           value="<?= htmlspecialchars(str_replace(' ', 'T', substr($reservation['end_time'], 0, 16))) ?>">
                </div>
            </div>

            <div class="form-group booking-notes">
                <label for="notes">Notes (Optional)</label>
                <textarea id="notes"
                          name="notes"
                          placeholder="Additional booking information"><?= htmlspecialchars($reservation['notes'] ?? '') ?></textarea>
            </div>

            <div class="booking-footer"><div class="booking-buttons">
                <a href="index.php?url=reservations"
                   class="cancel-button">
                    Back
                </a>

                <button type="submit">
                    Update Reservation
                </button>
            </div></div>

        </form>

    </div>

</main>

<script src="assets/js/app.js"></script>
<script src="assets/js/booking-time.js"></script>

</body>
</html>

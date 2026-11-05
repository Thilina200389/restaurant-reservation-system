<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Reservation - Restaurant Reservation System</title>
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

<?php require __DIR__ . '/../layouts/navbar.php'; ?>

<main class="container compact-booking">

    <div class="booking-heading">
        <div>
            <h1>New Reservation</h1>
            <p>Enter customer details and select a table.</p>
        </div>
        <a href="index.php?url=reservations"
           class="booking-back">All Reservations</a>
    </div>

    <div class="booking-card">

        <?php if (!empty($error)): ?>
            <div class="form-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="index.php?url=reservations/store"
              method="POST" class="booking-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <div class="booking-grid">

                <div class="form-group">
                    <label for="customer_name">Customer Name</label>
                    <input id="customer_name"
                           type="text"
                           name="customer_name" value="<?= htmlspecialchars($old['customer_name'] ?? '') ?>"
                           placeholder="Customer full name"
                           maxlength="100"
                           required>
                </div>

                <div class="form-group">
                    <label for="customer_phone">Phone Number</label>
                    <input id="customer_phone"
                           type="tel"
                           name="customer_phone" value="<?= htmlspecialchars($old['customer_phone'] ?? '') ?>"
                           placeholder="0771234567"
                           maxlength="20"
                           required>
                </div>

                <div class="form-group">
                    <label for="table_id">Restaurant Table</label>
                    <div class="select-wrapper">
                        <select id="table_id" name="table_id" required>
                            <option value="">Choose a table</option>
                            <?php foreach ($tables as $table): ?>
                                <?php if ($table['is_active']): ?>
                                    <option value="<?= (int) $table['id'] ?>" <?= (int) ($old['table_id'] ?? 0) === (int) $table['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($table['table_number']) ?>
                                        — <?= (int) $table['capacity'] ?> seats
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="guest_count">Number of Guests</label>
                    <input id="guest_count"
                           type="number"
                           name="guest_count" value="<?= (int) ($old['guest_count'] ?? 0) ?: '' ?>"
                           min="1"
                           placeholder="How many guests?"
                           required>
                </div>

                <div class="form-group booking-datetime">
                    <label for="start_date">Reservation Start</label>
                    <div class="date-time-row">
                        <input type="date" id="start_date" aria-label="Start date" required>
                        <select id="start_clock" aria-label="Start time" required>
                            <option value="">Select time</option>
                        </select>
                    </div>
                    <input type="hidden" id="start_time" name="start_time" value="<?= htmlspecialchars(str_replace(' ', 'T', $old['start_time'] ?? '')) ?>">
                </div>

                <div class="form-group booking-datetime">
                    <label for="end_date">Reservation End</label>
                    <div class="date-time-row">
                        <input type="date" id="end_date" aria-label="End date" required>
                        <select id="end_clock" aria-label="End time" required>
                            <option value="">Select time</option>
                        </select>
                    </div>
                    <input type="hidden" id="end_time" name="end_time" value="<?= htmlspecialchars(str_replace(' ', 'T', $old['end_time'] ?? '')) ?>">
                </div>

                <div class="form-group booking-notes">
                    <label for="notes">Additional Notes <span>(Optional)</span></label>
                    <textarea id="notes"
                              name="notes"
                              rows="2"
                              placeholder="Special requests or booking details"><?= htmlspecialchars($old['notes'] ?? '') ?></textarea>
                </div>

            </div>

            <div class="booking-footer">
                <span class="booking-hint">
                    Please check table availability before saving.
                </span>

                <div class="booking-buttons">
                    <a href="index.php?url=reservations"
                       class="cancel-button">Cancel</a>
                    <button type="submit">Save Reservation</button>
                </div>
            </div>

        </form>
    </div>

</main>
<script src="assets/js/app.js"></script>
<script src="assets/js/booking-time.js"></script>
</body>
</html>

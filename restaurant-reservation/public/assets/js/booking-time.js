document.addEventListener("DOMContentLoaded", function () {
    const startDate = document.getElementById("start_date");
    const endDate = document.getElementById("end_date");
    const startClock = document.getElementById("start_clock");
    const endClock = document.getElementById("end_clock");
    const startValue = document.getElementById("start_time");
    const endValue = document.getElementById("end_time");
    if (!startDate || !endDate || !startClock || !endClock ||
        !startValue || !endValue) return;

    function pad(n) { return String(n).padStart(2, "0"); }
    function dateString(d) {
        return d.getFullYear() + "-" + pad(d.getMonth() + 1) + "-" + pad(d.getDate());
    }
    function clockString(d) { return pad(d.getHours()) + ":" + pad(d.getMinutes()); }
    function readableTime(h, m) {
        const hour = h % 12 || 12;
        return hour + ":" + pad(m) + (h < 12 ? " AM" : " PM");
    }

    // Generate time options every 15 minutes
    function fillTimes(select) {
        select.innerHTML = '<option value="">Select time</option>';
        for (let h = 0; h < 24; h++) {
            for (let m = 0; m < 60; m += 15) {
                const option = document.createElement("option");
                option.value = pad(h) + ":" + pad(m);
                option.textContent = readableTime(h, m);
                select.appendChild(option);
            }
        }
    }
    fillTimes(startClock);
    fillTimes(endClock);

    function chooseTime(select, time) {
        if (!time) return;
        if (![...select.options].some(o => o.value === time)) {
            const option = document.createElement("option");
            option.value = time;
            const parts = time.split(":").map(Number);
            option.textContent = readableTime(parts[0], parts[1]);
            select.add(option);
        }
        select.value = time;
    }

    // Load saved date and time when editing
    function restore(input, date, clock) {
        const value = input.value.replace(" ", "T");
        if (value.length >= 16) {
            date.value = value.slice(0, 10);
            chooseTime(clock, value.slice(11, 16));
        }
    }
    restore(startValue, startDate, startClock);
    restore(endValue, endDate, endClock);

    // Prevent selecting past dates for new reservations
    if (!startValue.value) {
        startDate.min = dateString(new Date());
        endDate.min = startDate.min;
    }

    function sync(date, clock, hidden) {
        hidden.value = date.value && clock.value
            ? date.value + "T" + clock.value : "";
    }

    // Set default end time
    function updateEndDefault() {
        sync(startDate, startClock, startValue);
        if (!startValue.value) return;
        endDate.min = startDate.value;
        const start = new Date(startValue.value);
        if (Number.isNaN(start.getTime())) return;
        const end = new Date(start.getTime() + 90 * 60000);
        if (!endValue.value || endValue.value <= startValue.value) {
            endDate.value = dateString(end);
            chooseTime(endClock, clockString(end));
            sync(endDate, endClock, endValue);
        }
    }
    startDate.addEventListener("change", updateEndDefault);
    startClock.addEventListener("change", updateEndDefault);
    endDate.addEventListener("change", function () { sync(endDate, endClock, endValue); });
    endClock.addEventListener("change", function () { sync(endDate, endClock, endValue); });

    // Validate times before submitting
    const form = startValue.closest("form");
    if (form) form.addEventListener("submit", function (event) {
        sync(startDate, startClock, startValue);
        sync(endDate, endClock, endValue);
        if (!startValue.value || !endValue.value || endValue.value <= startValue.value) {
            event.preventDefault();
            alert("Please select a valid start and end time. End must be after start.");
        }
    });
});

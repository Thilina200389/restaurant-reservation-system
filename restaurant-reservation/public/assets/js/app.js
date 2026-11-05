
document.addEventListener("DOMContentLoaded", function () {

    // Logout confirmation dialog
    const logoutButton = document.getElementById("logoutTrigger");
    const logoutDialog = document.getElementById("logoutDialog");

    if (logoutButton && logoutDialog) {
        logoutButton.addEventListener("click", function () {
            logoutDialog.showModal();
        });
    }

    // Smooth transitions between internal pages
    document.querySelectorAll('a[href]').forEach(function (link) {

        link.addEventListener("click", function (event) {

            if (event.defaultPrevented ||
                event.button !== 0 ||
                event.ctrlKey ||
                event.metaKey ||
                event.shiftKey ||
                event.altKey ||
                link.hasAttribute("download") ||
                link.target === "_blank") {
                return;
            }

            const destination = new URL(link.href, window.location.href);

            if (destination.origin !== window.location.origin ||
                destination.pathname !== window.location.pathname ||
                destination.href === window.location.href) {
                return;
            }

            if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
                return;
            }

            event.preventDefault();

            document.body.classList.add("page-leaving");

            setTimeout(function () {
                window.location.href = destination.href;
            }, 120);
        });
    });

});


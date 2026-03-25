document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("forgotForm");
    const emailInput = document.getElementById("email");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const email = emailInput.value.trim();

        if (!email) {
            alert("Please enter your registered email.");
            return;
        }

        // Frontend demo success message
        alert(
            "If this email is registered, a password reset link has been sent."
        );

        // Reset form
        form.reset();

        /*
        =========================
        BACKEND INTEGRATION POINT
        =========================
        Send email to backend API:
        fetch('/api/forgot-password', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ email })
        })
        */
    });

});
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("forgotForm");
    const emailInput = document.getElementById("email");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const email = emailInput.value.trim();

        if (!email) {
            alert("Please enter your registered email.");
            return;
        }

        // Frontend demo success message
        alert(
            "If this email is registered, a password reset link has been sent."
        );

        // Reset form
        form.reset();

        /*
        =========================
        BACKEND INTEGRATION POINT
        =========================
        Send email to backend API:
        fetch('/api/forgot-password', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ email })
        })
        */
    });

});

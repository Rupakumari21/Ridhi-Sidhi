document.addEventListener("DOMContentLoaded", function () {

    /* =========================
       GET ROLE FROM URL
    ========================= */
    const params = new URLSearchParams(window.location.search);
    const roleFromUrl = params.get("role");

    /* =========================
       ELEMENT REFERENCES
    ========================= */
    const title = document.getElementById("signupTitle");
    const subtitle = document.getElementById("signupSubtitle");
    const roleInput = document.getElementById("signupRole");
    const roleButtons = document.querySelectorAll(".role-btn");

    /* =========================
       SET ROLE FUNCTION
    ========================= */
    function setRole(role) {

        if (role === "admin") {
            title.textContent = "Signup as Admin";
            subtitle.textContent = "Administrator registration only";
            roleInput.value = "admin";
        } else {
            title.textContent = "Signup as User";
            subtitle.textContent = "Client account registration";
            roleInput.value = "client";
        }

        // Toggle active button
        roleButtons.forEach(button => {
            button.classList.toggle(
                "active",
                button.dataset.role === role
            );
        });
    }

    /* =========================
       INITIAL ROLE SET
    ========================= */
    if (roleFromUrl === "admin" || roleFromUrl === "client") {
        setRole(roleFromUrl);
    } else {
        // Default role
        setRole("client");
    }

    /* =========================
       MANUAL ROLE SWITCH
    ========================= */
    roleButtons.forEach(button => {
        button.addEventListener("click", function () {
            const selectedRole = this.dataset.role;
            setRole(selectedRole);
        });
    });

});

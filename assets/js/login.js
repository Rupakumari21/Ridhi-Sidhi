document.addEventListener("DOMContentLoaded", function () {

    /* =========================
       GET ROLE FROM URL
    ========================= */
    const params = new URLSearchParams(window.location.search);
    const roleFromUrl = params.get("role");

    /* =========================
       ELEMENT REFERENCES
    ========================= */
    const title = document.getElementById("loginTitle");
    const subtitle = document.getElementById("loginSubtitle");
    const roleInput = document.getElementById("loginRole");
    const roleButtons = document.querySelectorAll(".role-btn");

    /* =========================
       SET ROLE FUNCTION
    ========================= */
    function setRole(role) {

        if (role === "admin") {
            title.textContent = "Login as Admin";
            subtitle.textContent = "Administrator access only";
            roleInput.value = "admin";
        } else {
            title.textContent = "Login as User";
            subtitle.textContent = "Client account login";
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

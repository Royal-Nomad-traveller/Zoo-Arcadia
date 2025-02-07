document.addEventListener("DOMContentLoaded", () => {
    const loginForm     = document.getElementById("loginForm");
    const errorMessage  = document.getElementById("errorMessage");

    // Liste des utilisateurs du zoo 
    const users     = [
        { email: "admin@arcadia.com", password: "admin123", role: "administrateur"},
        { email: "employee@arcadia.com", password: "employee123", role: "employé"},
        { email: "veterinaire@arcadia.com", password: "veter123", role: "administrateur"}
    ];

    // Formulaire du formulaire de connexion 
    loginForm.addEventListener("submit", (event) => {
        event.preventDefault();

        const email     = document.getElementById("email").value;
        const password  = document.getElementById("password").value;

        const user      = users.find(user => user.email === email && user.password === password);

        if (user) {
            alert(`Bienvenue ${user.role} !`)
            const bootstrapModal        = bootstrap.Modal.getInstance(document.getElementById("loginModal"));
            bootstrapModal.hide();
        } else {
            errorMessage.textContent    = "Identifiants incorrect ou accès refusé."
        }
    });
});
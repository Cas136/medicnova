// Splash + redirecciones de botones
window.addEventListener("load", () => {
    const splash = document.getElementById("splash");
    const login = document.getElementById("login");

    // Mostrar splash 2.5 segundos
    setTimeout(() => {
        splash.style.opacity = 0;
        setTimeout(() => {
            splash.style.display = "none";
            login.classList.remove("d-none");
        }, 500);
    }, 2500);

    // Botón Paciente
    document.getElementById("btn-paciente").addEventListener("click", () => {
        window.location.href = "PhP/login.php?role=paciente";
    });

    // Botón Doctor
    document.getElementById("btn-doctor").addEventListener("click", () => {
        window.location.href = "PhP/login.php?role=doctor";
    });
});

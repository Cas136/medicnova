<?php
session_start();
include("config.php");

$role = isset($_GET['role']) ? $_GET['role'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND role='$role' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['fname']   = $user['fname'];
        $_SESSION['role']    = $user['role'];

        // Redirigir según rol
        if ($user['role'] === 'paciente') {
            header("Location: dashboardpa.php");
        } elseif ($user['role'] === 'doctor') {
            header("Location: dashboardoc.php");
        } else {
            header("Location: dashboard.php"); // fallback por si existe otro rol
        }
        exit();
    } else {
        $error = "Credenciales incorrectas o rol inválido.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Medic Nova</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Styles/styleUser.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="max-width: 400px; width:100%;">
        <h3 class="mb-3 text-center">Iniciar Sesión como <span class="text-primary"><?php echo ucfirst($role); ?></span></h3>

        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" action="">
            <input type="hidden" name="role" value="<?php echo $role; ?>">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required/>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-2">Ingresar</button>
        </form>

        <a href="../index.html" class="btn btn-outline-secondary w-100">Regresar al inicio</a>

        <p class="mt-3 text-center">¿No tienes cuenta? 
            <a href="register.php?role=<?php echo $role; ?>">Regístrate aquí</a>
        </p>
    </div>
</body>
</html>

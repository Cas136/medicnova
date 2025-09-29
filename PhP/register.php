<?php
include("config.php");

$role = isset($_GET['role']) ? $_GET['role'] : 'paciente';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']);

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $error = "Este correo ya está registrado.";
    } else {
        $unique_id = rand(time(), 10000000);
        $sql = "INSERT INTO users (unique_id, fname, lname, email, password, img, status, role) 
                VALUES ('$unique_id', '$fname', '$lname', '$email', '$password', 'default.png', 'Activo', '$role')";
        if ($conn->query($sql) === TRUE) {
            header("Location: login.php?role=$role");
            exit();
        } else {
            $error = "Error al registrar: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Medic Nova</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Styles/styleUser.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="max-width: 450px; width:100%;">
        <h3 class="mb-3 text-center">Registro de <span class="text-primary"><?php echo ucfirst($role); ?></span></h3>

        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" action="">
            <input type="hidden" name="role" value="<?php echo $role; ?>">
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="fname" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label>Apellido</label>
                <input type="text" name="lname" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required/>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required/>
            </div>
            <button type="submit" class="btn btn-success w-100 mb-2">Registrarse</button>
        </form>

        <a href="../index.html" class="btn btn-outline-secondary w-100">Regresar al inicio</a>

        <p class="mt-3 text-center">¿Ya tienes cuenta? 
            <a href="login.php?role=<?php echo $role; ?>">Inicia sesión</a>
        </p>
    </div>
</body>
</html>

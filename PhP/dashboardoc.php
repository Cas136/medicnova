<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "config.php"; // asegúrate que aquí conectas a tu BD (mysqli $conn)

// Procesar envío de factura
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_factura'])) {
    $paciente_id = intval($_POST['paciente_id']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $monto = floatval($_POST['monto']);

    if ($paciente_id > 0 && !empty($descripcion) && $monto > 0) {
        $sql = "INSERT INTO factura (paciente_id, descripcion, monto) 
                VALUES ($paciente_id, '$descripcion', $monto)";
        if (mysqli_query($conn, $sql)) {
            $mensaje = '<div class="alert alert-success">Factura creada correctamente.</div>';
        } else {
            $mensaje = '<div class="alert alert-danger">Error al crear la factura: ' . mysqli_error($conn) . '</div>';
        }
    } else {
        $mensaje = '<div class="alert alert-warning">Por favor completa todos los campos.</div>';
    }
}

// Obtener lista de pacientes
$pacientes = [];
$result = mysqli_query($conn, "SELECT user_id, fname, lname FROM users WHERE role = 'paciente'");
while ($row = mysqli_fetch_assoc($result)) {
    $pacientes[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Doctor - Medic Nova</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f7fa; }
        .card { border-radius: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .chat-box { height: 250px; overflow-y: auto; background: #fff; border-radius: 0.5rem; padding: 1rem; }
        .notification { position: relative; }
        .notification .badge { position: absolute; top: -5px; right: -5px; font-size: 0.8rem; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark px-4">
        <a class="navbar-brand fw-bold" href="#">Medic Nova - Doctor</a>
        <div class="ms-auto d-flex align-items-center">
            <div class="notification me-3">
                <i class="fa-solid fa-bell fa-lg text-white"></i>
                <span class="badge bg-danger rounded-pill">3</span>
            </div>
            <span class="text-white me-3">Dr. <?php echo $_SESSION['fname']; ?></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row g-4">
            <!-- Lista de Citas (estático) -->
            <div class="col-md-6">
                <div class="card p-4">
                    <h5 class="mb-3">Citas Programadas</h5>
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Paciente</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Motivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Juan Pérez</td>
                                <td>15/09/2025</td>
                                <td>10:00 AM</td>
                                <td>Chequeo general</td>
                            </tr>
                            <tr>
                                <td>María López</td>
                                <td>16/09/2025</td>
                                <td>3:00 PM</td>
                                <td>Dolor de cabeza</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Crear Factura (dinámico con BD) -->
            <div class="col-md-6">
                <div class="card p-4">
                    <h5 class="mb-3">Crear Factura</h5>
                    <?php echo $mensaje; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Paciente</label>
                            <select name="paciente_id" class="form-select" required>
                                <option value="">Selecciona un paciente</option>
                                <?php foreach ($pacientes as $p): ?>
                                    <option value="<?php echo $p['user_id']; ?>">
                                        <?php echo $p['fname'] . " " . $p['lname']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <input type="text" name="descripcion" class="form-control" placeholder="Consulta General, Medicamentos, etc." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Monto ($)</label>
                            <input type="number" step="0.01" name="monto" class="form-control" required>
                        </div>
                        <button type="submit" name="crear_factura" class="btn btn-success w-100">Generar y Enviar Factura</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Chat con Paciente (estático) -->
            <div class="col-md-12">
                <div class="card p-4">
                    <h5 class="mb-3">Chat con Paciente</h5>
                    <div class="chat-box mb-3">
                        <p><strong>Juan Pérez:</strong> Doctor, ¿debo seguir con el medicamento?</p>
                        <p><strong>Dr. <?php echo $_SESSION['fname']; ?>:</strong> Sí, continúe 5 días más.</p>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Escribe tu mensaje...">
                        <button class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

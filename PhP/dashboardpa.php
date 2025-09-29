<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Paciente - Medic Nova</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .chat-box {
            height: 250px;
            overflow-y: auto;
            background: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
        }
        .notification {
            position: relative;
        }
        .notification .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark px-4">
        <a class="navbar-brand fw-bold" href="#">Medic Nova</a>
        <div class="ms-auto d-flex align-items-center">
            <div class="notification me-3">
                <i class="fa-solid fa-bell fa-lg text-white"></i>
                <span class="badge bg-danger rounded-pill">2</span>
            </div>
            <span class="text-white me-3">Hola, <?php echo $_SESSION['fname']; ?></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row g-4">
            <!-- Programar Cita -->
            <div class="col-md-6">
                <div class="card p-4">
                    <h5 class="mb-3">Agendar Cita</h5>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hora</label>
                            <input type="time" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Motivo de la consulta</label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary w-100">Agendar</button>
                    </form>
                </div>
            </div>

            <!-- Facturación -->
            <div class="col-md-6">
                <div class="card p-4">
                    <h5 class="mb-3">Factura</h5>
                    <p><strong>Consulta General:</strong> $25.00</p>
                    <p><strong>Medicamentos:</strong> $10.00</p>
                    <hr>
                    <p><strong>Total:</strong> $35.00</p>
                    <button class="btn btn-success w-100">Descargar Factura</button>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Chat -->
            <div class="col-md-12">
                <div class="card p-4">
                    <h5 class="mb-3">Chat con el Doctor</h5>
                    <div class="chat-box mb-3">
                        <p><strong>Dr. Pérez:</strong> Buen día, ¿cómo se siente?</p>
                        <p><strong><?php echo $_SESSION['fname']; ?>:</strong> Hola doctor, me siento mejor.</p>
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

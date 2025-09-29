<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "config.php";

$paciente_id = $_SESSION['user_id'];

// Facturas nuevas (no leídas)
$facturas_nuevas = [];
$sql_nuevas = "SELECT factura_id, descripcion, monto, fecha_creacion FROM factura WHERE paciente_id = $paciente_id AND leida = 0 ORDER BY factura_id DESC";
$result_nuevas = mysqli_query($conn, $sql_nuevas);
while ($row = mysqli_fetch_assoc($result_nuevas)) {
    $facturas_nuevas[] = $row;
}

// Historial de facturas (leídas)
$facturas_historial = [];
$sql_hist = "SELECT factura_id, descripcion, monto, fecha_creacion FROM factura WHERE paciente_id = $paciente_id AND leida = 1 ORDER BY factura_id DESC";
$result_hist = mysqli_query($conn, $sql_hist);
while ($row = mysqli_fetch_assoc($result_hist)) {
    $facturas_historial[] = $row;
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
body { background-color: #f5f7fa; }
.card { border-radius: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.chat-box { height: 250px; overflow-y: auto; background: #fff; border-radius: 0.5rem; padding: 1rem; }
.factura-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
.factura-table th, .factura-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
.factura-table th { background-color: #f2f2f2; }
.factura-total { text-align: right; font-weight: bold; font-size: 1.2rem; margin-top: 10px; }
.dropdown-menu { min-width: 200px; }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-primary navbar-dark px-4">
<a class="navbar-brand fw-bold" href="#" onclick="location.reload(); return false;">Medic Nova</a>
<div class="ms-auto d-flex align-items-center">
<div class="dropdown me-3">
<div class="notification" id="notiDropdown" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fa-solid fa-bell fa-lg text-white"></i>
<span class="badge bg-danger rounded-pill" id="badge-notificacion">0</span>
</div>
<ul class="dropdown-menu dropdown-menu-end p-2" id="dropdownNoti">
<li id="notiContent"><small>No hay notificaciones</small></li>
<li><hr class="dropdown-divider"></li>
<li><button class="dropdown-item btn btn-sm btn-primary w-100" id="marcarLeidasBtn">Marcar todas como leídas</button></li>
</ul>
</div>
<span class="text-white me-3">Hola, <?php echo $_SESSION['fname']; ?></span>
<a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
</div>
</nav>

<div class="container mt-4">
<div class="card p-4">
<!-- Pestañas principales -->
<ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
<li class="nav-item" role="presentation">
<button class="nav-link active" id="citas-tab" data-bs-toggle="tab" data-bs-target="#citas" type="button" role="tab">Citas</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="factura-tab" data-bs-toggle="tab" data-bs-target="#factura" type="button" role="tab">Factura</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="chat-tab" data-bs-toggle="tab" data-bs-target="#chat" type="button" role="tab">Chat</button>
</li>
</ul>

<div class="tab-content mt-3">
<!-- Citas -->
<div class="tab-pane fade show active" id="citas" role="tabpanel">
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

<!-- Factura con pestañas internas -->
<div class="tab-pane fade" id="factura" role="tabpanel">
<ul class="nav nav-pills mb-3" id="facturaTabs" role="tablist">
<li class="nav-item" role="presentation">
<button class="nav-link active" id="nuevas-tab" data-bs-toggle="pill" data-bs-target="#nuevas" type="button" role="tab">Nuevas</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link" id="historial-tab" data-bs-toggle="pill" data-bs-target="#historial" type="button" role="tab">Historial</button>
</li>
</ul>
<div class="tab-content">
<!-- Nuevas facturas -->
<div class="tab-pane fade show active" id="nuevas" role="tabpanel">
<?php if(!empty($facturas_nuevas)):
$total_nuevas = 0; ?>
<table class="factura-table">
<thead>
<tr>
<th>ID</th>
<th>Descripción</th>
<th>Monto ($)</th>
<th>Fecha/Hora</th>
</tr>
</thead>
<tbody>
<?php foreach($facturas_nuevas as $f): ?>
<tr>
<td><?php echo $f['factura_id']; ?></td>
<td><?php echo htmlspecialchars($f['descripcion']); ?></td>
<td><?php echo number_format($f['monto'],2); ?></td>
<td><?php echo $f['fecha_creacion']; ?></td>
</tr>
<?php $total_nuevas += $f['monto']; endforeach; ?>
</tbody>
</table>
<div class="factura-total">Total: $<?php echo number_format($total_nuevas,2); ?></div>
<?php else: ?>
<p>No tienes facturas nuevas.</p>
<?php endif; ?>
</div>

<!-- Historial -->
<div class="tab-pane fade" id="historial" role="tabpanel">
<?php if(!empty($facturas_historial)):
$total_hist = 0; ?>
<table class="factura-table">
<thead>
<tr>
<th>ID</th>
<th>Descripción</th>
<th>Monto ($)</th>
<th>Fecha/Hora</th>
</tr>
</thead>
<tbody>
<?php foreach($facturas_historial as $f): ?>
<tr>
<td><?php echo $f['factura_id']; ?></td>
<td><?php echo htmlspecialchars($f['descripcion']); ?></td>
<td><?php echo number_format($f['monto'],2); ?></td>
<td><?php echo $f['fecha_creacion']; ?></td>
</tr>
<?php $total_hist += $f['monto']; endforeach; ?>
</tbody>
</table>
<div class="factura-total">Total Gastado: $<?php echo number_format($total_hist,2); ?></div>
<?php else: ?>
<p>No hay historial de facturas.</p>
<?php endif; ?>
</div>
</div>
</div>

<!-- Chat -->
<div class="tab-pane fade" id="chat" role="tabpanel">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Notificaciones simplificadas
function actualizarNotificaciones() {
    fetch('notificaciones.php')
    .then(res => res.json())
    .then(data => {
        const badge = document.getElementById('badge-notificacion');
        const notiContent = document.getElementById('notiContent');

        if(data.length > 0){
            badge.textContent = data.length;
            notiContent.innerHTML = '<small>Tienes una factura nueva</small>';
        } else {
            badge.textContent = 0;
            notiContent.innerHTML = '<small>No hay notificaciones</small>';
        }
    });
}

// Marcar como leídas
document.getElementById('marcarLeidasBtn').addEventListener('click', () => {
    fetch('marcar_leidas.php')
    .then(() => actualizarNotificaciones());
});

// Actualizar cada 5 segundos
actualizarNotificaciones();
setInterval(actualizarNotificaciones, 5000);
</script>
</body>
</html>

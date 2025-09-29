<?php
session_start();
if(!isset($_SESSION['user_id'])) exit;

include "config.php";
$paciente_id = $_SESSION['user_id'];

$sql = "SELECT factura_id FROM factura WHERE paciente_id=$paciente_id AND leida=0";
$result = mysqli_query($conn,$sql);
$notis = [];
while($row = mysqli_fetch_assoc($result)){
    $notis[] = $row;
}
echo json_encode($notis);

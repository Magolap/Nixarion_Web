<?php
include_once '../../includes/config.php';


$query = "SELECT COUNT(*) as new_orders FROM pedidos WHERE estado = 'nuevo'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);


echo json_encode(['newOrders' => $row['new_orders']]);
?>

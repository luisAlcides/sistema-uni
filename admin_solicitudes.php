<?php
include 'header.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $solicitud_id = $_POST['solicitud_id'];
    $accion = $_POST['accion'];

    if ($accion == 'aprobar') {
        $estado = 'aprobado';
    } elseif ($accion == 'rechazar') {
        $estado = 'rechazado';
    }

    $stmt = $conn->prepare('UPDATE solicitudes SET estado = ? WHERE id = ?');
    $stmt->execute([$estado, $solicitud_id]);

    $mensaje = 'Solicitud ' . $estado . ' exitosamente.';
}

$stmt = $conn->prepare('
    SELECT s.id, u.nombre AS profesor_nombre, m.nombre AS medio_nombre, s.fecha_uso, s.hora_inicio, s.hora_fin, s.estado
    FROM solicitudes s
    JOIN usuarios u ON s.usuario_id = u.id
    JOIN medios m ON s.medio_id = m.id
    ORDER BY s.fecha_solicitud DESC
');
$stmt->execute();
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content mt-5">
    <h2>Gestión de Solicitudes</h2>
    <?php if (isset($mensaje)): ?>
        <div class="alert alert-success"><?= $mensaje ?></div>
    <?php endif; ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Profesor</th>
                <th>Medio</th>
                <th>Fecha de Uso</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($solicitudes as $solicitud): ?>
                <tr>
                    <td><?= htmlspecialchars($solicitud['profesor_nombre']) ?></td>
                    <td><?= htmlspecialchars($solicitud['medio_nombre']) ?></td>
                    <td><?= $solicitud['fecha_uso'] ?></td>
                    <td><?= $solicitud['hora_inicio'] ?></td>
                    <td><?= $solicitud['hora_fin'] ?></td>
                    <td><?= ucfirst($solicitud['estado']) ?></td>
                    <td>
                        <?php if ($solicitud['estado'] == 'pendiente'): ?>
                            <form method="POST" action="" style="display:inline-block;">
                                <input type="hidden" name="solicitud_id" value="<?= $solicitud['id'] ?>">
                                <input type="hidden" name="accion" value="aprobar">
                                <button type="submit" class="btn btn-success btn-sm">Aprobar</button>
                            </form>
                            <form method="POST" action="" style="display:inline-block;">
                                <input type="hidden" name="solicitud_id" value="<?= $solicitud['id'] ?>">
                                <input type="hidden" name="accion" value="rechazar">
                                <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                            </form>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="admin_medios.php" class="btn btn-secondary mt-3">Gestionar Medios</a>
    <a href="admin_profesores.php" class="btn btn-secondary mt-3">Gestionar Profesores</a>
    <a href="logout.php" class="btn btn-danger mt-3">Cerrar Sesión</a>
</div>

<?php
include 'footer.php';
?>

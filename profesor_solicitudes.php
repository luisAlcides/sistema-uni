<?php
include 'header.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'profesor') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['solicitar_medio'])) {
    $medio_id = $_POST['medio_id'];
    $usuario_id = $_SESSION['usuario_id'];
    $fecha_uso = $_POST['fecha_uso'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    $stmt = $conn->prepare('
        SELECT COUNT(*) FROM solicitudes
        WHERE medio_id = ? AND fecha_uso = ? AND (
            (hora_inicio <= ? AND hora_fin > ?) OR
            (hora_inicio < ? AND hora_fin >= ?) OR
            (hora_inicio >= ? AND hora_fin <= ?)
        ) AND estado != "rechazado"
    ');
    $stmt->execute([
        $medio_id,
        $fecha_uso,
        $hora_inicio, $hora_inicio,
        $hora_fin, $hora_fin,
        $hora_inicio, $hora_fin
    ]);
    $conflicto = $stmt->fetchColumn();

    if ($conflicto > 0) {
        $error = 'El medio ya está reservado en esa fecha y hora.';
    } else {
        $stmt = $conn->prepare('
            INSERT INTO solicitudes (usuario_id, medio_id, fecha_uso, hora_inicio, hora_fin)
            VALUES (?, ?, ?, ?, ?)
        ');
        $stmt->execute([$usuario_id, $medio_id, $fecha_uso, $hora_inicio, $hora_fin]);

        $mensaje = 'Solicitud enviada exitosamente';
    }
}

$stmt = $conn->prepare('SELECT * FROM medios');
$stmt->execute();
$medios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare('
    SELECT s.id, m.nombre AS medio_nombre, s.fecha_solicitud, s.fecha_uso, s.hora_inicio, s.hora_fin, s.estado
    FROM solicitudes s
    JOIN medios m ON s.medio_id = m.id
    WHERE s.usuario_id = ?
    ORDER BY s.fecha_solicitud DESC
');
$stmt->execute([$_SESSION['usuario_id']]);
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content mt-5">
    <h2>Solicitar Medio</h2>
    <?php if (isset($mensaje)): ?>
        <div class="alert alert-success"><?= $mensaje ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="" class="mb-4">
        <div class="mb-3">
            <label for="medio_id" class="form-label">Seleccionar Medio</label>
            <select name="medio_id" class="form-control" required>
                <option value="">-- Seleccionar --</option>
                <?php foreach ($medios as $medio): ?>
                    <option value="<?= $medio['id'] ?>"><?= htmlspecialchars($medio['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="fecha_uso" class="form-label">Fecha de Uso</label>
            <input type="date" name="fecha_uso" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="hora_inicio" class="form-label">Hora de Inicio</label>
            <input type="time" name="hora_inicio" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="hora_fin" class="form-label">Hora de Fin</label>
            <input type="time" name="hora_fin" class="form-control" required>
        </div>
        <button type="submit" name="solicitar_medio" class="btn btn-primary">Solicitar</button>
    </form>

    <h4>Mis Solicitudes</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Medio</th>
                <th>Fecha de Uso</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($solicitudes as $solicitud): ?>
                <tr>
                    <td><?= htmlspecialchars($solicitud['medio_nombre']) ?></td>
                    <td><?= $solicitud['fecha_uso'] ?></td>
                    <td><?= $solicitud['hora_inicio'] ?></td>
                    <td><?= $solicitud['hora_fin'] ?></td>
                    <td><?= ucfirst($solicitud['estado']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="logout.php" class="btn btn-danger mt-3">Cerrar Sesión</a>
</div>

<?php
include 'footer.php';
?>

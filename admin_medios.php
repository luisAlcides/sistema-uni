<?php
include 'header.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_medio'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $stmt = $conn->prepare('INSERT INTO medios (nombre, descripcion) VALUES (?, ?)');
    $stmt->execute([$nombre, $descripcion]);

    $mensaje = 'Medio agregado exitosamente';
}

$stmt = $conn->prepare('SELECT * FROM medios');
$stmt->execute();
$medios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content mt-5">
    <h2>Gestión de Medios</h2>
    <?php if (isset($mensaje)): ?>
        <div class="alert alert-success"><?= $mensaje ?></div>
    <?php endif; ?>
    <form method="POST" action="" class="mb-4">
        <h4>Agregar Nuevo Medio</h4>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Medio</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>
        <button type="submit" name="agregar_medio" class="btn btn-primary">Agregar Medio</button>
    </form>

    <h4>Lista de Medios</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medios as $medio): ?>
                <tr>
                    <td><?= htmlspecialchars($medio['nombre']) ?></td>
                    <td><?= htmlspecialchars($medio['descripcion']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="admin_profesores.php" class="btn btn-secondary mt-3">Gestionar Profesores</a>
    <a href="admin_solicitudes.php" class="btn btn-secondary mt-3">Gestionar Solicitudes</a>

    <a href="logout.php" class="btn btn-danger mt-3">Cerrar Sesión</a>
</div>

<?php
include 'footer.php';
?>

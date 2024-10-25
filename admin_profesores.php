<?php
include 'header.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_profesor'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = 'profesor';

    $stmt = $conn->prepare('INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)');
    try {
        $stmt->execute([$nombre, $email, $password, $rol]);
        $mensaje = 'Profesor agregado exitosamente';
    } catch (PDOException $e) {
        $error = 'Error al agregar profesor: ' . $e->getMessage();
    }
}

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE rol = 'profesor'");
$stmt->execute();
$profesores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content mt-5">
    <h2>Gestión de Profesores</h2>
    <?php if (isset($mensaje)): ?>
        <div class="alert alert-success"><?= $mensaje ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="" class="mb-4">
        <h4>Agregar Nuevo Profesor</h4>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="agregar_profesor" class="btn btn-primary">Agregar Profesor</button>
    </form>

    <h4>Lista de Profesores</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($profesores as $profesor): ?>
                <tr>
                    <td><?= htmlspecialchars($profesor['nombre']) ?></td>
                    <td><?= htmlspecialchars($profesor['email']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="admin_medios.php" class="btn btn-secondary mt-3">Gestionar Medios</a>
    <a href="admin_solicitudes.php" class="btn btn-secondary mt-3">Gestionar Solicitudes</a>
    <a href="logout.php" class="btn btn-danger mt-3">Cerrar Sesión</a>
</div>

<?php
include 'footer.php';
?>

<?php
include 'header.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SESSION['rol'] == 'admin') {
    header('Location: admin_medios.php');
    exit();
} elseif ($_SESSION['rol'] == 'profesor') {
    header('Location: profesor_solicitudes.php');
    exit();
}

?>

<div class="content">
    <div id="home-banner" class="mb-4">
        <h1>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']); ?></h1>
        <p>Selecciona una opción del menú para empezar.</p>
    </div>
</div>
<?php
include 'footer.php';
?>
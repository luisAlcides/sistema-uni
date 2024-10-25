<?php
include 'config.php';

$logged_in = isset($_SESSION['usuario_id']);
$rol = $logged_in ? $_SESSION['rol'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Solicitud de Medios - UNI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php if ($logged_in): ?>
        <aside id="sidebar" class="d-flex flex-column">
        <div class="text-center py-3">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAR0AAACxCAMAAADOHZloAAAAaVBMVEUANIX///8AEnoAL4P5+/0AMoQAH33X3uu9yNw8V5f3+PsAG3zV2+gyVpg7Wpl6jrgAKYEAJX8oTJKaqcgAAG8ACHgAD3sAF38qUJUIOIdXc6kQRJDe4uyEl71vhbLk6PCNn8LCzd+drMqr0SJ2AAACeUlEQVR4nO3d3VKCUBRAYRTIskw0MY3s7/0fMrsSmnHNbCGwYX33zKE1e59xvLBkovOSyWYasN0+nJ6dP28jzw5jc3t64Wxdhh491pkmEemsVifJQ88O4qZe5zGNPDq1DmhZJ7dOk7NDrEPcLOLsEGeHODvEOsTNIs4OsQ6xDrEOsQ6xDrEO8fMOcXaIdYh1iHWItzJxdoh1iJtFnB1iHeJmEWeHWIdYh1iHeCsTZ4dYh7hZxNkh1iHWIW3q5GknYoc26iyKyEFln7dyvlt0Yh86tVHnJfQKVZ+zc/M66URsPep1wvqsMzv/GgHZ3T+pE9ussdVxdqxjnTOsQ7yVibNDrEPcLOLsEOsQN4sMNDvZYRnx9t5NnY/YqUPVmVerIqCs/b5EizrZInRqr7/00KizDv2J9x3VueJvTsdW5/JbeQx1nJ1frEPcLOLsEOsQ6xDrEG9l4uwQ6xA3izg7xDrEOsQ6xFuZODvEOsTNIs4OsQ5xs4izQ6xDrEOsQ7yVibNDrEOsQ6xDrEOsQ6xD/LxDnB1iHeJmEWeHODvE2SHWIW4WcXaIdYibRZwdYh3iZhFnh1iHWIc07500DxhbnX3o0dW46rRgHetYp8E6xDrEOsQ6xDrEOsQ6xDrEOsQ6JO3mh/2zXW91PmvH/nGdPD98PXWhCn1x1qJOsay98Dp0anx28mLVidg/FGlRJykuPjVeZxht6lzOOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOuSnzmZ6/Tb1OlXZ16nHOjrvG4Wfgvp5Y8NwAAAAAElFTkSuQmCC" alt="Logo UNI" class="img-fluid" style="max-width: 80%; height: auto;">
            </div>
            <ul class="nav nav-pills flex-column mb-auto">
                <?php if ($rol == 'admin'): ?>
                    <li class="nav-item">
                        <a href="admin_medios.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'admin_medios.php' ? 'active' : '' ?>">
                            <i class="fas fa-folder"></i> Gestión de Medios
                        </a>
                    </li>
                    <li>
                        <a href="admin_profesores.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'admin_profesores.php' ? 'active' : '' ?>">
                            <i class="fas fa-users"></i> Gestión de Profesores
                        </a>
                    </li>
                    <li>
                        <a href="admin_solicitudes.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'admin_solicitudes.php' ? 'active' : '' ?>">
                            <i class="fas fa-chart-line"></i> Gestión de Solicitudes
                        </a>
                    </li>
                <?php elseif ($rol == 'profesor'): ?>
                    <li class="nav-item">
                        <a href="profesor_solicitudes.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'profesor_solicitudes.php' ? 'active' : '' ?>">
                            <i class="fas fa-folder"></i> Mis Solicitudes
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="logout.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
            <footer id="sidebar-footer">
                <p>&copy; <?= date('Y'); ?> Universidad Nacional de Ingeniería. Todos los derechos reservados.</p>
            </footer>
        </aside>
    <?php endif; ?>
    <main id="content-area">
        <?php if ($logged_in): ?>
        <?php endif; ?>

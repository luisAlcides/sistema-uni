<?php //echo password_hash("admin123", PASSWORD_DEFAULT); ?>

<?php
include 'header.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Credenciales incorrectas';
    }
}
?>
<div class="login-container">
    <div class="login-form">
        <div class="text-center mb-4">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAR0AAACxCAMAAADOHZloAAAAaVBMVEUANIX///8AEnoAL4P5+/0AMoQAH33X3uu9yNw8V5f3+PsAG3zV2+gyVpg7Wpl6jrgAKYEAJX8oTJKaqcgAAG8ACHgAD3sAF38qUJUIOIdXc6kQRJDe4uyEl71vhbLk6PCNn8LCzd+drMqr0SJ2AAACeUlEQVR4nO3d3VKCUBRAYRTIskw0MY3s7/0fMrsSmnHNbCGwYX33zKE1e59xvLBkovOSyWYasN0+nJ6dP28jzw5jc3t64Wxdhh491pkmEemsVifJQ88O4qZe5zGNPDq1DmhZJ7dOk7NDrEPcLOLsEGeHODvEOsTNIs4OsQ6xDrEOsQ6xDrEO8fMOcXaIdYh1iHWItzJxdoh1iJtFnB1iHeJmEWeHWIdYh1iHeCsTZ4dYh7hZxNkh1iHWIW3q5GknYoc26iyKyEFln7dyvlt0Yh86tVHnJfQKVZ+zc/M66URsPep1wvqsMzv/GgHZ3T+pE9ussdVxdqxjnTOsQ7yVibNDrEPcLOLsEOsQN4sMNDvZYRnx9t5NnY/YqUPVmVerIqCs/b5EizrZInRqr7/00KizDv2J9x3VueJvTsdW5/JbeQx1nJ1frEPcLOLsEOsQ6xDrEG9l4uwQ6xA3izg7xDrEOsQ6xFuZODvEOsTNIs4OsQ5xs4izQ6xDrEOsQ7yVibNDrEOsQ6xDrEOsQ6xD/LxDnB1iHeJmEWeHODvE2SHWIW4WcXaIdYibRZwdYh3iZhFnh1iHWIc07500DxhbnX3o0dW46rRgHetYp8E6xDrEOsQ6xDrEOsQ6xDrEOsQ6JO3mh/2zXW91PmvH/nGdPD98PXWhCn1x1qJOsay98Dp0anx28mLVidg/FGlRJykuPjVeZxht6lzOOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOsQ6xDrEOuSnzmZ6/Tb1OlXZ16nHOjrvG4Wfgvp5Y8NwAAAAAElFTkSuQmCC" alt="Logo UNI" class="img-fluid" style="max-width: 150px;">
        </div>
        <h2 class="text-center mb-4">Bienvenido al Sistema de Solicitud de Medios de la UNI</h2>
        <p class="text-center mb-4">Gestiona medios, usuarios y reportes de forma eficiente y sencilla.</p>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>
    </div>
</div>
<?php
include 'footer.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="build/js/app.js"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <title>DemoApp</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: 250px;
            background: #2c3e50;
            padding: 20px 0;
            overflow-y: auto;
        }

        .sidebar-header {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #34495e;
        }

        .sidebar-header img {
            width: 40px;
            margin-bottom: 10px;
        }

        .sidebar-header h5 {
            color: white;
            margin: 0;
        }

        .nav-link {
            display: block;
            color: #bdc3c7;
            padding: 15px 20px;
            text-decoration: none;
            cursor: pointer;
        }

        .nav-link:hover {
            background: #34495e;
            color: #3498db;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        .dropdown-menu {
            background: #34495e;
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: block;
            color: #95a5a6;
            padding: 10px 40px;
            text-decoration: none;
        }

        .dropdown-item:hover {
            background: #3498db;
            color: white;
        }

        .main-content {
            margin-right: 250px;
            padding: 40px;
            min-height: 100vh;
        }

        .progress {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 250px;
            height: 4px;
            background: #ecf0f1;
        }

        .progress-bar {
            height: 100%;
            background: #e74c3c;
            width: 0%;
        }

        .footer {
            background: #ecf0f1;
            padding: 20px;
            text-align: center;
            margin-right: 250px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="<?= asset('./images/cit.png') ?>" alt="cit">
            <h5>Aplicaciones</h5>
        </div>

        <a href="/sic_final_capacitaciones_ingSoft1/login" class="nav-link">
            <i class="bi bi-house-fill"></i> Login
        </a>

        <a href="#" class="nav-link" onclick="toggleDropdown('registro')">
            <i class="bi bi-card-checklist"></i> Registro
        </a>
        <div class="dropdown-menu" id="registro">
            <a href="/sic_final_capacitaciones_ingSoft1/instructor" class="dropdown-item">
                <i class="bi bi-person-walking"></i> Instructores
            </a>
            <a href="/sic_final_capacitaciones_ingSoft1/registro" class="dropdown-item">
                <i class="bi bi-person-fill-gear"></i> Usuarios
            </a>
            <a href="/sic_final_capacitaciones_ingSoft1/compania" class="dropdown-item">
                <i class="bi bi-envelope"></i> Compañía
            </a>
        </div>

        <a href="#" class="nav-link" onclick="toggleDropdown('gestion')">
            <i class="bi bi-gear"></i> Gestión
        </a>
        <div class="dropdown-menu" id="gestion">
            <a href="/sic_final_capacitaciones_ingSoft1/aplicacion" class="dropdown-item">
                <i class="bi bi-grid-fill"></i> Aplicaciones
            </a>
            <a href="/sic_final_capacitaciones_ingSoft1/permisos" class="dropdown-item">
                <i class="bi bi-shield-lock-fill"></i> Permisos
            </a>
            <a href="/sic_final_capacitaciones_ingSoft1/asignacion" class="dropdown-item">
                <i class="bi bi-shield-lock-fill"></i> Asignación de Permisos
            </a>
        </div>

        <a href="/sic_final_capacitaciones_ingSoft1/capacitacion" class="nav-link">
            <i class="bi bi-pencil-square"></i> Capacitación
        </a>

        <a href="/sic_final_capacitaciones_ingSoft1/horario" class="nav-link">
            <i class="bi bi-alarm"></i> Horario de entrenamiento
        </a>

        <a href="/sic_final_capacitaciones_ingSoft1/estadistica" class="nav-link">
            <i class="bi bi-bar-chart"></i> Estadísticas
        </a>

        <a href="/sic_final_capacitaciones_ingSoft1/mapas" class="nav-link">
            <i class="bi bi-send-check-fill"></i> Ubicaciones
        </a>
    </div>

    <div class="main-content">
        <?php echo $contenido; ?>
    </div>

    <div class="progress">
        <div class="progress-bar" id="bar"></div>
    </div>

    <div class="footer">
        <p style="font-size: small; font-weight: bold; margin: 0;">
            Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
        </p>
    </div>

    <script>
        function toggleDropdown(id) {
            var dropdown = document.getElementById(id);
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
            }
        }
    </script>
</body>

</html>
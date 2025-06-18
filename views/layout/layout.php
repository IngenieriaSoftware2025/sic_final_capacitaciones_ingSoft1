<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="build/js/app.js"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>DemoApp</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark  bg-dark">

        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/ejemplo/">
                <img src="<?= asset('./images/cit.png') ?>" width="35px'" alt="cit">
                Aplicaciones
            </a>
            <div class="collapse navbar-collapse" id="navbarToggler">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/sic_final_capacitaciones_ingSoft1/login"><i class="bi bi-house-fill me-2"></i>Login</a>
                    </li>



                    <div class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-card-checklist"></i> Registro
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark " id="dropwdownRevision" style="margin: 0;">
                            <li class="nav-item">
                                <a class="nav-link px-3" style="background: none; border: none;" href="/sic_final_capacitaciones_ingSoft1/instructor">
                                    <i class="bi bi-person-walking"></i> Instructores
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/sic_final_capacitaciones_ingSoft1/registro">
                                    <i class="bi bi-person-fill-gear"></i> Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3" style="background: none; border: none;" href="/sic_final_capacitaciones_ingSoft1/compania">
                                    <i class="bi bi-envelope"></i> Compañia
                                </a>
                            </li>
                        </ul>
                    </div>



                    <div class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>Gestion
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark " id="dropwdownRevision" style="margin: 0;">
                            <li class="nav-item">
                                <a class="nav-link px-3" style="background: none;" href="/sic_final_capacitaciones_ingSoft1/aplicacion">
                                    <i class="bi bi-grid-fill me-2"></i>Aplicaciones
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3" style="background: none; border: none;" href="/sic_final_capacitaciones_ingSoft1/permisos">
                                    <i class="bi bi-shield-lock-fill me-2"></i>Permisos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3" style="background: none; border: none;" href="/sic_final_capacitaciones_ingSoft1/asignacion">
                                    <i class="bi bi-shield-lock-fill me-2"></i>Asignacion de Permisos
                                </a>
                            </li>
                        </ul>
                    </div>


                   <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/sic_final_capacitaciones_ingSoft1/capacitacion">
                            <i class="bi bi-pencil-square"></i> Capacitacion</a>
                    </li>

                     <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/sic_final_capacitaciones_ingSoft1/horario">
                           <i class="bi bi-alarm"></i> Horario de entrenamiento</a>
                    </li>



                </ul>
            </div>
        </div>

    </nav>
    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-danger" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh">

        <?php echo $contenido; ?>
    </div>
    <div class="container-fluid ">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                    Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>
</body>

</html>
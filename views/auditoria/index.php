<div class="row justify-content-center p-3">
    <div class="col-lg-12">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">

                <div class="row mb-3">
                    <h5 class="text-center mb-2">Sistema de Auditorías</h5>
                    <h4 class="text-center mb-2 text-primary">Historial de Actividades</h4>
                    <h3 class="text-center mb-2 text-success">Subtte TT.MM. Kimberly Victoria Sic Contreras</h3>
                </div>

                <!-- Botón simple para mostrar actividades -->
                <div class="row mb-4">
                    <div class="col-lg-12 text-center">
                        <button type="button" class="btn btn-primary btn-lg" id="btnMostrarActividades">
                            Ver Actividades del Sistema
                        </button>
                    </div>
                </div>

                <!-- Gráfica simple de usuarios activos -->
                <div class="row p-3 justify-content-center" id="seccionGrafica" style="display: none;">
                    <div class="col-lg-6 rounded border-rounded shadow">
                        <h6 class="text-center mt-2 text-info">Usuarios Más Activos</h6>
                        <canvas id="grafico1" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Tabla simple -->
                <div class="row mt-4" id="seccionTabla" style="display: none;">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-center text-primary">Últimas Actividades</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tablaActividades" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Usuario</th>
                                                <th>Acción</th>
                                                <th>Descripción</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              
            </div>
        </div>
    </div>
</div>
<script src="<?= asset('build/js/auditoria/index.js') ?>"></script>
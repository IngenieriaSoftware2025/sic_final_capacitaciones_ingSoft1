<div class="row justify-content-center p-3">
    <div class="col-lg-12">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la Aplicación para programar horarios de entrenamiento!</h5>
                    <h4 class="text-center mb-2 text-primary">GESTIÓN DE HORARIOS DE ENTRENAMIENTO</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormHorarios">
                        <input type="hidden" id="horario_id" name="horario_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-4">
                                <label for="horario_capacitacion_id" class="form-label">CAPACITACIÓN</label>
                                <select class="form-control" id="horario_capacitacion_id" name="horario_capacitacion_id" required>
                                    <option value="">Seleccione una capacitación</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="horario_instructor_id" class="form-label">INSTRUCTOR</label>
                                <select class="form-control" id="horario_instructor_id" name="horario_instructor_id" required>
                                    <option value="">Seleccione un instructor</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="horario_compania_id" class="form-label">COMPAÑÍA</label>
                                <select class="form-control" id="horario_compania_id" name="horario_compania_id" required>
                                    <option value="">Seleccione una compañía</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-3">
                                <label for="horario_fecha_inicio" class="form-label">FECHA DE INICIO</label>
                                <input type="date" class="form-control" id="horario_fecha_inicio" name="horario_fecha_inicio" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="horario_fecha_fin" class="form-label">FECHA DE FIN</label>
                                <input type="date" class="form-control" id="horario_fecha_fin" name="horario_fecha_fin" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="horario_hora_inicio" class="form-label">HORA DE INICIO</label>
                                <input type="time" class="form-control" id="horario_hora_inicio" name="horario_hora_inicio" required>
                            </div>
                            <div class="col-lg-3">
                                <label for="horario_hora_fin" class="form-label">HORA DE FIN</label>
                                <input type="time" class="form-control" id="horario_hora_fin" name="horario_hora_fin" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="horario_ubicacion" class="form-label">UBICACIÓN</label>
                                <input type="text" class="form-control" id="horario_ubicacion" name="horario_ubicacion" placeholder="Ingrese la ubicación del entrenamiento" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="horario_estado" class="form-label">ESTADO</label>
                                <select class="form-control" id="horario_estado" name="horario_estado" required>
                                    <option value="PROGRAMADO">PROGRAMADO</option>
                                    <option value="EN_CURSO">EN CURSO</option>
                                    <option value="FINALIZADO">FINALIZADO</option>
                                    <option value="CANCELADO">CANCELADO</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-12">
                                <label for="horario_observaciones" class="form-label">OBSERVACIONES</label>
                                <textarea class="form-control" id="horario_observaciones" name="horario_observaciones" rows="3" placeholder="Ingrese observaciones adicionales (opcional)"></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar">
                                    <i class="bi bi-save me-1"></i>Guardar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                                    <i class="bi bi-pencil-square me-1"></i>Modificar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                    <i class="bi bi-eraser me-1"></i>Limpiar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-info" type="button" id="BtnBuscar">
                                    <i class="bi bi-search me-1"></i>Buscar Horarios
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center p-3" id="seccionTabla" style="display: none;">
    <div class="col-lg-12">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <h3 class="text-center">HORARIOS DE ENTRENAMIENTO REGISTRADOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableHorarios">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/horario/index.js') ?>"></script>
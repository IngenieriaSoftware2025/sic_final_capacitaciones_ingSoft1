<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la Aplicación para el registro, modificación y eliminación de capacitaciones!</h5>
                    <h4 class="text-center mb-2 text-primary">GESTIÓN DE CAPACITACIONES</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormCapacitaciones">
                        <input type="hidden" id="capacitacion_id" name="capacitacion_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="capacitacion_nombre" class="form-label">NOMBRE DE LA CAPACITACIÓN</label>
                                <input type="text" class="form-control" id="capacitacion_nombre" name="capacitacion_nombre" placeholder="Ingrese el nombre de la capacitación" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="capacitacion_tipo" class="form-label">TIPO DE CAPACITACIÓN</label>
                                <input type="text" class="form-control" id="capacitacion_tipo" name="capacitacion_tipo" placeholder="Ej: Técnica, Táctica, Física" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-12">
                                <label for="capacitacion_descripcion" class="form-label">DESCRIPCIÓN</label>
                                <textarea class="form-control" id="capacitacion_descripcion" name="capacitacion_descripcion" rows="4" placeholder="Ingrese una descripción detallada (mínimo 10 caracteres)" required></textarea>
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
                                    <i class="bi bi-search me-1"></i>Buscar Capacitaciones
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
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <h3 class="text-center">CAPACITACIONES REGISTRADAS EN LA BASE DE DATOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableCapacitaciones">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/capacitacion/index.js') ?>"></script>
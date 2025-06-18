<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">BRIGADA DE COMUNICACIONES DEL EJERCITO</h5>
                    <h4 class="text-center mb-2 text-primary">GESTIÓN DE INSTRUCTORES MILITARES</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormInstructores">
                        <input type="hidden" id="instructor_id" name="instructor_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="instructor_nombres" class="form-label">NOMBRES COMPLETOS</label>
                                <input type="text" class="form-control" id="instructor_nombres" name="instructor_nombres" placeholder="Ingrese los nombres completos" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="instructor_apellidos" class="form-label">APELLIDOS COMPLETOS</label>
                                <input type="text" class="form-control" id="instructor_apellidos" name="instructor_apellidos" placeholder="Ingrese los apellidos completos" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="instructor_grado" class="form-label">GRADO MILITAR</label>
                                <input type="text" class="form-control" id="instructor_grado" name="instructor_grado" placeholder="Ej: Coronel, Mayor, Capitán" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="instructor_arma" class="form-label">ARMA</label>
                                <input type="text" class="form-control" id="instructor_arma" name="instructor_arma" placeholder="Ej: Infantería, Artillería, Caballería" required>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="instructor_telefono" class="form-label">TELÉFONO</label>
                                <input type="text" class="form-control" id="instructor_telefono" name="instructor_telefono" placeholder="Ingrese el teléfono (8 dígitos)" maxlength="8" required>
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
                                    <i class="bi bi-search me-1"></i>Buscar Instructores
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
                <h3 class="text-center">INSTRUCTORES REGISTRADOS EN LA BASE DE DATOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableInstructores">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/instructor/index.js') ?>"></script>
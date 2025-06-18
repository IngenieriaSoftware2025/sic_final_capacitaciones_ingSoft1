<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">BRIGADA DE COMUNICACIONES DEL EJERCITO</h5>
                    <h4 class="text-center mb-2 text-primary">GESTION DE COMPAÑIAS</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">

                    <form id="FormCompanias">
                        <input type="hidden" id="compania_id" name="compania_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="compania_nombre" class="form-label">NOMBRE DE LA COMPAÑÍA</label>
                                <input type="text" class="form-control" id="compania_nombre" name="compania_nombre" placeholder="Ingrese el nombre de la compañía" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="compania_integrantes" class="form-label">NÚMERO DE INTEGRANTES</label>
                                <input type="number" class="form-control" id="compania_integrantes" name="compania_integrantes" placeholder="Ingrese el número de integrantes" min="1" required>
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
                                    <i class="bi bi-search me-1"></i>Buscar Compañías
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
                <h3 class="text-center">COMPAÑÍAS REGISTRADAS EN LA BASE DE DATOS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableCompanias">
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/compania/index.js') ?>"></script>
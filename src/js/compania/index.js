import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormCompanias = document.getElementById('FormCompanias');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const InputCompaniaIntegrantes = document.getElementById('compania_integrantes');
const BtnBuscar = document.getElementById('BtnBuscar');

const ValidarIntegrantes = () => {
    const cantidad = InputCompaniaIntegrantes.value;

    if (cantidad.length < 1) {
        InputCompaniaIntegrantes.classList.remove('is-valid', 'is-invalid');
    } else {
        if (cantidad < 1) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Número de integrantes inválido",
                text: "El número de integrantes debe ser mayor a 0",
                showConfirmButton: true,
            });
            InputCompaniaIntegrantes.classList.remove('is-valid');
            InputCompaniaIntegrantes.classList.add('is-invalid');
        } else {
            InputCompaniaIntegrantes.classList.remove('is-invalid');
            InputCompaniaIntegrantes.classList.add('is-valid');
        }
    }
}

const GuardarCompania = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormCompanias, ['compania_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe de validar todos los campos",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormCompanias);
    const url = '/sic_final_capacitaciones_ingSoft1/compania/guardarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Registro Exitoso!",
                text: mensaje,
                showConfirmButton: true,
            });
            limpiarTodo();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error en el Registro",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de Conexión",
            text: "No se pudo conectar con el servidor. Por favor, intenta de nuevo.",
            showConfirmButton: true,
        });
    }
    BtnGuardar.disabled = false;
}

const BuscarCompanias = async () => {
    const url = '/sic_final_capacitaciones_ingSoft1/compania/buscarAPI';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;

        if (codigo == 1) {
            document.getElementById('seccionTabla').style.display = 'block';
            
            datatable.clear().draw();
            datatable.rows.add(data).draw();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const datatable = new DataTable('#TableCompanias', {
    dom: `
        <"row mt-3 justify-content-between" 
            <"col" l> 
            <"col" B> 
            <"col-3" f>
        >
        t
        <"row mt-3 justify-content-between" 
            <"col-md-3 d-flex align-items-center" i> 
            <"col-md-8 d-flex justify-content-end" p>
        >
    `,
    language: lenguaje,
    data: [],
    columns: [
        {
            title: 'No.',
            data: 'compania_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Nombre de la Compañía', data: 'compania_nombre' },
        { title: 'Número de Integrantes', data: 'compania_integrantes' },
        {
            title: 'Estado',
            data: 'compania_situacion',
            render: (data, type, row) => {
                return data == 1 ? '<span class="badge bg-success">ACTIVO</span>' : '<span class="badge bg-danger">INACTIVO</span>';
            }
        },
        {
            title: 'Acciones',
            data: 'compania_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-nombre="${row.compania_nombre}"  
                         data-integrantes="${row.compania_integrantes}">
                        <i class='bi bi-pencil-square me-1'></i> Modificar 
                     </button>
                     <button class='btn btn-danger eliminar mx-1' 
                         data-id="${data}">
                        <i class="bi bi-trash3 me-1"></i>Eliminar
                     </button>
                 </div>`;
            }
        }
    ]
});

const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset;

    document.getElementById('compania_id').value = datos.id;
    document.getElementById('compania_nombre').value = datos.nombre;
    document.getElementById('compania_integrantes').value = datos.integrantes;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

const limpiarTodo = () => {
    FormCompanias.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    InputCompaniaIntegrantes.classList.remove('is-valid', 'is-invalid');
    
    const campos = ['compania_nombre', 'compania_integrantes'];
    campos.forEach(campoId => {
        const campo = document.getElementById(campoId);
        if (campo) {
            campo.classList.remove('is-invalid', 'is-valid');
        }
    });
}

const ModificarCompania = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormCompanias, ['compania_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe de validar todos los campos",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormCompanias);
    const url = '/sic_final_capacitaciones_ingSoft1/compania/modificarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Modificación Exitosa!",
                text: mensaje,
                showConfirmButton: true,
            });
            limpiarTodo();
            BuscarCompanias();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error en la Modificación",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de Conexión",
            text: "No se pudo conectar con el servidor. Por favor, intenta de nuevo.",
            showConfirmButton: true,
        });
    }
    BtnModificar.disabled = false;
}

const EliminarCompanias = async (e) => {
    const idCompania = e.currentTarget.dataset.id;

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Desea ejecutar esta acción?",
        text: 'Esta completamente seguro que desea eliminar esta compañía',
        showConfirmButton: true,
        confirmButtonText: 'Si, Eliminar',
        confirmButtonColor: 'red',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/sic_final_capacitaciones_ingSoft1/compania/eliminarAPI?id=${idCompania}`;
        const config = {
            method: 'GET'
        }

        try {
            const consulta = await fetch(url, config);
            const respuesta = await consulta.json();
            const { codigo, mensaje } = respuesta;

            if (codigo == 1) {
                await Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "¡Eliminación Exitosa!",
                    text: mensaje,
                    showConfirmButton: true,
                });
                BuscarCompanias();
            } else {
                await Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error al Eliminar",
                    text: mensaje,
                    showConfirmButton: true,
                });
            }
        } catch (error) {
            console.log(error);
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error de Conexión",
                text: "No se pudo conectar con el servidor para eliminar la compañía.",
                showConfirmButton: true,
            });
        }
    }
}

datatable.on('click', '.eliminar', EliminarCompanias);
datatable.on('click', '.modificar', llenarFormulario);
FormCompanias.addEventListener('submit', GuardarCompania);
InputCompaniaIntegrantes.addEventListener('change', ValidarIntegrantes);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarCompania);
BtnBuscar.addEventListener('click', BuscarCompanias);
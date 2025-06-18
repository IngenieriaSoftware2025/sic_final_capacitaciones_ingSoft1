import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormCapacitaciones = document.getElementById('FormCapacitaciones');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');

const GuardarCapacitacion = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormCapacitaciones, ['capacitacion_id'])) {
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

    const body = new FormData(FormCapacitaciones);
    const url = '/sic_final_capacitaciones_ingSoft1/capacitacion/guardarAPI';
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
            text: "No se pudo conectar con el servidor.",
            showConfirmButton: true,
        });
    }
    BtnGuardar.disabled = false;
}

const BuscarCapacitaciones = async () => {
    const url = '/sic_final_capacitaciones_ingSoft1/capacitacion/buscarAPI';
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

const datatable = new DataTable('#TableCapacitaciones', {
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
            data: 'capacitacion_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Nombre', data: 'capacitacion_nombre' },
        { 
            title: 'Descripción', 
            data: 'capacitacion_descripcion',
            render: (data, type, row) => {
                return data.length > 50 ? data.substring(0, 50) + '...' : data;
            }
        },
        { title: 'Tipo', data: 'capacitacion_tipo' },
        {
            title: 'Estado',
            data: 'capacitacion_situacion',
            render: (data, type, row) => {
                return data == 1 ? '<span class="badge bg-success">ACTIVO</span>' : '<span class="badge bg-danger">INACTIVO</span>';
            }
        },
        {
            title: 'Acciones',
            data: 'capacitacion_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-nombre="${row.capacitacion_nombre}"  
                         data-descripcion="${row.capacitacion_descripcion}"  
                         data-tipo="${row.capacitacion_tipo}">
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

    document.getElementById('capacitacion_id').value = datos.id;
    document.getElementById('capacitacion_nombre').value = datos.nombre;
    document.getElementById('capacitacion_descripcion').value = datos.descripcion;
    document.getElementById('capacitacion_tipo').value = datos.tipo;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({ top: 0 });
}

const limpiarTodo = () => {
    FormCapacitaciones.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarCapacitacion = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormCapacitaciones, ['capacitacion_id'])) {
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

    const body = new FormData(FormCapacitaciones);
    const url = '/sic_final_capacitaciones_ingSoft1/capacitacion/modificarAPI';
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
            BuscarCapacitaciones();
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
            text: "No se pudo conectar con el servidor.",
            showConfirmButton: true,
        });
    }
    BtnModificar.disabled = false;
}

const EliminarCapacitaciones = async (e) => {
    const idCapacitacion = e.currentTarget.dataset.id;

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Desea ejecutar esta acción?",
        text: 'Esta completamente seguro que desea eliminar esta capacitación',
        showConfirmButton: true,
        confirmButtonText: 'Si, Eliminar',
        confirmButtonColor: 'red',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/sic_final_capacitaciones_ingSoft1/capacitacion/eliminarAPI?id=${idCapacitacion}`;
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
                BuscarCapacitaciones();
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
                text: "No se pudo conectar con el servidor.",
                showConfirmButton: true,
            });
        }
    }
}

// Event Listeners
datatable.on('click', '.eliminar', EliminarCapacitaciones);
datatable.on('click', '.modificar', llenarFormulario);
FormCapacitaciones.addEventListener('submit', GuardarCapacitacion);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarCapacitacion);
BtnBuscar.addEventListener('click', BuscarCapacitaciones);
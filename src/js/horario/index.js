import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormHorarios = document.getElementById('FormHorarios');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnBuscar = document.getElementById('BtnBuscar');
const SelectCapacitacion = document.getElementById('horario_capacitacion_id');
const SelectInstructor = document.getElementById('horario_instructor_id');
const SelectCompania = document.getElementById('horario_compania_id');

let capacitacionesData = [];

const CargarCapacitaciones = async () => {
    const url = '/sic_final_capacitaciones_ingSoft1/horario/obtenerCapacitacionesAPI';
    const config = { method: 'GET' }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, data } = datos;

        if (codigo == 1) {
            capacitacionesData = data;
            SelectCapacitacion.innerHTML = '<option value="">Seleccione una capacitación</option>';
            data.forEach(capacitacion => {
                SelectCapacitacion.innerHTML += `<option value="${capacitacion.capacitacion_id}">${capacitacion.capacitacion_nombre}</option>`;
            });
        }
    } catch (error) {
        console.log(error);
    }
}


const CargarCompanias = async () => {
    const url = '/sic_final_capacitaciones_ingSoft1/horario/obtenerCompaniasAPI';
    const config = { method: 'GET' }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, data } = datos;

        if (codigo == 1) {
            SelectCompania.innerHTML = '<option value="">Seleccione una compañía</option>';
            data.forEach(compania => {
                SelectCompania.innerHTML += `<option value="${compania.compania_id}">${compania.compania_nombre}</option>`;
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const ValidarFechas = () => {
    const fechaInicio = document.getElementById('horario_fecha_inicio').value;
    const fechaFin = document.getElementById('horario_fecha_fin').value;

    if (fechaInicio && fechaFin) {
        if (fechaInicio > fechaFin) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Fechas inválidas",
                text: "La fecha de inicio no puede ser mayor a la fecha de fin",
                showConfirmButton: true,
            });
            document.getElementById('horario_fecha_fin').value = '';
        }
    }
}

const GuardarHorario = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormHorarios, ['horario_id'])) {
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

    const body = new FormData(FormHorarios);
    const url = '/sic_final_capacitaciones_ingSoft1/horario/guardarAPI';
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

const BuscarHorarios = async () => {
    const url = '/sic_final_capacitaciones_ingSoft1/horario/buscarAPI';
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

const datatable = new DataTable('#TableHorarios', {
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
            data: 'horario_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Capacitación', data: 'capacitacion_nombre' },
        { 
            title: 'Instructor', 
            data: 'instructor_nombres',
            render: (data, type, row) => `${row.instructor_nombres} ${row.instructor_apellidos}`
        },
        { title: 'Compañía', data: 'compania_nombre' },
        { title: 'Fecha Inicio', data: 'horario_fecha_inicio' },
        { title: 'Fecha Fin', data: 'horario_fecha_fin' },
        { title: 'Hora Inicio', data: 'horario_hora_inicio' },
        { title: 'Hora Fin', data: 'horario_hora_fin' },
        { title: 'Ubicación', data: 'horario_ubicacion' },
        {
            title: 'Estado',
            data: 'horario_estado',
            render: (data, type, row) => {
                let clase = 'bg-secondary';
                if (data === 'PROGRAMADO') clase = 'bg-warning';
                if (data === 'EN_CURSO') clase = 'bg-info';
                if (data === 'FINALIZADO') clase = 'bg-success';
                if (data === 'CANCELADO') clase = 'bg-danger';
                return `<span class="badge ${clase}">${data}</span>`;
            }
        },
        {
            title: 'Acciones',
            data: 'horario_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-capacitacion="${row.horario_capacitacion_id}"  
                         data-instructor="${row.horario_instructor_id}"  
                         data-compania="${row.horario_compania_id}"  
                         data-fecha-inicio="${row.horario_fecha_inicio}"  
                         data-fecha-fin="${row.horario_fecha_fin}"  
                         data-hora-inicio="${row.horario_hora_inicio}"  
                         data-hora-fin="${row.horario_hora_fin}"  
                         data-ubicacion="${row.horario_ubicacion}"  
                         data-estado="${row.horario_estado}"  
                         data-observaciones="${row.horario_observaciones || ''}">
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

    document.getElementById('horario_id').value = datos.id;
    document.getElementById('horario_capacitacion_id').value = datos.capacitacion;
    document.getElementById('horario_instructor_id').value = datos.instructor;
    document.getElementById('horario_compania_id').value = datos.compania;
    document.getElementById('horario_fecha_inicio').value = datos.fechaInicio;
    document.getElementById('horario_fecha_fin').value = datos.fechaFin;
    document.getElementById('horario_hora_inicio').value = datos.horaInicio;
    document.getElementById('horario_hora_fin').value = datos.horaFin;
    document.getElementById('horario_ubicacion').value = datos.ubicacion;
    document.getElementById('horario_estado').value = datos.estado;
    document.getElementById('horario_observaciones').value = datos.observaciones;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

const limpiarTodo = () => {
    FormHorarios.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    
    // Ocultar información de duración
    document.getElementById('duracion-info').style.display = 'none';
    
    const campos = ['horario_capacitacion_id', 'horario_instructor_id', 'horario_compania_id', 'horario_ubicacion'];
    campos.forEach(campoId => {
        const campo = document.getElementById(campoId);
        if (campo) {
            campo.classList.remove('is-invalid', 'is-valid');
        }
    });
}

const ModificarHorario = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormHorarios, ['horario_id'])) {
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

    const body = new FormData(FormHorarios);
    const url = '/sic_final_capacitaciones_ingSoft1/horario/modificarAPI';
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
            BuscarHorarios();
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

const EliminarHorarios = async (e) => {
    const idHorario = e.currentTarget.dataset.id;

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Desea ejecutar esta acción?",
        text: 'Esta completamente seguro que desea eliminar este horario',
        showConfirmButton: true,
        confirmButtonText: 'Si, Eliminar',
        confirmButtonColor: 'red',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/sic_final_capacitaciones_ingSoft1/horario/eliminarAPI?id=${idHorario}`;
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
                BuscarHorarios();
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
                text: "No se pudo conectar con el servidor para eliminar el horario.",
                showConfirmButton: true,
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    CargarCapacitaciones();
    CargarInstructores();
    CargarCompanias();
});

datatable.on('click', '.eliminar', EliminarHorarios);
datatable.on('click', '.modificar', llenarFormulario);
FormHorarios.addEventListener('submit', GuardarHorario);
document.getElementById('horario_fecha_fin').addEventListener('change', ValidarFechas);
SelectCapacitacion.addEventListener('change', MostrarDuracionCapacitacion);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarHorario);
BtnBuscar.addEventListener('click', BuscarHorarios);
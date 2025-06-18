import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const FormInstructores = document.getElementById('FormInstructores');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const InputInstructorTel = document.getElementById('instructor_telefono');
const BtnBuscar = document.getElementById('BtnBuscar');

const ValidarTelefono = () => {
    const CantidadDigitos = InputInstructorTel.value;

    if (CantidadDigitos.length < 1) {
        InputInstructorTel.classList.remove('is-valid', 'is-invalid');
    } else {
        if (CantidadDigitos.length != 8) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Revise el numero de telefono",
                text: "La cantidad de digitos debe ser exactamente 8 digitos",
                showConfirmButton: true,
            });
            InputInstructorTel.classList.remove('is-valid');
            InputInstructorTel.classList.add('is-invalid');
        } else {
            InputInstructorTel.classList.remove('is-invalid');
            InputInstructorTel.classList.add('is-valid');
        }
    }
}

const GuardarInstructor = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormInstructores, ['instructor_id'])) {
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

    const body = new FormData(FormInstructores);
    const url = '/sic_final_capacitaciones_ingSoft1/instructor/guardarAPI';
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

const BuscarInstructores = async () => {
    const url = '/sic_final_capacitaciones_ingSoft1/instructor/buscarAPI';
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

const datatable = new DataTable('#TableInstructores', {
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
            data: 'instructor_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Nombres', data: 'instructor_nombres' },
        { title: 'Apellidos', data: 'instructor_apellidos' },
        { title: 'Grado', data: 'instructor_grado' },
        { title: 'Arma', data: 'instructor_arma' },
        { title: 'Teléfono', data: 'instructor_telefono' },
        {
            title: 'Estado',
            data: 'instructor_situacion',
            render: (data, type, row) => {
                return data == 1 ? '<span class="badge bg-success">ACTIVO</span>' : '<span class="badge bg-danger">INACTIVO</span>';
            }
        },
        {
            title: 'Acciones',
            data: 'instructor_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-nombres="${row.instructor_nombres}"  
                         data-apellidos="${row.instructor_apellidos}"  
                         data-grado="${row.instructor_grado}"  
                         data-arma="${row.instructor_arma}"  
                         data-telefono="${row.instructor_telefono}">
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

    document.getElementById('instructor_id').value = datos.id;
    document.getElementById('instructor_nombres').value = datos.nombres;
    document.getElementById('instructor_apellidos').value = datos.apellidos;
    document.getElementById('instructor_grado').value = datos.grado;
    document.getElementById('instructor_arma').value = datos.arma;
    document.getElementById('instructor_telefono').value = datos.telefono;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

const limpiarTodo = () => {
    FormInstructores.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    InputInstructorTel.classList.remove('is-valid', 'is-invalid');
    
    const campos = ['instructor_nombres', 'instructor_apellidos', 'instructor_grado', 'instructor_arma', 'instructor_telefono'];
    campos.forEach(campoId => {
        const campo = document.getElementById(campoId);
        if (campo) {
            campo.classList.remove('is-invalid', 'is-valid');
        }
    });
}

const ModificarInstructor = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormInstructores, ['instructor_id'])) {
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

    const body = new FormData(FormInstructores);
    const url = '/sic_final_capacitaciones_ingSoft1/instructor/modificarAPI';
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
            BuscarInstructores();
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

const EliminarInstructores = async (e) => {
    const idInstructor = e.currentTarget.dataset.id;

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Desea ejecutar esta acción?",
        text: 'Esta completamente seguro que desea eliminar este instructor',
        showConfirmButton: true,
        confirmButtonText: 'Si, Eliminar',
        confirmButtonColor: 'red',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {
        const url = `/sic_final_capacitaciones_ingSoft1/instructor/eliminarAPI?id=${idInstructor}`;
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
                BuscarInstructores();
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
                text: "No se pudo conectar con el servidor para eliminar el instructor.",
                showConfirmButton: true,
            });
        }
    }
}

// Event Listeners
datatable.on('click', '.eliminar', EliminarInstructores);
datatable.on('click', '.modificar', llenarFormulario);
FormInstructores.addEventListener('submit', GuardarInstructor);
InputInstructorTel.addEventListener('change', ValidarTelefono);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarInstructor);
BtnBuscar.addEventListener('click', BuscarInstructores);
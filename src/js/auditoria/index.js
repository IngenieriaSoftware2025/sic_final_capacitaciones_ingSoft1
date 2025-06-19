import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { Chart } from "chart.js/auto";

const btnMostrarActividades = document.getElementById('btnMostrarActividades');
const seccionGrafica = document.getElementById('seccionGrafica');
const seccionTabla = document.getElementById('seccionTabla');
const grafico1 = document.getElementById("grafico1").getContext("2d");

let tablaActividades;
let graficaUsuarios;

const mostrarSecciones = () => {
    if (seccionTabla.style.display === 'none') {
        seccionGrafica.style.display = 'block';
        seccionTabla.style.display = 'block';
        btnMostrarActividades.textContent = 'Ocultar Actividades';
        cargarDatos();
    } else {
        seccionGrafica.style.display = 'none';
        seccionTabla.style.display = 'none';
        btnMostrarActividades.textContent = 'Ver Actividades del Sistema';
    }
};

const cargarActividades = async () => {
    const url = '/auditorias/buscarAPI';
    const config = { method: 'GET' }
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, data } = datos;
        
        if (codigo == 1) {
            if (tablaActividades) {
                tablaActividades.clear();
                tablaActividades.rows.add(data);
                tablaActividades.draw();
            }
        }
    } catch (error) {
        console.log(error);
    }
};

const cargarUsuariosActivos = async () => {
    const url = '/auditorias/usuariosActivosAPI';
    const config = { method: 'GET' }
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, data } = datos;
        
        if (codigo == 1) {
            const labels = data.map(usuario => usuario.usuario);
            const valores = data.map(usuario => parseInt(usuario.total));
            
            graficaUsuarios.data.labels = labels;
            graficaUsuarios.data.datasets = [{
                label: 'Actividades',
                data: valores,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
            }];
            graficaUsuarios.update();
        }
    } catch (error) {
        console.log(error);
    }
};

const inicializarTabla = () => {
    tablaActividades = new DataTable('#tablaActividades', {
        language: lenguaje,
        data: [],
        columns: [
            { data: 'historial_id' },
            { data: 'usuario_nombre' },
            { data: 'accion' },
            { 
                data: 'historial_ejecucion',
                render: function(data) {
                    return data.length > 30 ? data.substring(0, 30) + '...' : data;
                }
            },
            { 
                data: 'historial_fecha',
                render: function(data) {
                    return new Date(data).toLocaleString('es-GT');
                }
            }
        ],
        pageLength: 10,
        order: [[0, 'desc']]
    });
};

const inicializarGrafica = () => {
    graficaUsuarios = new Chart(grafico1, {
        type: 'bar',
        data: { labels: [], datasets: [] },
        options: { 
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });
};

const cargarDatos = () => {
    cargarActividades();
    cargarUsuariosActivos();
};

document.addEventListener('DOMContentLoaded', function() {
    inicializarTabla();
    inicializarGrafica();
});

btnMostrarActividades.addEventListener('click', mostrarSecciones);
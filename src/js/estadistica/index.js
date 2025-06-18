import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from "../funciones";
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { Chart } from "chart.js/auto";

const grafico1 = document.getElementById("grafico1").getContext("2d");
const grafico2 = document.getElementById("grafico2").getContext("2d");

function getColorForEntrenamiento(cantidad) {
    let color = "";
    if(cantidad > 10){
        color = "paleturquoise";
    } else if(cantidad > 5 && cantidad <= 10){
        color = "pink";
    } else if(cantidad > 2 && cantidad <= 5){
        color = 'thistle';
    } else if(cantidad <= 2){
        color = 'peachpuff';
    }
    return color;
}

window.graficaUnidades = new Chart(grafico1, {
    type: 'pie',
    data: { labels: [], datasets: [] },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
});

window.graficaInstructores = new Chart(grafico2, {
    type: 'bar',
    data: { labels: [], datasets: [] },
    options: { responsive: true, indexAxis: 'y', scales: { x: { beginAtZero: true } } }
});


const BuscarEntrenamientoUnidades = async () => {
    try {
        const respuesta = await fetch('/sic_final_capacitaciones_ingSoft1/estadistica/buscarUnidadesAPI');
        const datos = await respuesta.json();
        
        if (datos.codigo == 1) {
            const unidades = [];
            const datosUnidades = new Map();
            
            datos.data.forEach(d => {
                if (!datosUnidades.has(d.unidad)) {
                    datosUnidades.set(d.unidad, d.total_entrenamientos);
                    unidades.push({ 
                        unidad: d.unidad, 
                        compania_id: d.compania_id, 
                        total_entrenamientos: d.total_entrenamientos 
                    });
                }
            });
            
            const etiquetasUnidades = [...new Set(datos.data.map(d => d.unidad))];
            const datasets = unidades.map(e => ({
                label: e.unidad,
                data: etiquetasUnidades.map(unidad => {
                    const match = datos.data.find(d => d.unidad === unidad && e.unidad === d.unidad);
                    return match ? match.total_entrenamientos : 0;
                }),
                backgroundColor: getColorForEntrenamiento(e.total_entrenamientos)
            }));
            
            window.graficaUnidades.data.labels = etiquetasUnidades;
            window.graficaUnidades.data.datasets = datasets;
            window.graficaUnidades.update();
        }
    } catch (error) {
        console.log(error);
    }
}

const BuscarCatedraInstructores = async () => {
    try {
        const respuesta = await fetch('/sic_final_capacitaciones_ingSoft1/estadistica/buscarInstructoresAPI');
        const datos = await respuesta.json();
        
        if (datos.codigo == 1) {
            const labels = datos.data.map(instructor => `${instructor.instructor} (${instructor.instructor_grado})`);
            const valores = datos.data.map(instructor => parseInt(instructor.total_catedras));
            
            window.graficaInstructores.data.labels = labels;
            window.graficaInstructores.data.datasets = [{
                label: 'Cátedras Impartidas',
                data: valores,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
            }];
            window.graficaInstructores.update();
        }
    } catch (error) {
        console.log(error);
    }
}

BuscarEntrenamientoUnidades();
BuscarCatedraInstructores();
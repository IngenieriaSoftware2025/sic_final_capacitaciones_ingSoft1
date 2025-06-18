import L from 'leaflet';

// Coordenadas de la Brigada de Comunicaciones del Ejército
const map = L.map('map').setView([14.575684, -90.533469], 16);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
}).addTo(map);

L.marker([14.575684, -90.533469]).addTo(map)
.bindPopup('Area de entrenamiento BCE')
.openPopup();
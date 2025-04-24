<?= $this->extend('layouts/header-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <h2>Research and Innovation Centers Map</h2>
        <div id="map" style="height: 500px;"></div>
    </div>
</section>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    var map = L.map('map').setView([10.7202, 122.5621], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Define a custom large location icon (location pin)
    var locationIcon = L.icon({
        iconUrl: 'https://upload.wikimedia.org/wikipedia/commons/4/4f/Map_marker_icon_%28location%29.svg', // URL to the icon image (location pin)
        iconSize: [48, 48], // Increase the size of the icon to make it more visible
        iconAnchor: [24, 48], // Point of the icon which will correspond to the marker's location
        popupAnchor: [0, -48] // Point from which the popup will open relative to the icon anchor
    });

    // Load research center markers from controller
    fetch('/centers')
        .then(response => response.json())
        .then(data => {
            data.forEach(center => {
                if (center.latitude && center.longitude) {
                    L.marker([center.latitude, center.longitude], { icon: locationIcon }) // Apply the large location icon
                        .addTo(map)
                        .bindPopup(`<b>${center.name}</b>`);
                }
            });
        })
        .catch(error => {
            console.error('Error loading center data:', error);
        });
</script>

<?= $this->endSection() ?>
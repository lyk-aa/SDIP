<?= $this->extend('layouts/header-layout') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <div id="map"></div>
    </div>
</section>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<script>
    var map = L.map('map').setView([10.7202, 122.5621], 13);


    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);


    L.marker([10.7202, 122.5621]).addTo(map)
        .bindPopup('<b>Iloilo City</b><br>Center of Western Visayas.')
        .openPopup();
</script>


<?= $this->endSection() ?>
@extends('layouts.app')

@section('content')

<div class="aq-page-header">

    <div>

        <h2 class="aq-page-title">
            Device Map
        </h2>

        <p class="aq-page-subtitle">
            Monitoring lokasi seluruh perangkat Aqualyze.
        </p>

    </div>

</div>

<div class="aq-card">

    <div class="aq-card-header">

        <span class="aq-card-title">
            Lokasi Device
        </span>

    </div>

    <div class="aq-card-body">

        <div id="map"></div>

    </div>

</div>
@push('scripts')

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const map = L.map('map').setView([-6.8914, 107.6107], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{

        maxZoom:19,

        attribution:'© OpenStreetMap'

    }).addTo(map);

    const devices = @json($devices);

    const group = L.featureGroup();

    const greenIcon = new L.Icon({

        iconUrl:
        'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',

        shadowUrl:
        'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',

        iconSize:[25,41],

        iconAnchor:[12,41],

        popupAnchor:[1,-34],

        shadowSize:[41,41]

    });

    const redIcon = new L.Icon({

        iconUrl:
        'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',

        shadowUrl:
        'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',

        iconSize:[25,41],

        iconAnchor:[12,41],

        popupAnchor:[1,-34],

        shadowSize:[41,41]

    });

    devices.forEach(device => {

        if(device.latitude && device.longitude){

            const marker = L.marker(

                [
                    device.latitude,
                    device.longitude
                ],

                {

                    icon:
                        device.status === "online"
                            ? greenIcon
                            : redIcon

                }

            ).addTo(map);

            marker.bindPopup(`

            <div style="min-width:220px">


                <table style="width:100%;font-size:13px">

                    <tr>
                        <td><b>ID</b></td>
                        <td>${device.device_id}</td>
                    </tr>

                    <tr>
                        <td><b>Status</b></td>
                        <td>

                            ${
                                device.status==="online"

                                ? "🟢 Online"

                                : "🔴 Offline"

                            }

                        </td>
                    </tr>

                    <tr>
                        <td><b>Lokasi</b></td>
                        <td>${device.lokasi ?? "-"}</td>
                    </tr>

                    <tr>
                        <td><b>Last Seen</b></td>
                        <td>${device.last_seen ?? "-"}</td>
                    </tr>

                </table>

            </div>

            `);

            group.addLayer(marker);

        }

    });

    if(group.getLayers().length){

        map.fitBounds(group.getBounds(),{

            padding:[50,50]

        });

    }

});

</script>

@endpush
@endsection
<x-app-layout :title="__('Edit Entry') . ': ' . $meetingPoint->title">
    <x-app-container>
        <x-page-title>{{__('Entry Details')}}</x-page-title>
        <form action="{{route('meeting_points.update', $meetingPoint)}}" method="POST" class="cpt-form">
            @csrf
            @method('PUT')
            <x-form-group name="title" :label="__('Title')" :required="true" :value="old('title', $meetingPoint->title)" :fullwidth="true"/>
            <x-form-group name="description" :label="__('Description')" :required="true" :value="old('description', $meetingPoint->description)" :fullwidth="true" type="textarea"/>
            <x-form-group name="meeting_time" :label="__('Meeting Time')" :required="true" :value="old('meeting_time', $meetingPoint->meeting_time)" :fullwidth="true" type="datetime-local"/>
            <x-form-group onchange="lookupLocation()" name="location" :label="__('Location')" :required="true" :value="old('location', $meetingPoint->location)" :fullwidth="true"/>
            <div class="w-full my-6">
                <div id="creation-map" class="aspect-square sm:aspect-16/9 md:aspect-16/7 w-full"></div>
            </div>
            <input type="hidden" name="latitude" id="creation-latitude">
            <input type="hidden" name="longitude" id="creation-longitude">
            <x-primary-button type="submit">{{__('Update Entry')}}</x-primary-button>
        </form>
    </x-app-container>
</x-app-layout>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
<script type="module">
import * as L from "https://unpkg.com/leaflet/dist/leaflet-src.esm.js";


const map = L.map('creation-map').fitBounds([[45.7769477403, 6.02260949059], [47.8308275417, 10.4427014502]]);
window.map = map;
window.L = L;
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
	maxZoom: 20,
	attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
}).addTo(map);
let markerLatLong = [
    {{ old('latitude', $meetingPoint->latitude) ?? 46.94648825 }},
    {{ old('longitude', $meetingPoint->longitude) ?? 7.444332430387075 }}
]
const marker = L.marker(markerLatLong, {
    draggable: true
}).addTo(map);

document.getElementById('creation-latitude').value = markerLatLong[0];
document.getElementById('creation-longitude').value = markerLatLong[1];

marker.on('dragend', function(e) {
    let lat = e.target._latlng.lat;
    let lon = e.target._latlng.lng;
    document.getElementById('creation-latitude').value = lat;
    document.getElementById('creation-longitude').value = lon;
    map.flyTo([lat, lon], 16, {
        animate: true,
        duration: 0.5
    });
    let locationInput = document.querySelector("[name=location]");
    locationInput.setCustomValidity("");
    if (locationInput.previousElementSibling.classList.contains('cpt-alert')) {
        locationInput.previousElementSibling.remove();
    }
});

window.marker = marker;
</script>

<script>
async function lookupLocation() {
    const L = window.L;
    const map = window.map;
    const marker = window.marker;

    let e = window.event;
    if (e.target.previousElementSibling.classList.contains('cpt-alert')) {
        e.target.previousElementSibling.remove();
    }
    let location = e.target.value;
    let input = e.target;
    input.setCustomValidity("{{__('Please wait...')}}");
    let url = "https://nominatim.openstreetmap.org/search?q=" + location + "&format=json";
    let response = await fetch(url);
    let data = await response.json();
    if (data.length == 0) {
        let alert = document.createElement('div');
        alert.classList.add('cpt-alert');
        alert.classList.add('red');
        alert.innerHTML ="{{__('Sorry, we couldn\'t find that location.')}}";
        input.parentNode.insertBefore(alert, input);
        input.setCustomValidity(`{!!__("Sorry, we couldn't find that location.")!!}`);
        return;
    }
    input.setCustomValidity("");
    let locationData = data[0];
    let lat = locationData.lat;
    let lon = locationData.lon;
    document.getElementById('creation-latitude').value = lat;
    document.getElementById('creation-longitude').value = lon;
    marker.setLatLng([lat, lon]);
    map.flyTo([lat, lon], 16, {
        animate: true,
        duration: 0.5
    });
}
</script>

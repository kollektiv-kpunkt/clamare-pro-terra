<x-guest-layout>
    <h1 class="text-2xl !leading-none text-center font-black uppercase text-rose-500">{{$title}}</h1>
    <form action="{{route('create.store')}}" method="POST">
        @csrf
    <div class="mt-4">
        <x-input-label for="title" :value="__('Event Name')" />
        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>
    <div class="mt-4">
        <x-input-label for="meeting_time" :value="__('Event Date')" />
        <x-text-input id="meeting_time" class="block mt-1 w-full" type="datetime-local" name="meeting_time" :value="old('meeting_time')" required autofocus />
        <x-input-error :messages="$errors->get('meeting_time')" class="mt-2" />
    </div>
    <div class="mt-4">
        <x-input-label for="description" :value="__('Description')" />
        <x-textarea-input id="description" class="block mt-1 w-full" name="description" :value="old('description')" required autofocus />
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
        <p class="text-sm italic mt-2">{{__("Please describe your event briefly.")}}</p>
    </div>
    <div class="mt-4">
        <x-input-label for="location" :value="__('Location')" />
        <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" onchange="lookupLocation()" :value="old('location')" autofocus required/>
        <x-input-error :messages="$errors->get('location')" class="mt-2" />
    </div>
    <div class="w-full my-6">
        <div id="creation-map" class="aspect-square w-full"></div>
    </div>
    <input type="hidden" name="latitude" id="creation-latitude">
    <input type="hidden" name="longitude" id="creation-longitude">
    <div class="mt-4">
        <x-input-label for="user_email" :value="__('E-mail')" />
        <x-text-input id="user_email" class="block mt-1 w-full" type="email" name="user_email" :value="old('user_email')" autofocus placeholder="optional"/>
        <x-input-error :messages="$errors->get('user_email')" class="mt-2" />
        <p class="text-sm italic mt-2">{{__("If you want to be able to edit this entry in the future, please provide an email address so that we can either create a user for you or assign this event to an existing user.")}}</p>
    </div>
    <input type="hidden" name="type" value="{{$type}}"">
    <div class="mt-8 flex justify-end">
        <x-primary-button type="submit" class="w-full">{{__('Create Event')}}</x-primary-button>
    </div>

    <!-- Mapfunctions -->
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
            {{ old('latitude') ?? 46.94648825 }},
            {{ old('longitude') ?? 7.444332430387075 }}
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
            let loader = createLoader();
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
            setTimeout(() => {
                removeLoader(loader);
            }, 500);
        }

        function createLoader() {
            let loader = document.createElement("div");
            loader.classList.add("cpt-form-loader");
            loader.innerHTML = `
            <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            `;
            document.body.appendChild(loader);
            setTimeout(() => {
                loader.style.opacity = 1;
            }, 100);
            return loader;
        }

        function removeLoader(loader) {
            loader.style.opacity = 0;
            setTimeout(() => {
                loader.remove();
            }, 500);
        }
        </script>

        <style>
        .cpt-form-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 9999;
            color: white;
            font-size: 3rem;
            opacity: 0;
            transition: 0.5s ease opacity;
        }
        .lds-default {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-default div {
            position: absolute;
            width: 6px;
            height: 6px;
            background: #fff;
            border-radius: 50%;
            animation: lds-default 1.2s linear infinite;
        }

        .lds-default div:nth-child(1) {
            animation-delay: 0s;
            top: 37px;
            left: 66px;
        }

        .lds-default div:nth-child(2) {
            animation-delay: -0.1s;
            top: 22px;
            left: 62px;
        }

        .lds-default div:nth-child(3) {
            animation-delay: -0.2s;
            top: 11px;
            left: 52px;
        }

        .lds-default div:nth-child(4) {
            animation-delay: -0.3s;
            top: 7px;
            left: 37px;
        }

        .lds-default div:nth-child(5) {
            animation-delay: -0.4s;
            top: 11px;
            left: 22px;
        }

        .lds-default div:nth-child(6) {
            animation-delay: -0.5s;
            top: 22px;
            left: 11px;
        }

        .lds-default div:nth-child(7) {
            animation-delay: -0.6s;
            top: 37px;
            left: 7px;
        }

        .lds-default div:nth-child(8) {
            animation-delay: -0.7s;
            top: 52px;
            left: 11px;
        }

        .lds-default div:nth-child(9) {
            animation-delay: -0.8s;
            top: 62px;
            left: 22px;
        }

        .lds-default div:nth-child(10) {
            animation-delay: -0.9s;
            top: 66px;
            left: 37px;
        }

        .lds-default div:nth-child(11) {
            animation-delay: -1s;
            top: 62px;
            left: 52px;
        }

        .lds-default div:nth-child(12) {
            animation-delay: -1.1s;
            top: 52px;
            left: 62px;
        }

        @keyframes lds-default {

            0%,
            20%,
            80%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.5);
            }
        }
        </style>
    <!-- Mapfunctions -->

</x-guest-layout>

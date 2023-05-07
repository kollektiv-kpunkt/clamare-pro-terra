<script>
	import Section from './Section.svelte';
	import Button from './Button.svelte';
	import { _, json } from 'svelte-i18n';
	import { onMount } from 'svelte';
	import { browser } from '$app/environment';
	import { LeafletMap, TileLayer } from 'svelte-leafletjs?client';
	import 'leaflet/dist/leaflet.css';

	const mapOptions = {
		center: [1.364917, 103.822872],
		zoom: 11
	};
	const tileUrl = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
	const tileLayerOptions = {
		minZoom: 0,
		maxZoom: 20,
		maxNativeZoom: 19,
		attribution: '© OpenStreetMap contributors'
	};

	let leafletMap;
	let map;
	onMount(() => {
		map = leafletMap.getMap();
		map.fitBounds([
			[45.7769477403, 6.02260949059],
			[47.8308275417, 10.4427014502]
		]);
	});

	onMount(async () => {
		const response = await fetch('https://cpt-admin.ddev.site/api/meetingpoints');
		const data = await response.json();
		addMeetingpoints(data);
	});

	let meetingPoints = [];
	function addMeetingpoints(markers) {
		markers.forEach((marker) => {
			let markerOptions = {
				title: marker.title,
				icon: L.icon({
					iconUrl: '/images/markers/meetingpoint-icon.png',
					iconSize: [50, 50],
					iconAnchor: [25, 50],
					popupAnchor: [0, -50]
				})
			};
			let item = L.marker([marker.latitude, marker.longitude], markerOptions).addTo(map);
			item.addEventListener('click', () => {
				meetingPoints.forEach((marker) => {
					if (marker != item) {
						marker.zoom = false;
					}
				});
				map.flyTo([marker.latitude, marker.longitude], 17, {
					duration: 1
				});
				setTimeout(() => {
					openPopup(marker);
				}, 1200);
			});
			meetingPoints.push(item);
		});
	}

	function removeMeetingpoints() {
		meetingPoints.forEach((marker) => {
			map.removeLayer(marker);
		});
	}

	function openPopup(item) {
		popup.visible = true;
		popup.title = item.title;
		popup.description = item.description;
		popup.location = item.location;
	}

	function closePopup() {
		popup.visible = false;
		map.fitBounds([
			[45.7769477403, 6.02260949059],
			[47.8308275417, 10.4427014502]
		]);
	}

	let popup = {
		visible: false,
		title: '',
		description: '',
		location: ''
	};
</script>

<Section classNames="!px-0">
	<div class="cpt-strikemap__outer">
		<div class="cpt-container cpt-container--small cpt-strikemap">
			<div class="flex justify-center">
				<h2 class="cpt-text-highlight text-3xl md:text-5xl text-center">
					{$_('strikemap.title')}
				</h2>
			</div>
			<div class="cpt-strikemap__map mt-8 md:mt-12">
				{#if browser}
					<LeafletMap options={mapOptions} bind:this={leafletMap}>
						<TileLayer url={tileUrl} options={tileLayerOptions} />
					</LeafletMap>
				{/if}
			</div>
			<div class="text-center mt-10">
				{#if popup.visible == true}
					<div class="p-4 bg-accent text-white mb-8 relative">
						<h3 class="text-2xl">{popup.title}</h3>
						<p class="mt-4">{popup.description}</p>
						<p class="mt-2">{popup.location}</p>
						<i class="icofont-close-circled absolute top-2 left-2 text-xl" on:click={closePopup} />
					</div>
				{/if}
				{#each $json('strikemap.content') as content}
					<p>{content}</p>
				{/each}
				<Button href="/create-event" classes="block mt-5">Event organisieren</Button>
			</div>
		</div>
	</div>
</Section>

<style lang="scss">
	.cpt-strikemap {
		&__outer {
			background-image: linear-gradient(
				180deg,
				white 0%,
				white calc(0% + var(--offset)),
				theme('colors.secondary') calc(0% + var(--offset)),
				theme('colors.secondary') 100%
			);
			--offset: 15rem;

			@media (max-width: 767px) {
				--offset: 10rem;
			}
		}
		&__map {
			width: calc(100% + 8rem);
			margin-left: -4rem;
			aspect-ratio: 16/9;

			@apply drop-shadow-2xl;

			@media (max-width: 1023px) {
				width: 100%;
				margin-left: 0;
			}
		}
	}
</style>

<script>
	
</script>

<div id="map" style="height: 80vh;">
	{#if browser}
		<LeafletMap options={mapOptions}>
			<TileLayer url={tileUrl} options={tileLayerOptions} />
		</LeafletMap>
	{/if}
</div>

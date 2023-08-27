<script>
	import { _, json } from 'svelte-i18n';

	export let visible = false;
	let domelement;

	$: visible, changeVisibility(visible);

	function changeVisibility(visible) {
		if (domelement === undefined) return;
		if (visible) {
			domelement.animate(
				[
					{ opacity: 0, visibility: 'hidden' },
					{ opacity: 1, visibility: 'visible' }
				],
				{
					duration: 500,
					easing: 'ease-in-out',
					fill: 'forwards'
				}
			);
		} else {
			domelement.animate(
				[
					{ opacity: 1, visibility: 'visible' },
					{ opacity: 0, visibility: 'hidden' }
				],
				{
					duration: 500,
					easing: 'ease-in-out',
					fill: 'forwards'
				}
			);
		}
	}
</script>

<div class="cpt-downloadables" bind:this={domelement}>
	<div class="w-full cpt-container cpt-container--large flex">
		<div class="p-12 my-auto">
			<h2 class="cpt-text-highlight text-3xl md:text-5xl">{$_('downloadables.title')}</h2>
			<p class="mt-4">{$_('downloadables.content')}</p>
			<div class="mt-8 cpt-downloadables__grid grid grid-cols-2 md:grid-cols-4 gap-6">
				{#each $json('downloadables.materials') as downloadable}
					<div class="cpt-material-item">
						<div class="p-1 md:p-2 bg-white">
							<a href={downloadable.download} download={downloadable.download.split('/').pop()}>
								<img
									src={downloadable.preview}
									alt={downloadable.title}
									class="aspect-square object-contain"
								/>
							</a>
						</div>
						<p class="mt-2">{downloadable.title}</p>
					</div>
				{/each}
			</div>
		</div>
		<button class="fixed top-4 left-4 text-accent" on:click={() => (visible = false)}
			><i class="icofont-ui-close" /></button
		>
	</div>
</div>

<style lang="scss">
	.cpt-downloadables {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: theme('colors.secondary');
		z-index: 1000;
		display: flex;

		overflow-y: auto;
		visibility: hidden;
		opacity: 0;
	}
</style>

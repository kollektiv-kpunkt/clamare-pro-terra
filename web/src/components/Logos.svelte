<script>
	import { onMount } from 'svelte';
	import { each } from 'svelte/internal';

	let orgas = [];

	onMount(async () => {
		const res = await fetch(`/api/orgas`);
		orgas = await res.json();
		orgas = orgas.orgas;
	});
</script>

<div class="cpt-logos-section mt-14 md:mt-20">
	<!-- svelte-ignore a11y-distracting-elements -->
	<marquee behavior="scroll" direction="left" scrollamount="6">
		<div class="flex gap-4">
			{#each orgas as orga}
				<img src={orga} alt="" />
			{:else}
				<p>loading...</p>
			{/each}
		</div>
	</marquee>
</div>

<style lang="scss">
	.cpt-logos-section img {
		width: 10vw;
		height: 10vw;
		object-fit: contain;

		@media (max-width: 767px) {
			width: 25vw;
			height: 25vw;
		}
	}
</style>

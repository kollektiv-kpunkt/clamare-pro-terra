<script>
	import { _, json } from 'svelte-i18n';
</script>

<div class="cpt-donate">
	<h2 class="cpt-text-highlight text-3xl md:text-5xl">{$_('donate.title')}</h2>
	<div class="cpt-donation-details mt-8">
		<p>{$_('donate.content')}</p>
		<p>
			{#each $json('donate.details') as detail}
				{@html detail} <br />
			{/each}
		</p>
	</div>
</div>

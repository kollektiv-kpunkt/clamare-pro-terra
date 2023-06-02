<script>
	import Section from './Section.svelte';
	import Button from './Button.svelte';
	import { _, json, locale } from 'svelte-i18n';
</script>

<Section classNames="cpt-container cpt-container--small">
	<div class="text-center">
		<h2 class="cpt-text-highlight text-3xl md:text-5xl text-center">
			{$_('supportchannel.title')}
		</h2>
		<div class="mt-12">
			{#each $json('supportchannel.content') as paragraph}
				<p>{@html paragraph}</p>
			{/each}
		</div>

		<Button href={$_('supportchannel.href')} target="_blank" outline={true} classes="!block mt-4"
			>{$_('supportchannel.button')}</Button
		>
	</div>
</Section>

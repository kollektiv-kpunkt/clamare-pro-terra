<script>
	import Head from '../../components/Head.svelte';
	import { _, json } from 'svelte-i18n';
	import Button from '../../components/Button.svelte';

	/**
	 * Stylesheet:
	 * - src/styles/app.scss
	 */
	import '../../styles/app.scss';
</script>

<main id="svelte-main-container">
	<Head />
	<div class="max-w-2xl px-4 mx-auto py-24">
		<h1 class="cpt-text-highlight text-3xl md:text-5xl">{$_('speeches.title')}</h1>
		<div class="speeches-content mt-8 md:text-lg">
			<p>{$_('speeches.content')}</p>
			<div class="speeches-grid grid grid-cols-2 md:grid-cols-3 gap-8 mt-6">
				{#each Object.entries($json('speeches.speeches')) as [key, title]}
					<a class="speeches-speech" href="/media/speeches/{key}.pdf" target="_blank">
						<img src="/images/speeches/{key}.jpg" alt="Preview image for the speech '{title}'" />
						<p class="text-sm italic">{$_('speeches.speech')}</p>
						<p class="mt-[-0.25rem] font-bold">{title}</p>
					</a>
				{/each}
			</div>
		</div>
		<Button classes="mt-12" href="/media/speeches/all_speeches.pdf" target="_blank"
			>{$_('speeches.all_speeches')}</Button
		>
	</div>
</main>

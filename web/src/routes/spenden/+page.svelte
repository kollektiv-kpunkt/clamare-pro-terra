<script>
	import { onMount } from 'svelte';
	import Head from '../../components/Head.svelte';
	import { _, json, locale } from 'svelte-i18n';
	import Button from '../../components/Button.svelte';

	/**
	 * Stylesheet:
	 * - src/styles/app.scss
	 */
	import '../../styles/app.scss';

	onMount(() => {
		let script = document.createElement('script');
		script.src = 'https://tamaro.raisenow.com/klima-3a25/latest/widget.js';
		document.querySelector('.rnw-widget-container').parentNode.appendChild(script);
		script.onload = () => {
			window.rnw.tamaro.runWidget('.rnw-widget-container', {
				language: $locale,
				paymentFormPrefill: {
					stored_campaign_name: 'Klimademo | Manif Climat'
				}
			});
		};
	});
</script>

<main id="svelte-main-container">
	<Head />
	<div class="max-w-2xl px-4 mx-auto py-24">
		<h1 class="cpt-text-highlight text-3xl md:text-5xl">{$_('donatepage.title')}</h1>
		<div class="speeches-content mt-8 md:text-lg">
			<p>{$_('donatepage.lead')}</p>
			<p>
				{#each $json('donate.details') as detail}
					{@html detail} <br />
				{/each}
			</p>
			<div class="rnw-widget-container pt-12" />
		</div>
	</div>
</main>

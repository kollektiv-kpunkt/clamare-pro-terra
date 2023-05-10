<script>
	import { onMount } from 'svelte';
	import { _, json, locale } from 'svelte-i18n';
	import Button from './Button.svelte';

	let onlineDonationContainer;

	function openDonationForm() {
		onlineDonationContainer.animate(
			[
				{ maxHeight: '0px' },
				{ maxHeight: onlineDonationContainer.scrollHeight + 'px', offset: 0.99 },
				{ maxHeight: 'unset' }
			],
			{
				duration: 500,
				easing: 'ease-in-out',
				fill: 'forwards'
			}
		);
	}

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
	<div class="cpt-online-donation max-h-0 overflow-hidden" bind:this={onlineDonationContainer}>
		<div class="rnw-widget-container pt-12" />
	</div>
	<Button classes="mt-8" onClick={openDonationForm}>Online Spenden</Button>
</div>

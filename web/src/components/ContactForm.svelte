<script>
	import { _, json, locale } from 'svelte-i18n';
	import FormField from './FormField.svelte';
	import Button from './Button.svelte';
	import { createLoader, removeLoader } from './formLoaders.js';
	import { Notyf } from 'notyf';
	import 'notyf/notyf.min.css';
	import { onMount } from 'svelte';

	let notyf;
	onMount(() => {
		notyf = new Notyf();
	});

	async function submitForm() {
		let e = window.event;
		let form = e.target;
		let loader = createLoader();
		let data = new FormData(form);
		let response = await fetch(form.action, {
			method: form.method,
			body: data,
			headers: {
				Accept: 'application/json'
			}
		});
		let json = await response.json();
		removeLoader(loader);
		setTimeout(() => {
			if (json.success) {
				notyf.success($_('contact.success'));
				form.reset();
			} else {
				notyf.error($_('contact.error'));
			}
		}, 300);
	}
</script>

<div class="cpt-contact-form">
	<h2 class="cpt-text-highlight text-3xl md:text-5xl">{$_('contact.title')}</h2>
	<form
		action="https://n8n.victorinus.ch/webhook/0b03ca24-977d-4118-bd30-ab9ba819b52c"
		method="POST"
		class="mt-8 md:mt-12"
		on:submit|preventDefault={submitForm}
	>
		{#each $json('contact.formFields') as field}
			<FormField {...field} />
		{/each}
		<input type="hidden" name="locale" value={$locale} />
		<div class="flex justify-end mt-4">
			<Button tag="button" type="submit">{$_('contact.send')}</Button>
		</div>
	</form>
</div>

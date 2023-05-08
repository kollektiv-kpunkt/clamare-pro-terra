<script>
	import { _, json } from 'svelte-i18n';
	import FormField from './FormField.svelte';
	import Button from './Button.svelte';
</script>

<div class="cpt-contact-form">
	<h2 class="cpt-text-highlight text-3xl md:text-5xl">{$_('contact.title')}</h2>
	<form action="/" method="POST" class="mt-8 md:mt-12">
		{#each $json('contact.formFields') as field}
			<FormField {...field} />
		{/each}
		<div class="flex justify-end mt-4">
			<Button tag="button" type="submit">{$_('contact.send')}</Button>
		</div>
	</form>
</div>

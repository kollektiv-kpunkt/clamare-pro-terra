<script>
	import Section from './Section.svelte';
	import ContactForm from './ContactForm.svelte';
	import Donate from './Donate.svelte';
</script>

<Section classNames="cpt-container cpt-container--large">
	<div class="grid md:grid-cols-2 gap-x-12 lg:gap-x-16 gap-y-12">
		<ContactForm />
		<Donate />
	</div>
</Section>

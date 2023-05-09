<script>
	import Section from './Section.svelte';
	import Question from './Question.svelte';

	import { _, json } from 'svelte-i18n';
</script>

<div id="more-info">
	<Section classNames="cpt-container cpt-container--full !px-0 bg-accent">
		<div class="cpt-faq-section-inner py-8 text-white cpt-container cpt-container--large">
			<h2 class="cpt-text-highlight cpt-text-highlight--white text-3xl md:text-5xl">
				{$_('faq.title')}
			</h2>
			<div class="cpt-faq-grid grid lg:grid-cols-2 gap-x-8 mt-4">
				{#each $json('faq.questions') as question}
					<Question {question} />
				{/each}
			</div>
		</div>
	</Section>
</div>

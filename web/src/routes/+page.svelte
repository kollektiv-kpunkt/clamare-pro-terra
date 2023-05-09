<script>
	/**
	 * Components:
	 * - Head
	 * - Heroine
	 * - Intro
	 * - Logos
	 * - Strikemap
	 * - SomeMaterial
	 * - FAQ
	 * - DetailSection
	 * - Footer
	 */
	import Head from '../components/Head.svelte';
	import Heroine from '../components/Heroine.svelte';
	import Intro from '../components/Intro.svelte';
	import Logos from '../components/Logos.svelte';
	import Strikemap from '../components/Strikemap.svelte';
	import SomeMaterial from '../components/SomeMaterial.svelte';
	import FAQ from '../components/FAQ.svelte';
	import DetailSection from '../components/DetailSection.svelte';
	import Footer from '../components/Footer.svelte';

	/**
	 * Stylesheet:
	 * - src/styles/app.scss
	 */
	import '../styles/app.scss';
</script>

<main id="svelte-main-container">
	<Head />
	<Heroine />
	<Intro />
	<Logos />
	<Strikemap />
	<SomeMaterial />
	<FAQ />
	<DetailSection />
	<Footer />
</main>

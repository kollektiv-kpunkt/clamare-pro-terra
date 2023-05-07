<script>
	/**
	 * Components:
	 * - Heroine
	 * - Intro
	 * - Logos
	 * - Strikemap
	 * - SomeMaterial
	 * - FAQ
	 * - DetailSection
	 * - Footer
	 */
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
	<Heroine />
	<Intro />
	<Logos />
	<Strikemap />
	<SomeMaterial />
	<FAQ />
	<DetailSection />
	<div style="height: 50vh" />
	<Footer />
</main>

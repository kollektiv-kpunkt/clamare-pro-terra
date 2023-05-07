<script>
	export let classNames = '';
	import IntersectionObserver from 'svelte-intersection-observer';

	if (classNames === '') {
		classNames = 'cpt-container cpt-container--large';
	}

	let element;
	let intersecting = false;

	$: if (intersecting) {
		if (!element.classList.contains('animate-fade-in-up')) {
			element.classList.add('animate-fade-in-up');
			setTimeout(() => {
				element.animate(
					[
						{ opacity: 0, transform: 'translate(0, 1em)' },
						{ opacity: 1, transform: 'translate(0, 0)' }
					],
					{
						duration: 250,
						easing: 'ease-in-out',
						fill: 'forwards'
					}
				);
			}, 500);
		}
	}
</script>

<IntersectionObserver {element} bind:intersecting threshold={0.15}>
	<div class="cpt-section" bind:this={element}>
		<div class="cpt-section__inner {classNames}">
			<slot />
		</div>
	</div>
</IntersectionObserver>

<style lang="scss">
	.cpt-section {
		opacity: 0;
		transform: translate(0, 1em);
		@apply pt-20 md:pt-32 lg:pt-40;
	}
</style>

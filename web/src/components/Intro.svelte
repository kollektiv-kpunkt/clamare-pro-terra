<script>
	import Button from './Button.svelte';
	import Section from './Section.svelte';

	import { _, json } from 'svelte-i18n';

	let element;
	let intersecting = false;

	$: if (intersecting) {
		element.classList.add('animate-fade-in-up');
	}

	function handleShare(platform) {
		console.log('handleShare', platform);
		let url = encodeURIComponent($_('intro.shareurl'));
		let text = encodeURIComponent($_('intro.sharetext'));
		switch (platform) {
			case 'telegram':
				url = `https://t.me/share/url?url=${url}&text=${text}`;
				break;
			case 'whatsapp':
				url = `https://api.whatsapp.com/send?text=${text} ${url}`;
				break;
			case 'facebook':
				url = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
				break;
			case 'twitter':
				url = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
				break;
		}
		window.open(url, '_blank');
	}

	const shareButtons = $json('intro.sharebuttons');
</script>

<Section>
	<div class="flex gap-x-16">
		<div class="w-full lg:w-1/2">
			<h2 class="cpt-text-highlight text-3xl md:text-5xl">{$_('intro.title')}</h2>
			<div class="intro-content mt-8 md:text-lg">
				{#each $json('intro.content') as paragraph}
					<p>{@html paragraph}</p>
				{/each}
			</div>
		</div>
		<div class="hidden lg:block w-1/2">
			<div class="cpt-intro-image-container">
				<img src="/images/intro/image-2.webp" alt="Intro" class="cpt-intro-image" />
				<img src="/images/intro/image-1.webp" alt="Intro" class="cpt-intro-image" />
			</div>
		</div>
	</div>
	<div class="cpt-intro-content2 mt-10 md:mt-20 cpt-container cpt-container--small !px-0">
		<p class="font-bold text-xl cpt-text-highlight">{$_('intro.content2.lead')}</p>
		<ul class="list-disc ml-4 mt-4">
			{#each $json('intro.content2.listitems') as item}
				<li class="mt-2">{@html item}</li>
			{/each}
		</ul>
		<p class="md:text-lg mt-4">{@html $_('intro.content2.cta')}</p>
		<div class="cpt-intro-share grid grid-cols-1 md:grid-cols-2 gap-2 mt-4 md:mt-6">
			{#each shareButtons as button}
				<Button
					classes="{button.type}-button"
					onClick={() => handleShare(button.type)}
					href="#cpt-share-{button.type}"
				>
					{button.text}
				</Button>
			{/each}
		</div>
	</div>
</Section>

<style lang="scss">
	.cpt-intro-image-container {
		@apply relative;
		aspect-ratio: 16/9;

		img {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			object-fit: cover;

			&:first-child {
				z-index: 1;
				transform: translate(-1em, 0em);
			}

			&:last-child {
				z-index: 2;
				transform: translate(1em, 6em);
			}
		}
	}
</style>

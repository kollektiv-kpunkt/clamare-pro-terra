<script>
	import { onMount } from 'svelte';
	import Section from './Section.svelte';
	import Button from './Button.svelte';
	import { _, json, locale } from 'svelte-i18n';
	import domtoimage from 'dom-to-image';

	let images = [];
	let loader = false;
	let profilePicture = false;
	let showForm = true;
	let successMessage = false;
	let successMessageDOM;
	let pfpDOM;

	onMount(async () => {
		images = await fetch('/api/profilepictures?locale=' + $locale).then((res) => res.json());
		images = images.pics;
	});

	let profileForm;
	function openform() {
		profileForm.animate([{ maxHeight: '0' }, { maxHeight: profileForm.scrollHeight + 'px' }], {
			duration: 500,
			easing: 'ease-in-out',
			fill: 'forwards'
		});
	}

	function closeForm() {
		profileForm.animate([{ maxHeight: profileForm.scrollHeight + 'px' }, { maxHeight: '0' }], {
			duration: 500,
			easing: 'ease-in-out',
			fill: 'forwards'
		});
	}

	function getBase64(file) {
		return new Promise((resolve, reject) => {
			const reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = () => resolve(reader.result);
			reader.onerror = (error) => reject(error);
		});
	}

	async function createProfilepicture(event) {
		if (event.target.files.length === 0) return;
		loader = true;
		profilePicture = true;
		getBase64(event.target.files[0]).then((data) => {
			pfpDOM.style.setProperty('background-image', "url('" + data + "'");
			domtoimage.toPng(pfpDOM).then((dataUrl) => {
				let a = document.createElement('a');
				a.href = dataUrl;
				a.download = event.target.files[0].name + '-demoprofilepicture.png';
				a.click();
				a.remove();
				closeForm();
				event.target.value = '';
				successMessage = true;
				profilePicture = false;
				setTimeout(() => {
					loader = false;
					successMessageDOM.scrollIntoView({ behavior: 'smooth' });
					setTimeout(() => {
						successMessageDOM.animate([{ opacity: 1 }, { opacity: 0 }], {
							duration: 500,
							easing: 'ease-in-out',
							fill: 'forwards'
						});
						setTimeout(() => {
							successMessage = false;
						}, 500);
					}, 2000);
				}, 1000);
			});
		});
	}
</script>

<Section classNames="cpt-container cpt-container--small">
	<div class="text-center">
		<h2 class="cpt-text-highlight text-3xl md:text-5xl text-center">
			{$_('somematerial.title')}
		</h2>
		<div class="mt-12">
			{#each $json('somematerial.content') as paragraph}
				<p>{@html paragraph}</p>
			{/each}
		</div>

		<Button onClick={openform} classes="!block mt-5"
			>{$_('somematerial.buttons.profilepicture')}</Button
		>
		<Button href="#" outline={true} classes="!block mt-1"
			>{$_('somematerial.buttons.downloadmedia')}</Button
		>
	</div>

	{#if showForm}
		<div class="cpt-profilepicture-form" bind:this={profileForm}>
			<div class="text-center pt-12 flex flex-col items-center">
				<p>{$_('somematerial.instructions')}</p>
				<label for="images" class="cpt-drop-container mt-4">
					<span class="cpt-drop-title">{$_('somematerial.filehere')}</span>
					{$_('somematerial.or')}
					<input
						type="file"
						id="images"
						accept="image/*"
						required
						on:change={createProfilepicture}
					/>
				</label>
			</div>
		</div>
	{/if}
	{#if profilePicture}
		<div class="pfp-inner-wrapper max-w-md mx-auto">
			<div class="cpt-pfp-wrapper aspect-square relative" bind:this={pfpDOM}>
				<div class="cpt-pfp-blind" />
				<!-- svelte-ignore a11y-missing-attribute -->
				<img
					src={`/images/profilepictures/skeleton-${$locale}.png`}
					class="absolute w-full h-full object-cover"
				/>
			</div>
		</div>
	{/if}
	{#if successMessage}
		<div
			class="text-center mt-4 flex flex-col items-center p-4 bg-secondary"
			bind:this={successMessageDOM}
		>
			<p>{$_('somematerial.success')}</p>
		</div>
	{/if}
</Section>
<div class="cpt-profilepics-demo mt-8 md:mt-12 flex overflow-x-hidden">
	{#each images as image}
		<img src={image} alt="Sample profile picture" loading="lazy" />
	{/each}
</div>

{#if loader}
	<div class="cpt-loader">
		<div class="lds-default">
			<div />
			<div />
			<div />
			<div />
			<div />
			<div />
			<div />
			<div />
			<div />
			<div />
			<div />
			<div />
		</div>
	</div>
{/if}

<style lang="scss">
	.cpt-profilepics-demo {
		--cols: 8;
		--gap: 0.5rem;
		--width: calc((100% - (var(--cols) - 1) * var(--gap)) / var(--cols));

		column-gap: var(--gap);

		@media (max-width: 1535px) {
			--cols: 6;
		}

		@media (max-width: 1023px) {
			--cols: 4;
		}

		@media (max-width: 767px) {
			--cols: 3;
		}

		img {
			width: var(--width);
			height: var(--width);
		}
	}

	.cpt-profilepicture-form {
		max-height: 0;
		overflow: hidden;

		.cpt-drop-container {
			position: relative;
			display: flex;
			gap: 10px;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			height: 200px;
			padding: 20px;
			border-radius: 10px;
			border: 2px dashed #555;
			color: #444;
			cursor: pointer;
			transition: background 0.2s ease-in-out, border 0.2s ease-in-out;
			width: 100%;

			.cpt-drop-title {
				color: #444;
				font-size: 20px;
				font-weight: bold;
				text-align: center;
				transition: color 0.2s ease-in-out;
			}

			&:hover {
				background: #eee;
				border-color: #111;

				.cpt-drop-title {
					color: #222;
				}
			}

			input[type='file'] {
				width: 350px;
				max-width: 100%;
				color: #444;
				padding: 5px;
				background: #fff;
				border-radius: 10px;
				border: 1px solid #555;

				&::file-selector-button {
					margin-right: 20px;
					border: none;
					background: theme('colors.accent');
					padding: 10px 20px;
					border-radius: 10px;
					color: #fff;
					cursor: pointer;
					transition: background 0.2s ease-in-out;

					&:hover {
						background: theme('colors.accent');
					}
				}
			}
		}
	}

	.cpt-loader {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		display: flex;
		justify-content: center;
		align-items: center;
		background-color: rgba(0, 0, 0, 0.5);
		backdrop-filter: blur(400px);
		z-index: 9999;
		color: white;
		font-size: 3rem;
		opacity: 1;
		transition: 0.5s ease opacity;

		.lds-default {
			display: inline-block;
			position: relative;
			width: 80px;
			height: 80px;
		}

		.lds-default div {
			position: absolute;
			width: 6px;
			height: 6px;
			background: #fff;
			border-radius: 50%;
			animation: lds-default 1.2s linear infinite;
		}

		.lds-default div:nth-child(1) {
			animation-delay: 0s;
			top: 37px;
			left: 66px;
		}

		.lds-default div:nth-child(2) {
			animation-delay: -0.1s;
			top: 22px;
			left: 62px;
		}

		.lds-default div:nth-child(3) {
			animation-delay: -0.2s;
			top: 11px;
			left: 52px;
		}

		.lds-default div:nth-child(4) {
			animation-delay: -0.3s;
			top: 7px;
			left: 37px;
		}

		.lds-default div:nth-child(5) {
			animation-delay: -0.4s;
			top: 11px;
			left: 22px;
		}

		.lds-default div:nth-child(6) {
			animation-delay: -0.5s;
			top: 22px;
			left: 11px;
		}

		.lds-default div:nth-child(7) {
			animation-delay: -0.6s;
			top: 37px;
			left: 7px;
		}

		.lds-default div:nth-child(8) {
			animation-delay: -0.7s;
			top: 52px;
			left: 11px;
		}

		.lds-default div:nth-child(9) {
			animation-delay: -0.8s;
			top: 62px;
			left: 22px;
		}

		.lds-default div:nth-child(10) {
			animation-delay: -0.9s;
			top: 66px;
			left: 37px;
		}

		.lds-default div:nth-child(11) {
			animation-delay: -1s;
			top: 62px;
			left: 52px;
		}

		.lds-default div:nth-child(12) {
			animation-delay: -1.1s;
			top: 52px;
			left: 62px;
		}

		@keyframes lds-default {
			0%,
			20%,
			80%,
			100% {
				transform: scale(1);
			}

			50% {
				transform: scale(1.5);
			}
		}
	}

	.cpt-pfp-wrapper {
		background-size: 110%;
		background-position: bottom right;
		background-repeat: no-repeat;
		position: fixed;
		top: 0;
		left: 0;
		width: 1080px;
		height: 1080px;

		.cpt-pfp-blind {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: theme('colors.secondary');
			mix-blend-mode: soft-light;
		}
	}
</style>

<script>
	import { onMount } from 'svelte';
	import { _, locale } from 'svelte-i18n';

	import Button from './Button.svelte';

	let background;
	let earth;
	let flames_bg;
	let flames_fg;
	let cta;
	let title1;
	let title2;
	let date;

	onMount(() => {
		startAni();
	});

	function startAni() {
		setTimeout(() => {
			background.animate([{ opacity: 0 }, { opacity: 1 }], {
				duration: 450,
				easing: 'ease-in-out',
				fill: 'forwards'
			});
			setTimeout(() => {
				earth.animate([{ opacity: 0 }, { opacity: 1 }], {
					duration: 450,
					easing: 'ease-in-out',
					fill: 'forwards'
				});
			}, 450);
			setTimeout(() => {
				flames_bg.animate(
					[
						{ transform: 'translateY(100%)', opacity: 0 },
						{ transform: 'translate(0)', opacity: 1 }
					],
					{
						duration: 500,
						easing: 'ease-in-out',
						fill: 'forwards'
					}
				);
			}, 500);
			setTimeout(() => {
				flames_fg.animate(
					[
						{ transform: 'translateY(100%)', opacity: 0 },
						{ transform: 'translate(0)', opacity: 1 }
					],
					{
						duration: 500,
						easing: 'ease-in-out',
						fill: 'forwards'
					}
				);
			}, 700);

			const texts = [cta, title1, title2, date];
			texts.forEach((text, i) => {
				setTimeout(() => {
					text.animate([{ opacity: 0 }, { opacity: 1 }], {
						duration: 250,
						easing: 'ease-in-out',
						fill: 'forwards'
					});
				}, 1200 + i * 250);
			});
		}, 750);
	}
</script>

<div class="cpt-heroine-wrapper">
	<div class="cpt-heroine cpt-container cpt-container--large">
		<div class="cpt-heroine-inner pt-8">
			<div class="cpt-heroine__visual">
				<div class="cpt-heroine__visual-inner cpt-heroine__visual-inner--{$locale}">
					<!-- svelte-ignore a11y-missing-attribute -->
					<img
						src="/images/visual/background.webp"
						role="presentation"
						class="cpt-heroine__visual-inner__background"
						bind:this={background}
					/>
					<!-- svelte-ignore a11y-missing-attribute -->
					<img
						src="/images/visual/flames_bg.webp"
						role="presentation"
						class="cpt-heroine__visual-inner__flames_bg"
						bind:this={flames_bg}
					/>
					<!-- svelte-ignore a11y-missing-attribute -->
					<img
						src="/images/visual/earth.webp"
						role="presentation"
						class="cpt-heroine__visual-inner__earth"
						bind:this={earth}
					/>
					<!-- svelte-ignore a11y-missing-attribute -->
					<img
						src="/images/visual/flames_fg.webp"
						role="presentation"
						class="cpt-heroine__visual-inner__flames_fg"
						bind:this={flames_fg}
					/>
					<div class="cpt-heroine__visual-inner__text">
						<span class="cpt-heroine__visual-inner__text--cta" bind:this={cta}
							>{@html $_('heroine.visual.cta')}</span
						>
						<span class="cpt-heroine__visual-inner__text--title1" bind:this={title1}
							>{@html $_('heroine.visual.title1')}</span
						>
						<span class="cpt-heroine__visual-inner__text--title2" bind:this={title2}
							>{@html $_('heroine.visual.title2')}</span
						>
						<span class="cpt-heroine__visual-inner__text--date" bind:this={date}
							>{@html $_('heroine.visual.date')}</span
						>
					</div>
				</div>
			</div>
			<div class="cpt-heroine__content flex items-center">
				<div class="cpt-heroine__content__inner">
					<h1 class="cpt-text-highlight text-4xl md:text-5xl">
						{$_('heroine.title')}
					</h1>
					<div class="mt-8">
						<p
							class="cpt-text-highlight cpt-text-highlight--white cpt-text-highlight--wide font-bold md:text-2xl"
						>
							{$_('heroine.content')}
						</p>
					</div>
					<div class="mt-8 flex flex-col lg:flex-row gap-x-4 gap-y-2">
						<Button href="#support">{$_('heroine.buttons.cta')}</Button>
						<Button color="outline" href="#more-info">{$_('heroine.buttons.more')}</Button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style lang="scss">
	.cpt-heroine-wrapper {
		background-image: linear-gradient(
				rgba(255, 255, 255, 0) 0%,
				rgba(255, 255, 255, 0) calc(100% - 6rem),
				rgba(255, 255, 255, 1) calc(100% - 6rem),
				rgba(255, 255, 255, 1) 100%
			),
			url('/images/visual/backdrop.webp');
		background-size: 100%;
		background-repeat: repeat;

		@media (max-width: 767px) {
			background-image: url('/images/visual/backdrop.webp');
		}

		.cpt-heroine {
			&-inner {
				display: flex;
				flex-wrap: wrap;
				justify-content: space-between;
				row-gap: 4rem;
			}

			&__visual {
				width: calc(50% - 2rem);
				@apply drop-shadow-xl;
				@media (max-width: 767px) {
					width: 100%;
				}
				&-inner {
					overflow: hidden;
					width: 100%;
					aspect-ratio: 3 / 4;
					position: relative;

					--minpad: 2rem;
					@media (max-width: 767px) {
						--minpad: 1rem;
					}
					--containerpadd: max(calc((100vw - 1440px) / 2), var(--minpad));
					--vw: calc((((100vw - 2 * var(--containerpadd)) - 4rem) / 2) / 100);

					@media (max-width: 767px) {
						--vw: calc(((100vw - 2 * var(--containerpadd))) / 100);
					}

					> * {
						position: absolute;
					}

					&__background {
						width: 100%;
						height: 100%;
						object-fit: cover;
						object-position: center;
						z-index: 0;
						opacity: 0;
					}

					&__earth,
					&__flames_bg,
					&__flames_fg {
						width: 60%;
						bottom: 0;
						right: 0;
						opacity: 0;
					}

					&__earth {
						z-index: 2;
					}

					&__flames_bg {
						z-index: 1;
					}

					&__flames_fg {
						z-index: 3;
					}

					.cpt-heroine__visual-inner__text {
						position: initial;

						span {
							display: block;
							font-weight: bold;
							text-transform: uppercase;
							line-height: 1;
							position: absolute;
							transform-origin: top right;
							opacity: 0;
						}

						&--cta {
							font-size: calc(7 * var(--vw));
							text-align: end;
							color: white;
							top: 2.5%;
							right: calc(var(--vw) * 14);
							z-index: 0;
							transform: rotate(-15deg);
						}

						&--title1 {
							font-size: calc(24 * var(--vw));
							text-align: end;
							letter-spacing: 0.02em;
							color: black;
							top: 13.5%;
							line-height: 0.8 !important;
							right: calc(var(--vw) * 11);
							z-index: 0;
							transform: rotate(-15deg);
						}

						&--title2 {
							font-size: calc(24 * var(--vw));
							letter-spacing: 0.02em;
							color: white;
							top: 48%;
							line-height: 0.8 !important;
							left: calc(var(--vw) * 2);
							z-index: 3;
							transform: rotate(-15deg);
						}

						&--date {
							font-size: calc(7 * var(--vw));
							color: black;
							top: 81.5%;
							left: calc(var(--vw) * 14);
							z-index: 3;
							transform: rotate(-15deg);
						}
					}

					&--fr {
						.cpt-heroine__visual-inner__text {
							&--title2 {
								top: 45%;
							}
						}
					}
				}
			}

			&__content {
				width: calc(50% - 2rem);
				@media (max-width: 767px) {
					width: 100%;
				}

				&__inner {
					padding-bottom: 8rem;

					@media (max-width: 767px) {
						padding-bottom: 2rem;
					}
				}
			}
		}
	}
</style>

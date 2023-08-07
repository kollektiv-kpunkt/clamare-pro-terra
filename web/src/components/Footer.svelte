<script>
	import { _, locale, json } from 'svelte-i18n';
	import Section from './Section.svelte';
	import FormField from './FormField.svelte';
	import { createLoader, removeLoader } from './formLoaders.js';
	import { Notyf } from 'notyf';
	import 'notyf/notyf.min.css';
	import { onMount } from 'svelte';

	let notyf;

	onMount(() => {
		notyf = new Notyf();
	});

	let langs = {
		de: {
			title: 'fr',
			href: 'https://manif-climat.ch'
		},
		fr: {
			title: 'de',
			href: 'https://klima-demo.ch'
		},
		it: {
			title: 'it',
			href: 'https://manifestazione-clima.ch/'
		}
	};

	let lang = langs[$locale];

	async function formSubmit() {
		let loader = createLoader();
		let e = window.event;
		let form = e.target;
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
				notyf.success($_('footer.newsletter.success'));
				form.reset();
			} else {
				notyf.error($_('footer.newsletter.error'));
			}
		}, 300);
	}
</script>

<footer>
	<Section classNames="cpt-container cpt-container-full pt-12 md:pt-20 pb-6">
		<div
			class="cpt-footer-newsletter cpt-container cpt-container--small bg-secondary drop-shadow-2xl !p-8 !md:p-12"
		>
			<div class="text-center">
				<h2 class="cpt-text-highlight text-3xl md:text-5xl">{$_('footer.newsletter.title')}</h2>
				<p class="mt-4 md:text-xl">{$_('footer.newsletter.content')}</p>
				<form
					action="https://n8n.victorinus.ch/webhook/f6baa0fa-fb37-4f06-9430-01f51423c2d3"
					method="POST"
					class="mt-4"
					on:submit|preventDefault={formSubmit}
				>
					<FormField
						name="email"
						type="email"
						label=""
						placeholder={$_('footer.newsletter.email')}
						className="cpt-form-group--accent"
						required={true}
					/>
					<input type="hidden" name="locale" value={$locale} />
					<button><i class="icofont-paper-plane" /></button>
				</form>
			</div>
		</div>
		<div
			class="cpt-footer-bottombar cpt-container cpt-container--large !px-0 grid grid-cols-2 mt-6 md:mt-8 text-white"
		>
			<div class="cpt-footer-bottombar__left">
				<img src="/images/logo-{$locale}.png" alt="" class="h-20" />
			</div>
			<div class="cpt-footer-bottombar__right mt-auto uppercase tracking-wide">
				<div
					class="flex justify-end items-end text-end flex-col md:flex-row gap-x-4 gap-y-2 underline"
				>
					{#each $json('footer.links') as link}
						<a href={link.href} class="cpt-footer-link" target="_blank">{link.title}</a>
					{/each}
					{#each langs as lang}
						<a href={lang.href} class="cpt-footer-link">{lang.title}</a>
					{/each}
				</div>
			</div>
		</div>
	</Section>
</footer>

<style lang="scss">
	footer {
		background-image: linear-gradient(
			to bottom,
			white 0%,
			white calc(0% + 20rem),
			theme('colors.foreground') calc(0% + 5rem),
			theme('colors.foreground') 100%
		);
		.cpt-footer-newsletter {
			form {
				position: relative;

				button {
					position: absolute;
					display: flex;
					top: 0;
					right: 0;
					height: 100%;
					justify-content: center;
					align-items: center;
					font-size: 1.25rem;
					padding-right: 0.5rem;
				}
			}
		}
	}
</style>

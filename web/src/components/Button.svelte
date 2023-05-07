<script>
	export const tag = 'a';
	export let href = '#';
	export let color = 'accent';
	export let size = 'md';
	export let outline = false;
	export let block = false;
	export let type = 'button';
	export let classes = '';
	export let onClick = false;

	let className = 'cpt-button';
	className += ` cpt-button--${color}`;
	className += ` cpt-button--${size}`;
	className += ` cpt-button--${outline ? 'outline' : 'solid'}`;
	className += ` cpt-button--${block ? 'block' : 'inline'}`;
	className += ` ${classes}`;
</script>

{#if onClick}
	{#if tag === 'a'}
		<a {href} class={className} on:click|preventDefault={onClick}>
			<slot />
		</a>
	{:else if tag === 'button'}
		<button {type} class={className} on:click|preventDefault={onClick}>
			<slot />
		</button>
	{/if}
{:else if tag === 'a'}
	<a {href} class={className}>
		<slot />
	</a>
{:else if tag === 'button'}
	<button {type} class={className}>
		<slot />
	</button>
{/if}

<style lang="scss">
	.cpt-button {
		padding: 0.5em 1em 0.4em;
		display: inline-flex;
		justify-content: center;
		line-height: 1;
		background-color: theme('colors.accent');
		color: theme('colors.white');
		font-weight: bold;
		text-transform: uppercase;
		letter-spacing: 0.02;
		font-size: 1.25rem;

		@media (max-width: 767px) {
			font-size: 1rem;
		}

		&--white {
			background-color: theme('colors.white');
			color: theme('colors.accent');
		}

		&--outline {
			background-color: theme('colors.white');
			border: 2px solid theme('colors.accent');
			color: theme('colors.accent');

			&:hover {
				background-color: theme('colors.accent');
				color: theme('colors.white');
			}
		}
	}
</style>

<script>
	export let name;
	export let type = 'text';
	export let label;
	export let required = false;
	export let checked = false;

	export let id = name + '-' + crypto.randomUUID();

	let textarea;

	function setHeight() {
		textarea.style.height = 'auto';
		textarea.style.height = textarea.scrollHeight + 'px';
	}
</script>

<div class="cpt-form-group cpt-form-group--{type}">
	{#if type == 'checkbox'}
		<input type="checkbox" {name} {id} {checked} />
	{/if}
	<label for={id}>{@html label}</label>
	{#if type == 'textarea'}
		<textarea {name} {id} on:input={setHeight} bind:this={textarea} {required} />
	{:else if type != 'checkbox'}
		<input {type} {name} {id} {required} />
	{/if}
</div>

<style lang="scss">
	.cpt-form-group {
		display: grid;
		row-gap: 0.25rem;
		margin-top: 1.75rem;

		input[type='text'],
		input[type='email'],
		input[type='number'],
		textarea {
			background-color: theme('colors.gray.50');
			border-bottom: 2px solid theme('colors.secondary');
			padding: 0.25rem 0.125rem;
		}

		textarea {
			min-height: 250px;
		}

		&:first-child {
			margin-top: 0;
		}

		&:not(.cpt-form-group--checkbox) {
			label {
				font-size: 1.25rem;
				text-transform: uppercase;
				letter-spacing: 0.02em;
			}
		}

		&--checkbox {
			display: flex;
			gap: 0.5rem;
			align-items: flex-start;

			label {
				cursor: pointer;
				@apply text-sm text-accent;

				&::before {
					content: '';
					font-family: 'IcoFont';
					margin-right: 0.25rem;
					border: 0.15em solid theme('colors.accent');
					width: 0.75em;
					height: 0.75em;
					display: inline-block;
				}
			}

			input {
				display: none;

				&:checked + label {
					&::before {
						margin-right: 0.075em;
						content: '\eed9';
						width: auto;
						height: auto;
						border: none;
					}
				}
			}
		}
	}

	:global(.cpt-form-group--checkbox a) {
		text-decoration: underline !important;
	}
</style>

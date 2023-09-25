<script>
	export let question = {
		question: 'What is the meaning of life?',
		answer: '42'
	};

	let isOpen = false;
	let answerDOM;
	let answerInner;
	let questionIcon;

	function toggleAnswer() {
		isOpen = !isOpen;
		if (isOpen) {
			answerInner.style.opacity = 0;
			answerDOM.animate([{ maxHeight: 0 }, { maxHeight: answerDOM.scrollHeight + 'px' }], {
				duration: 300,
				easing: 'ease-in-out',
				fill: 'forwards'
			});
			questionIcon.animate([{ transform: 'rotate(0deg)' }, { transform: 'rotate(180deg)' }], {
				duration: 300,
				easing: 'ease-in-out',
				fill: 'forwards'
			});
			setTimeout(() => {
				answerInner.animate(
					[
						{ opacity: 0, transform: 'translateY(20px)' },
						{ opacity: 1, transform: 'translateY(0)' }
					],
					{
						duration: 300,
						easing: 'ease-in-out',
						fill: 'forwards'
					}
				);
			}, 350);
		} else {
			answerDOM.animate([{ maxHeight: answerDOM.scrollHeight + 'px' }, { maxHeight: 0 }], {
				duration: 300,
				easing: 'ease-in-out',
				fill: 'forwards'
			});
			questionIcon.animate([{ transform: 'rotate(180deg)' }, { transform: 'rotate(0deg)' }], {
				duration: 300,
				easing: 'ease-in-out',
				fill: 'forwards'
			});
			answerInner.animate(
				[
					{ opacity: 1, transform: 'translateY(0)' },
					{ opacity: 0, transform: 'translateY(20px)' }
				],
				{
					duration: 300,
					easing: 'ease-in-out',
					fill: 'forwards'
				}
			);
		}
	}
</script>

<div class="cpt-question-wrapper">
	<div class="cpt-question-block py-8 border-b-2 border-b-white">
		<span
			class="cpt-question-title flex justify-between text-lg items-center cursor-pointer"
			on:click={toggleAnswer}
		>
			<p class="pr-8 font-bold">{question.question}</p>
			<i class="icofont-rounded-down" bind:this={questionIcon} />
		</span>
		<div class="cpt-question-answer max-h-0 overflow-hidden" bind:this={answerDOM}>
			<div class="cpt-question-answer-inner pt-4" bind:this={answerInner}>
				{#if typeof question.answer === 'object'}
					<ul>
						{#each question.answer as answer}
							<li>{answer}</li>
						{/each}
					</ul>
				{:else}
					<p>{question.answer}</p>
				{/if}
			</div>
		</div>
	</div>
</div>

<style lang="scss">
	ul {
		list-style: disc;
		margin-left: 1rem;

		li + li {
			margin-top: 0.5rem;
		}
	}
</style>

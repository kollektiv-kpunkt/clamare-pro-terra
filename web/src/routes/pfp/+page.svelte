<script>
	import { page } from '$app/stores';
</script>

<div
	class="cpt-pfp-wrapper"
	style="background-image: url('/images/profilepictures/{$page.url.searchParams.get('img')}')"
>
	<div class="cpt-pfp-blind" />
	<img src="/images/profilepictures/skeleton.png" alt="" />
</div>

<style lang="scss">
	.cpt-pfp-wrapper {
		position: absolute;
		top: 0;
		left: 0;
		width: 1080px;
		height: 1080px;
		background-size: cover;

		img {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			object-fit: cover;
		}

		.cpt-pfp-blind {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: theme('colors.secondary');
			mix-blend-mode: soft-light;
		}
	}
</style>

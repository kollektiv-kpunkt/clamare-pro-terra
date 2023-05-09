<script>
	import { _ } from 'svelte-i18n';
</script>

<svelte:head>
	<link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png" />
	<link rel="manifest" href="/images/favicon/site.webmanifest" />
	<link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#5bbad5" />
	<link rel="shortcut icon" href="/images/favicon/favicon.ico" />
	<meta name="msapplication-TileColor" content="#da532c" />
	<meta name="msapplication-config" content="/images/favicon/browserconfig.xml" />
	<meta name="theme-color" content="#ffffff" />

	<!-- Primary Meta Tags -->
	<title>{$_('og.title')}</title>
	<meta name="title" content={$_('og.title')} />
	<meta name="description" content={$_('og.description')} />

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://klima-demo.ch/" />
	<meta property="og:title" content={$_('og.title')} />
	<meta property="og:description" content={$_('og.description')} />
	<meta property="og:image" content="" />

	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image" />
	<meta property="twitter:url" content="https://klima-demo.ch/" />
	<meta property="twitter:title" content={$_('og.title')} />
	<meta property="twitter:description" content={$_('og.description')} />
	<meta property="twitter:image" content="" />
</svelte:head>

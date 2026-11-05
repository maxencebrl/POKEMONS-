<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title') - Mon Pokédex</title>
	<style>
		:root {
			--bg: #071426;
			--text: #f1f5f9;
			--muted: #94a3b8;
			--accent: #facc15;
		}

		* { box-sizing: border-box; margin: 0; padding: 0; }

		body {
			font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
			background-color: var(--bg);
			background-image:
				linear-gradient(rgba(5, 14, 31, .58), rgba(5, 14, 31, .72)),
				url('/images/pokemon-background.svg');
			background-position: center center;
			background-size: cover;
			background-attachment: fixed;
			color: var(--text);
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 24px 16px;
		}

		.auth { width: 100%; max-width: 420px; }

		.brand { text-align: center; margin-bottom: 22px; }
		.brand h1 {
			font-size: clamp(2.2rem, 7vw, 3rem);
			font-weight: 800;
			line-height: 1.05;
			letter-spacing: -.5px;
			background: linear-gradient(180deg, #ffffff 0%, #fde68a 42%, #fbbf24 100%);
			-webkit-background-clip: text;
			background-clip: text;
			color: transparent;
			filter: drop-shadow(0 6px 24px rgba(251, 191, 36, .35));
		}
		.brand p { margin-top: 8px; color: var(--muted); font-size: .85rem; letter-spacing: 2px; text-transform: uppercase; }

		.card {
			padding: 26px 24px;
			background: rgba(255, 255, 255, .06);
			border: 1px solid rgba(255, 255, 255, .12);
			border-radius: 20px;
			backdrop-filter: blur(14px);
			-webkit-backdrop-filter: blur(14px);
			box-shadow: 0 20px 60px rgba(0, 0, 0, .45), inset 0 1px 0 rgba(255, 255, 255, .06);
		}
		.card h2 { font-size: 1.25rem; margin-bottom: 18px; }

		.field { margin-bottom: 14px; }
		.field label { display: block; margin-bottom: 6px; font-size: .78rem; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: var(--muted); }
		.field input[type="text"],
		.field input[type="email"],
		.field input[type="password"] {
			width: 100%;
			padding: 12px 14px;
			font: inherit;
			color: var(--text);
			background: rgba(2, 8, 20, .55);
			border: 1px solid rgba(255, 255, 255, .14);
			border-radius: 12px;
			outline: none;
			transition: border-color .2s, box-shadow .2s;
		}
		.field input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(250, 204, 21, .18); }
		.error { margin-top: 6px; color: #fca5a5; font-size: .85rem; }

		.remember { display: flex; align-items: center; gap: 8px; margin: 4px 0 18px; font-size: .9rem; color: var(--muted); }
		.remember input { accent-color: var(--accent); }

		button.submit {
			width: 100%;
			padding: 13px;
			border: none;
			border-radius: 999px;
			font: inherit;
			font-weight: 800;
			letter-spacing: .3px;
			color: #422006;
			background: linear-gradient(135deg, #fde047, #f59e0b);
			box-shadow: 0 8px 22px rgba(245, 158, 11, .3);
			cursor: pointer;
			transition: transform .15s;
		}
		button.submit:hover { transform: translateY(-2px); }

		.switch { margin-top: 18px; text-align: center; font-size: .9rem; color: var(--muted); }
		.switch a { color: var(--accent); font-weight: 700; text-decoration: none; }
		.switch a:hover { text-decoration: underline; }
	</style>
</head>
<body>
	<main class="auth">
		<div class="brand">
			<h1>Mon Pokédex</h1>
			<p>@yield('subtitle')</p>
		</div>

		<div class="card">
			@yield('content')
		</div>
	</main>
</body>
</html>

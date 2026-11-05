<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pokemons</title>
	<style>
		:root {
			--bg: #0f172a;
			--card: #1e293b;
			--text: #f1f5f9;
			--muted: #94a3b8;
			--accent: #facc15;
			--female: #f472b6;
			--male: #60a5fa;
		}

		* { box-sizing: border-box; margin: 0; padding: 0; }

		body {
			font-family: 'Segoe UI', system-ui, sans-serif;
			background: radial-gradient(circle at top, #1e293b, var(--bg));
			color: var(--text);
			min-height: 100vh;
			padding: 40px 20px;
		}

		h1 {
			text-align: center;
			font-size: 2.4rem;
			margin-bottom: 8px;
			color: var(--accent);
			letter-spacing: 2px;
		}

		.subtitle {
			text-align: center;
			color: var(--muted);
			margin-bottom: 40px;
		}

		.grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
			gap: 24px;
			max-width: 1200px;
			margin: 0 auto;
		}

		.card {
			position: relative;
			background: var(--card);
			border-radius: 20px;
			overflow: hidden;
			box-shadow: 0 10px 25px rgba(0, 0, 0, .35);
			transition: transform .25s, box-shadow .25s;
		}

		.card:hover {
			transform: translateY(-8px);
			box-shadow: 0 16px 35px rgba(0, 0, 0, .5);
		}

		.card.shiny {
			border: 2px solid var(--accent);
			box-shadow: 0 0 20px rgba(250, 204, 21, .35);
		}

		.card-image {
	        height: 220px;
	        background: linear-gradient(135deg, #334155, #1e293b);
	        overflow: hidden;
	        padding: 7px;
        }

        .card-image img {
	        width: 100%;
	        height: 100%;
	        object-fit: contain;
	        display: block;
	        border-radius: 12px;
        }

		.level {
			position: absolute;
			top: 12px;
			left: 12px;
			background: rgba(0, 0, 0, .7);
			padding: 4px 12px;
			border-radius: 999px;
			font-size: .85rem;
			font-weight: 600;
		}

		.shiny-badge {
			position: absolute;
			top: 12px;
			right: 12px;
			background: var(--accent);
			color: #422006;
			padding: 4px 12px;
			border-radius: 999px;
			font-size: .8rem;
			font-weight: 700;
		}

		.card-body { padding: 18px; }

		.card-title {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 14px;
		}

		.card-title h2 { font-size: 1.4rem; }

		.genre { font-size: 1.5rem; font-weight: bold; }
		.genre.female { color: var(--female); }
		.genre.male { color: var(--male); }

		.life-label {
			display: flex;
			justify-content: space-between;
			font-size: .8rem;
			color: var(--muted);
			margin-bottom: 4px;
		}

		.life-bar {
			height: 8px;
			background: #334155;
			border-radius: 999px;
			overflow: hidden;
			margin-bottom: 16px;
		}

		.life-bar div {
			height: 100%;
			background: linear-gradient(90deg, #22c55e, #84cc16);
			border-radius: 999px;
		}

		.stats {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 10px;
			margin-bottom: 14px;
		}

		.stat {
			background: #0f172a;
			border-radius: 12px;
			padding: 8px 12px;
			text-align: center;
		}

		.stat span {
			display: block;
			font-size: .7rem;
			color: var(--muted);
			text-transform: uppercase;
			letter-spacing: 1px;
		}

		.stat strong { font-size: 1.05rem; }

		.captured {
			font-size: .8rem;
			color: var(--muted);
			text-align: center;
		}

		.empty {
			text-align: center;
			color: var(--muted);
			grid-column: 1 / -1;
		}
	</style>
</head>
<body>

	<h1>Mon Pokédex</h1>
	<p class="subtitle">{{ count($pokemons) }} Pokémon capturé(s)</p>

	<div class="grid">
		@forelse($pokemons as $pokemon)

			<div class="card {{ $pokemon->is_shiny ? 'shiny' : '' }}">

				<div class="card-image">
					<img src="{{ $pokemon->image }}" alt="Image {{ $pokemon->name }}">
				</div>

				<span class="level">Niv. {{ $pokemon->level }}</span>

				@if($pokemon->is_shiny)
					<span class="shiny-badge">✨ Shiny</span>
				@endif

				<div class="card-body">
					<div class="card-title">
						<h2>{{ $pokemon->name }}</h2>
						<span class="genre {{ $pokemon->genre ? 'female' : 'male' }}">
							{{ $pokemon->genre ? '♀' : '♂' }}
						</span>
					</div>

					<div class="life-label">
						<span>Vie</span>
						<span>{{ $pokemon->life }} PV</span>
					</div>
					<div class="life-bar">
						<div style="width: {{ min(100, max(0, $pokemon->life)) }}%"></div>
					</div>

					<div class="stats">
						<div class="stat">
							<span>Taille</span>
							<strong>{{ $pokemon->height }} m</strong>
						</div>
						<div class="stat">
							<span>Poids</span>
							<strong>{{ $pokemon->weight }} kg</strong>
						</div>
					</div>

					<p class="captured">
						Capturé le {{ \Carbon\Carbon::parse($pokemon->captured_at)->format('d/m/Y') }}
						· #{{ $pokemon->id }}
					</p>
				</div>
			</div>

		@empty
			<p class="empty">Aucun Pokémon pour le moment.</p>
		@endforelse
	</div>

</body>
</html>
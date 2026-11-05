<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Pokédex - Livre</title>
	<style>
		:root {
			--w: 540px;   /* largeur d'une page (doit correspondre à PAGE_W dans le JS) */
			--h: 700px;   /* hauteur d'une page */
			--bg: #071426;
			--page: #172b49;
			--page-dark: #102039;
			--text: #f1f5f9;
			--muted: #94a3b8;
			--accent: #facc15;
			--female: #f472b6;
			--male: #60a5fa;
		}

		* { box-sizing: border-box; margin: 0; padding: 0; }

		body {
			font-family: 'Segoe UI', system-ui, sans-serif;
			background-color: var(--bg);
			background-image:
				linear-gradient(rgba(5, 14, 31, .58), rgba(5, 14, 31, .72)),
				url('/images/pokemon-background.svg');
			background-position: center center;
			background-size: cover;
			background-attachment: fixed;
			color: var(--text);
			min-height: 100vh;
			padding: 18px 20px 20px;
			overflow-x: hidden;
			display: flex;
			flex-direction: column;
		}
		body::before {
			content: '';
			position: fixed;
			inset: 0;
			pointer-events: none;
			background: radial-gradient(circle at center, transparent 25%, rgba(2, 8, 20, .25) 100%);
			z-index: -1;
		}

		h1 {
			text-align: center;
			font-size: 2.2rem;
			color: var(--accent);
			letter-spacing: 2px;
			margin-bottom: 6px;
		}

		.subtitle {
			text-align: center;
			color: var(--muted);
			margin-bottom: 30px;
		}

		/* ---------- Livre ---------- */
		.stage {
			display: flex;
			flex: 1 1 auto;
			min-height: 0;
			justify-content: center;
			align-items: center;
			width: 100%;
			margin: 8px 0;
		}

		.scaler {
			flex: none;
			width: calc(var(--w) * 2);
			height: var(--h);
			transform-origin: center center;
		}

		.book {
			position: relative;
			width: var(--w);
			height: var(--h);
			margin-left: calc(var(--w) / 2);   /* place la reliure au centre du scaler */
			perspective: 2200px;
			perspective-origin: 0 50%;
			transition: transform .8s ease;
		}

		.leaf {
			position: absolute;
			inset: 0;
			transform-origin: left center;
			transform-style: preserve-3d;
			transition: transform .8s cubic-bezier(.645, .045, .355, 1);
		}

		.leaf.flipped { transform: rotateY(-180deg); }

		.face {
			position: absolute;
			inset: 0;
			backface-visibility: hidden;
			-webkit-backface-visibility: hidden;
		}

		.back { transform: rotateY(180deg); }

		.page {
			display: flex;
			flex-direction: column;
			padding: 22px 20px 12px;
			background: var(--page);
			cursor: pointer;
			box-shadow: 0 10px 30px rgba(0, 0, 0, .45);
		}

		.page.right {
			border-radius: 0 14px 14px 0;
			border: 1px solid #334155;
			border-left: none;
		}

		.page.left {
			border-radius: 14px 0 0 14px;
			border: 1px solid #334155;
			border-right: none;
		}

		/* ombre de la reliure */
		.page.right::before,
		.page.left::before {
			content: '';
			position: absolute;
			top: 0;
			bottom: 0;
			width: 40px;
			pointer-events: none;
		}
		.page.right::before {
			left: 0;
			background: linear-gradient(to right, rgba(0, 0, 0, .45), transparent);
			border-radius: 0;
		}
		.page.left::before {
			right: 0;
			background: linear-gradient(to left, rgba(0, 0, 0, .45), transparent);
		}

		/* ---------- Couverture du Pokédex ---------- */
		.cover-page {
			align-items: center;
			justify-content: center;
			text-align: center;
			padding: 30px;
			background:
				radial-gradient(circle at 50% 36%, rgba(250,204,21,.2), transparent 32%),
				linear-gradient(145deg, #173c70, #101b32 72%);
			border: 2px solid #facc15 !important;
			color: #fff;
		}
		.cover-page::after {
			content: '';
			position: absolute;
			inset: 12px;
			border: 1px solid rgba(250,204,21,.55);
			border-radius: 8px;
			pointer-events: none;
		}
		.cover-logo {
			width: 142px;
			height: 142px;
			border-radius: 50%;
			margin-bottom: 28px;
			border: 8px solid #f8fafc;
			background: linear-gradient(#ef4444 0 48%, #f8fafc 48% 52%, #1e293b 52%);
			box-shadow: 0 0 0 7px #facc15, 0 12px 35px rgba(0,0,0,.4);
			position: relative;
		}
		.cover-logo::before {
			content: '';
			position: absolute;
			width: 38px;
			height: 38px;
			border-radius: 50%;
			background: #f8fafc;
			border: 7px solid #1e293b;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
		}
		.cover-page h2 {
			font-size: 2.5rem;
			line-height: 1.05;
			color: #facc15;
			letter-spacing: 2px;
			text-shadow: 0 3px 0 #854d0e;
			margin-bottom: 14px;
		}
		.cover-page p {
			color: #dbeafe;
			line-height: 1.6;
			margin-bottom: 28px;
		}
		.cover-hint {
			font-size: .8rem;
			letter-spacing: 2px;
			text-transform: uppercase;
			color: #facc15 !important;
			margin-bottom: 0 !important;
		}
		.inside-cover {
			align-items: center;
			justify-content: center;
			text-align: center;
			background: linear-gradient(145deg, #102039, #172b49);
			color: #cbd5e1;
		}
		.inside-cover .inside-symbol { font-size: 4rem; margin-bottom: 18px; }
		.inside-cover h2 { color: #facc15; margin-bottom: 12px; }

		.page-grid {
			flex: 1;
			min-height: 0;
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			grid-template-rows: repeat(3, 1fr);
			gap: 10px;
		}

		.page-number {
			text-align: center;
			color: var(--muted);
			font-size: .8rem;
			padding-top: 8px;
		}

		/* ---------- Mini cartes ---------- */
		.mini {
			position: relative;
			display: flex;
			flex-direction: column;
			background: var(--page-dark);
			border-radius: 12px;
			overflow: hidden;
			border: 1px solid #334155;
			min-height: 0;
		}

		.mini.shiny {
			border-color: var(--accent);
			box-shadow: 0 0 12px rgba(250, 204, 21, .35);
		}

		.mini-img {
			flex: 1;
			min-height: 0;
			background: #0b1220;
		}

		.mini-img img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			object-position: center top;
			display: block;
		}

		.mini-level {
			position: absolute;
			top: 6px;
			left: 6px;
			background: rgba(0, 0, 0, .7);
			padding: 2px 8px;
			border-radius: 999px;
			font-size: .68rem;
			font-weight: 600;
		}

		.mini-shiny {
			position: absolute;
			top: 6px;
			right: 6px;
			background: var(--accent);
			color: #422006;
			padding: 1px 6px;
			border-radius: 999px;
			font-size: .7rem;
			font-weight: 700;
		}

		.mini-body { padding: 7px 9px 8px; }

		.mini-title {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 5px;
		}

		.mini-title h3 {
			font-size: .92rem;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		.genre { font-weight: bold; font-size: 1rem; }
		.genre.female { color: var(--female); }
		.genre.male { color: var(--male); }

		.life-bar {
			height: 5px;
			background: #334155;
			border-radius: 999px;
			overflow: hidden;
			margin-bottom: 5px;
		}

		.life-bar div {
			height: 100%;
			background: linear-gradient(90deg, #22c55e, #84cc16);
			border-radius: 999px;
		}

		.mini-stats {
			display: flex;
			justify-content: space-between;
			font-size: .66rem;
			color: var(--muted);
		}

		/* ---------- Contrôles ---------- */
		.controls {
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 20px;
			margin-top: 8px;
			flex: 0 0 auto;
		}

		.controls button {
			background: var(--accent);
			color: #422006;
			border: none;
			padding: 10px 22px;
			border-radius: 999px;
			font-size: 1rem;
			font-weight: 700;
			cursor: pointer;
			transition: transform .15s, opacity .15s;
		}

		.controls button:hover:not(:disabled) { transform: scale(1.06); }
		.controls button:disabled { opacity: .3; cursor: default; }

		#indicator {
			color: var(--muted);
			min-width: 130px;
			text-align: center;
		}


        /* ---------- Agrandissement des cartes Pokémon ---------- */
        .pokemon-modal {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(2, 8, 20, .82);
            backdrop-filter: blur(6px);
        }
        .pokemon-modal.open { display: flex; animation: modalFade .2s ease-out; }
        .pokemon-modal-card {
            position: relative;
            width: min(360px, 92vw);
            max-height: 90vh;
            overflow-y: auto;
            padding: 18px;
            border: 2px solid var(--accent);
            border-radius: 20px;
            background: linear-gradient(145deg, #1e3a5f, #0b1628);
            box-shadow: 0 20px 70px rgba(0,0,0,.65), 0 0 25px rgba(250,204,21,.2);
            animation: cardPop .22s ease-out;
        }
        .pokemon-modal-card img {
            display: block;
            width: 100%;
            height: 300px;
            object-fit: contain;
            border-radius: 12px;
            background: rgba(2,8,20,.55);
            margin: 10px 0 14px;
        }
        .pokemon-modal-card h2 { color: var(--accent); font-size: 1.7rem; margin: 0 42px 6px 0; }
        .pokemon-modal-card .modal-level { color: #cbd5e1; }
        .pokemon-modal-card .modal-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-top: 14px; }
        .pokemon-modal-card .modal-stat { padding: 10px 6px; border-radius: 10px; text-align: center; background: rgba(255,255,255,.08); color: #e2e8f0; }
        .pokemon-modal-card .modal-stat strong { display: block; color: var(--accent); font-size: 1.05rem; }
        .pokemon-modal-close {
            position: absolute; top: 12px; right: 12px; width: 38px; height: 38px;
            border: 0; border-radius: 50%; background: var(--accent); color: #422006;
            font-size: 1.35rem; font-weight: bold; cursor: pointer;
        }
        .mini { cursor: zoom-in; transition: transform .18s ease, box-shadow .18s ease; }
        .mini:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,0,0,.35); }
        @keyframes modalFade { from { opacity: 0; } to { opacity: 1; } }
        @keyframes cardPop { from { transform: scale(.88); opacity: .5; } to { transform: scale(1); opacity: 1; } }

		/* ---------- Sélecteur de mode ---------- */
		[hidden] { display: none !important; }

		/* Look moderne global */
		body { font-family: 'Inter', 'Segoe UI', system-ui, sans-serif; }
		h1 {
			font-size: clamp(2.2rem, 5vw, 3.2rem);
			font-weight: 800;
			line-height: 1.05;
			letter-spacing: -.5px;
			margin-bottom: 14px;
			background: linear-gradient(180deg, #ffffff 0%, #fde68a 42%, #fbbf24 100%);
			-webkit-background-clip: text;
			background-clip: text;
			color: transparent;
			filter: drop-shadow(0 6px 24px rgba(251, 191, 36, .35));
		}
		.subtitle {
			display: flex;
			align-items: center;
			gap: 10px;
			width: max-content;
			max-width: 100%;
			margin: 0 auto 22px;
			padding: 7px 16px;
			font-size: .72rem;
			font-weight: 600;
			letter-spacing: 2.5px;
			text-transform: uppercase;
			color: #cbd5e1;
			background: rgba(255, 255, 255, .05);
			border: 1px solid rgba(255, 255, 255, .1);
			border-radius: 999px;
			backdrop-filter: blur(10px);
			-webkit-backdrop-filter: blur(10px);
		}
		.subtitle::before {
			content: '';
			width: 7px;
			height: 7px;
			border-radius: 50%;
			background: #4ade80;
			animation: livePulse 2s ease-out infinite;
		}
		@keyframes livePulse {
			0% { box-shadow: 0 0 0 0 rgba(74, 222, 128, .6); }
			100% { box-shadow: 0 0 0 9px rgba(74, 222, 128, 0); }
		}
		.controls button {
			background: linear-gradient(135deg, #fde047, #f59e0b);
			box-shadow: 0 8px 22px rgba(245, 158, 11, .3);
			letter-spacing: .3px;
		}
		.controls button:hover:not(:disabled) { transform: translateY(-2px) scale(1.03); }
		.controls button.ghost {
			background: rgba(255, 255, 255, .08);
			color: var(--text);
			border: 1px solid rgba(255, 255, 255, .18);
			box-shadow: none;
			backdrop-filter: blur(8px);
		}

		.mode-switch {
			position: relative;
			display: grid;
			grid-template-columns: 1fr 1fr;
			margin: 0 auto 22px;
			padding: 4px;
			width: max-content;
			max-width: 100%;
			background: rgba(255, 255, 255, .05);
			border: 1px solid rgba(255, 255, 255, .1);
			border-radius: 999px;
			backdrop-filter: blur(14px);
			-webkit-backdrop-filter: blur(14px);
			box-shadow: 0 10px 30px rgba(0, 0, 0, .35), inset 0 1px 0 rgba(255, 255, 255, .06);
		}
		/* pastille qui glisse d'un mode à l'autre */
		.mode-switch::before {
			content: '';
			position: absolute;
			top: 4px;
			bottom: 4px;
			left: 4px;
			width: calc(50% - 4px);
			border-radius: 999px;
			background: linear-gradient(135deg, #fde047, #f59e0b);
			box-shadow: 0 6px 20px rgba(245, 158, 11, .45);
			transition: transform .4s cubic-bezier(.65, .05, .36, 1);
		}
		.mode-switch:has(button[data-mode="booster"].active)::before { transform: translateX(100%); }
		.mode-switch button {
			position: relative;
			z-index: 1;
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			min-width: 150px;
			border: none;
			background: transparent;
			color: var(--muted);
			padding: 10px 22px;
			border-radius: 999px;
			font-family: inherit;
			font-size: .9rem;
			font-weight: 700;
			cursor: pointer;
			transition: color .3s;
		}
		.mode-switch button:hover { color: var(--text); }
		.mode-switch button.active { background: transparent; color: #422006; box-shadow: none; }
		/* navigateurs sans :has() : on colore directement le bouton actif */
		@supports not selector(:has(*)) {
			.mode-switch::before { display: none; }
			.mode-switch button.active {
				background: linear-gradient(135deg, #fde047, #f59e0b);
				box-shadow: 0 6px 20px rgba(245, 158, 11, .45);
			}
		}
		@media (max-width: 600px) {
			.mode-switch button { min-width: 0; padding: 10px 16px; }
		}

		/* ---------- Mode Boosters ---------- */
		.booster-mode {
			flex: 1 1 auto;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			gap: 18px;
			min-height: 0;
			padding: 0 0 20px;
		}
		.booster-stage {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 100%;
			min-height: 360px;
		}
		.booster-info { color: var(--muted); text-align: center; min-height: 1.4em; letter-spacing: .3px; }

		/* Paquets (un par série) */
		.pack-wrap { display: flex; flex-direction: column; align-items: center; gap: 30px; width: 100%; }
		.pack-hint { color: var(--muted); letter-spacing: 2px; font-size: .8rem; text-transform: uppercase; }
		.pack-row { display: flex; flex-wrap: wrap; justify-content: center; gap: 30px; padding: 10px; }
		.pack {
			position: relative;
			width: 210px;
			height: 310px;
			padding: 0;
			border: none;
			background: none;
			cursor: pointer;
			font-family: inherit;
			filter: drop-shadow(0 22px 34px rgba(0, 0, 0, .6));
			animation: packFloat 3.2s ease-in-out infinite;
			transition: scale .25s ease, filter .25s ease, opacity .35s ease;
		}
		.pack:nth-child(2) { animation-delay: -.8s; }
		.pack:nth-child(3) { animation-delay: -1.6s; }
		.pack:nth-child(4) { animation-delay: -2.4s; }
		.pack:hover { scale: 1.07; filter: drop-shadow(0 22px 40px color-mix(in srgb, var(--c3) 60%, transparent)); }
		.pack:focus-visible { outline: 2px solid #fff; outline-offset: 8px; border-radius: 14px; }
		.pack-top, .pack-bottom {
			position: absolute;
			left: 0;
			right: 0;
			height: 26px;
			background: repeating-linear-gradient(90deg, #f8fafc 0 3px, #94a3b8 3px 6px);
			z-index: 2;
		}
		.pack-top { top: 0; border-radius: 12px 12px 0 0; transform-origin: left bottom; }
		.pack-bottom { bottom: 0; border-radius: 0 0 12px 12px; }
		.pack-body {
			position: absolute;
			top: 26px;
			bottom: 26px;
			left: 0;
			right: 0;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: space-between;
			gap: 8px;
			padding: 10px 12px;
			overflow: hidden;
			color: #fff;
			background:
				radial-gradient(circle at 18% 12%, rgba(255, 255, 255, .38), transparent 42%),
				linear-gradient(160deg, var(--c1) 0%, var(--c2) 52%, var(--c3) 100%);
			border-left: 2px solid rgba(255, 255, 255, .35);
			border-right: 2px solid rgba(255, 255, 255, .35);
		}
		/* grande Pokéball en filigrane */
		.pack-body::before {
			content: '';
			position: absolute;
			width: 300px;
			height: 300px;
			right: -110px;
			bottom: -110px;
			border-radius: 50%;
			border: 16px solid rgba(255, 255, 255, .1);
			background: linear-gradient(transparent 44%, rgba(255, 255, 255, .1) 44% 56%, transparent 56%);
		}
		/* reflet holographique animé */
		.pack-body::after {
			content: '';
			position: absolute;
			inset: 0;
			z-index: 3;
			pointer-events: none;
			background: linear-gradient(115deg, transparent 25%, rgba(255, 255, 255, .42) 40%, rgba(255, 255, 255, 0) 52%, transparent 70%);
			background-size: 260% 100%;
			animation: packShine 3.4s linear infinite;
		}
		.pack-body > * { position: relative; z-index: 1; }
		.pack-logo-img {
			max-width: 70%;
			max-height: 38px;
			object-fit: contain;
			filter: drop-shadow(0 3px 8px rgba(0, 0, 0, .5));
		}
		/* visuel central : 2 Pokémon de ta collection */
		.pack-art { flex: 1; width: 100%; min-height: 0; }
		.pack-art::before {
			content: '';
			position: absolute;
			inset: 0;
			background: radial-gradient(circle at 50% 55%, rgba(255, 255, 255, .6), transparent 62%);
		}
		.pack-mon {
			position: absolute;
			bottom: 0;
			object-fit: contain;
			filter: drop-shadow(0 6px 10px rgba(0, 0, 0, .55));
		}
		.pack-mon-1 { left: 2%; height: 100%; max-width: 62%; transform: rotate(-6deg); }
		.pack-mon-2 { right: 2%; height: 84%; max-width: 54%; transform: rotate(6deg); }
		.pack-banner {
			display: flex;
			flex-direction: column;
			align-items: center;
			gap: 3px;
			line-height: 1;
			padding: 7px 18px;
			border-radius: 10px;
			background: rgba(0, 0, 0, .3);
			border: 1px solid rgba(255, 255, 255, .28);
		}
		.pack-banner small {
			font-size: .58rem;
			letter-spacing: 3px;
			text-transform: uppercase;
			color: #fef9c3;
		}
		.pack-banner strong {
			font-size: 1.55rem;
			font-weight: 900;
			letter-spacing: 3px;
			background: linear-gradient(#fff7ae, #facc15 55%, #f59e0b);
			-webkit-background-clip: text;
			background-clip: text;
			color: transparent;
			filter: drop-shadow(0 2px 0 rgba(120, 53, 15, .85));
		}
		.pack-chip {
			font-style: normal;
			font-size: .6rem;
			letter-spacing: 1.5px;
			text-transform: uppercase;
			padding: 4px 11px;
			border-radius: 999px;
			color: #fef9c3;
			background: rgba(0, 0, 0, .3);
			border: 1px solid rgba(255, 255, 255, .22);
		}

		/* choix d'un paquet : les autres s'effacent */
		.pack-row.picking .pack:not(.opening) { animation: none; opacity: 0; scale: .85; pointer-events: none; }
		.pack.opening { cursor: default; scale: 1.1; animation: packShake .6s ease-in-out both, packBurst .5s .6s ease-out forwards; }
		.pack.opening .pack-top { animation: packTear .5s .5s ease-in forwards; }

		@media (max-width: 600px) {
			.pack-row { gap: 12px; }
			.pack { zoom: .72; }
		}

		/* ---------- Carte unique (une à la fois) ---------- */
		.viewer {
			--ch: clamp(320px, 52vh, 460px);
			--cw: calc(var(--ch) * .7);
			display: flex;
			flex-direction: column;
			align-items: center;
		}
		.viewer-progress { display: flex; gap: 10px; justify-content: center; margin-bottom: 20px; }
		.dot {
			width: 10px;
			height: 10px;
			border-radius: 50%;
			background: rgba(255, 255, 255, .18);
			transition: all .3s;
		}
		.dot.done { background: #94a3b8; }
		.dot.active { background: #fff; transform: scale(1.4); box-shadow: 0 0 10px rgba(255, 255, 255, .6); }
		.dot.star { background: rgba(250, 204, 21, .4); }
		.dot.star.active { background: #facc15; box-shadow: 0 0 14px rgba(250, 204, 21, .9); }

		.viewer-card-area { position: relative; display: flex; justify-content: center; width: 100%; }
		.viewer-card-area.leaving { animation: cardOut .28s ease-in forwards; }
		.viewer-card-area.entering { animation: cardIn .4s cubic-bezier(.2, .8, .3, 1) both; }

		.viewer-tilt {
			transform: perspective(1000px) rotateX(var(--rx, 0deg)) rotateY(var(--ry, 0deg));
			transform-style: preserve-3d;
			transition: transform .15s ease-out;
		}
		.vcard {
			position: relative;
			width: var(--cw);
			height: var(--ch);
			font-size: calc(var(--cw) / 20);
			transform-style: preserve-3d;
			transition: transform .7s cubic-bezier(.645, .045, .355, 1);
			cursor: pointer;
			outline: none;
		}
		.vcard.no-flip { transition: none; }
		.vcard.revealed { transform: rotateY(180deg); }
		.vcard-face {
			position: absolute;
			inset: 0;
			border-radius: 18px;
			backface-visibility: hidden;
			-webkit-backface-visibility: hidden;
		}
		.vcard-front { transform: rotateY(180deg); }

		/* dos de carte */
		.vcard-back {
			display: flex;
			align-items: center;
			justify-content: center;
			border: 2px solid var(--accent);
			background:
				radial-gradient(circle at 50% 50%, rgba(250, 204, 21, .2), transparent 55%),
				repeating-linear-gradient(45deg, rgba(255, 255, 255, .035) 0 2px, transparent 2px 12px),
				linear-gradient(145deg, color-mix(in srgb, var(--s1, #2563eb) 45%, #0b1220), #0b1220);
			box-shadow: 0 24px 60px rgba(0, 0, 0, .6);
		}
		.vcard-back::before {
			content: '';
			width: 42%;
			aspect-ratio: 1;
			border-radius: 50%;
			border: .35em solid #f8fafc;
			background: linear-gradient(#ef4444 0 46%, #f8fafc 46% 54%, #1e293b 54%);
			box-shadow: 0 0 0 .25em var(--accent), 0 .6em 1.6em rgba(0, 0, 0, .5);
		}
		.vcard-back::after {
			content: '';
			position: absolute;
			inset: 9px;
			border: 1px solid rgba(250, 204, 21, .5);
			border-radius: 11px;
			pointer-events: none;
		}
		/* logo au dos de la carte : il remplace la Pokéball quand le fichier existe */
		.vcard-logo {
			position: relative;
			z-index: 1;
			width: 72%;
			max-height: 24%;
			object-fit: contain;
			filter: drop-shadow(0 .3em .8em rgba(0, 0, 0, .55));
		}
		.vcard-back.has-logo::before { display: none; }
		.vcard.finale:not(.revealed) .vcard-logo { filter: drop-shadow(0 0 1em rgba(250, 204, 21, .85)); }
		.vcard:focus-visible .vcard-back { outline: 2px solid #fff; outline-offset: 4px; }
		/* la dernière carte (shiny) a un dos doré qui pulse */
		.vcard.finale:not(.revealed) .vcard-back {
			border-color: #fde047;
			animation: finalePulse 1.4s ease-in-out infinite;
		}
		.vcard.finale:not(.revealed) .vcard-back::before {
			box-shadow: 0 0 0 .25em #fde047, 0 0 2.2em .6em rgba(250, 204, 21, .75);
		}
		.vcard.revealed.finale .vcard-front { animation: shinyGlow 1.8s ease-out .35s; }

		/* face de carte */
		.tcg {
			position: relative;
			width: 100%;
			height: 100%;
			display: flex;
			flex-direction: column;
			gap: .6em;
			padding: .85em;
			overflow: hidden;
			border-radius: inherit;
			color: #f8fafc;
			border: 2px solid #475569;
			background: linear-gradient(160deg, #1e3a5f 0%, #0f1b33 60%, #0b1220 100%);
			box-shadow: 0 24px 60px rgba(0, 0, 0, .55);
		}
		.tcg.is-shiny {
			border-color: #facc15;
			background: linear-gradient(160deg, #4a3a0e 0%, #1a1405 55%, #0b1220 100%);
			box-shadow: 0 0 40px rgba(250, 204, 21, .45), 0 24px 60px rgba(0, 0, 0, .55);
		}
		.tcg-head { display: flex; align-items: center; justify-content: space-between; gap: .5em; }
		.tcg-namewrap { display: flex; align-items: baseline; gap: .4em; min-width: 0; }
		.tcg-name { font-size: 1.3em; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
		.tcg-namewrap .genre { font-size: 1.1em; }
		.tcg-hp { font-weight: 800; font-size: 1.15em; color: #f87171; white-space: nowrap; }
		.tcg-hp small { font-size: .6em; margin-right: .2em; color: #fca5a5; }
		.tcg-art {
			position: relative;
			flex: 1;
			min-height: 0;
			border-radius: .9em;
			overflow: hidden;
			background: radial-gradient(circle at 50% 40%, #2c4d7a, #0b1220 80%);
			border: 1px solid rgba(255, 255, 255, .14);
		}
		.tcg.is-shiny .tcg-art { background: radial-gradient(circle at 50% 40%, #6b5410, #0b1220 80%); }
		.tcg-art img {
			width: 100%;
			height: 100%;
			object-fit: contain;
			padding: .4em;
			filter: drop-shadow(0 .5em .7em rgba(0, 0, 0, .55));
		}
		.tcg-level, .tcg-badge {
			position: absolute;
			top: .5em;
			padding: .15em .65em;
			border-radius: 999px;
			font-size: .75em;
			font-weight: 700;
		}
		.tcg-level { left: .5em; background: rgba(0, 0, 0, .65); }
		.tcg-badge { right: .5em; background: var(--accent); color: #422006; }
		.tcg-bar { height: .45em; background: rgba(255, 255, 255, .12); border-radius: 999px; overflow: hidden; }
		.tcg-bar div { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #22c55e, #84cc16); }
		.tcg-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: .45em; }
		.tcg-stat {
			padding: .45em .2em;
			border-radius: .7em;
			text-align: center;
			font-size: .78em;
			color: #cbd5e1;
			background: rgba(255, 255, 255, .07);
			border: 1px solid rgba(255, 255, 255, .06);
		}
		.tcg-stat strong { display: block; color: #fde047; font-size: 1.1em; }
		.tcg-foot { font-size: .65em; text-align: center; color: #94a3b8; letter-spacing: .5px; }

		/* effet holographique (shiny) + reflet qui suit la souris */
		.tcg-holo {
			position: absolute;
			inset: 0;
			pointer-events: none;
			opacity: 0;
			mix-blend-mode: color-dodge;
			background: linear-gradient(115deg, transparent 15%, rgba(255, 0, 128, .55) 30%, rgba(255, 220, 0, .55) 42%, rgba(0, 255, 200, .55) 54%, rgba(80, 120, 255, .55) 66%, transparent 80%);
			background-size: 260% 260%;
			background-position: calc(var(--mx, 50) * 1%) calc(var(--my, 50) * 1%);
		}
		.tcg.is-shiny .tcg-holo { opacity: .5; }
		.tcg-glare {
			position: absolute;
			inset: 0;
			pointer-events: none;
			opacity: 0;
			transition: opacity .3s;
			background: radial-gradient(circle at calc(var(--mx, 50) * 1%) calc(var(--my, 50) * 1%), rgba(255, 255, 255, .3), transparent 48%);
		}
		.viewer-tilt:hover .tcg-glare { opacity: 1; }

		/* étincelles à la révélation du shiny */
		.spark {
			position: absolute;
			left: 50%;
			top: 50%;
			width: 8px;
			height: 8px;
			border-radius: 50%;
			background: #fde047;
			box-shadow: 0 0 10px 2px #facc15;
			pointer-events: none;
			animation: sparkFly .9s ease-out forwards;
		}

		/* ---------- Récap du booster ---------- */
		.booster-cards {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			gap: 16px;
			width: 100%;
		}
		.recap-card {
			width: 170px;
			height: 250px;
			animation: dealCard .5s cubic-bezier(.2, .8, .3, 1) both;
			animation-delay: calc(var(--i) * 120ms);
		}
		.recap-card .mini { height: 100%; }

		@keyframes packFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
		@keyframes packShine { from { background-position: 150% 0; } to { background-position: -110% 0; } }
		@keyframes packShake {
			0%, 100% { transform: rotate(0); }
			15% { transform: rotate(-5deg) scale(1.03); }
			30% { transform: rotate(5deg) scale(1.05); }
			45% { transform: rotate(-4deg) scale(1.06); }
			60% { transform: rotate(3deg) scale(1.07); }
			80% { transform: rotate(-2deg) scale(1.08); }
		}
		@keyframes packTear { to { transform: translate(40px, -70px) rotate(24deg); opacity: 0; } }
		@keyframes packBurst {
			to { transform: scale(1.35); opacity: 0; filter: brightness(2.2) drop-shadow(0 0 40px rgba(250, 204, 21, .9)); }
		}
		@keyframes cardOut { to { opacity: 0; transform: translateX(-80px) scale(.9) rotate(-4deg); } }
		@keyframes cardIn {
			from { opacity: 0; transform: translateX(90px) scale(.9) rotate(4deg); }
			to { opacity: 1; transform: none; }
		}
		@keyframes dealCard {
			from { opacity: 0; transform: translateY(-40px) scale(.7) rotate(-6deg); }
			to { opacity: 1; transform: none; }
		}
		@keyframes finalePulse {
			0%, 100% { box-shadow: 0 0 20px rgba(250, 204, 21, .35), 0 24px 60px rgba(0, 0, 0, .6); }
			50% { box-shadow: 0 0 55px 10px rgba(250, 204, 21, .75), 0 24px 60px rgba(0, 0, 0, .6); }
		}
		@keyframes shinyGlow {
			0% { box-shadow: 0 0 0 rgba(250, 204, 21, 0); }
			35% { box-shadow: 0 0 70px 20px rgba(250, 204, 21, .85); }
			100% { box-shadow: 0 0 24px rgba(250, 204, 21, .4); }
		}
		@keyframes sparkFly {
			from { transform: translate(-50%, -50%) scale(1); opacity: 1; }
			to { transform: translate(calc(-50% + var(--dx)), calc(-50% + var(--dy))) scale(.2); opacity: 0; }
		}

		@media (max-width: 600px) {
			.recap-card { width: 140px; height: 210px; }
			.booster-stage { min-height: 320px; }
		}

		/* ---------- Barre joueur + cases du Pokédex ---------- */
		.user-bar {
			position: absolute;
			top: 16px;
			right: 20px;
			display: flex;
			align-items: center;
			gap: 10px;
			padding: 5px 5px 5px 14px;
			font-size: .85rem;
			background: rgba(255, 255, 255, .06);
			border: 1px solid rgba(255, 255, 255, .12);
			border-radius: 999px;
			backdrop-filter: blur(12px);
			-webkit-backdrop-filter: blur(12px);
			z-index: 5;
		}
		.user-name { font-weight: 700; max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
		.user-bar button {
			border: none;
			padding: 7px 14px;
			border-radius: 999px;
			font: inherit;
			font-weight: 700;
			color: var(--text);
			background: rgba(255, 255, 255, .1);
			cursor: pointer;
			transition: background .2s;
		}
		.user-bar button:hover { background: rgba(255, 255, 255, .2); }

		.mini-count {
			position: absolute;
			top: 6px;
			right: 6px;
			padding: 1px 7px;
			border-radius: 999px;
			font-size: .68rem;
			font-weight: 800;
			color: #f8fafc;
			background: rgba(15, 23, 42, .85);
			border: 1px solid rgba(255, 255, 255, .25);
		}
		.mini-shiny + .mini-count { right: 42px; }
		.mini-new { color: #052e16; background: #4ade80; border-color: #4ade80; }

		.mini.locked { cursor: default; border-style: dashed; background: rgba(16, 32, 57, .55); }
		.mini.locked:hover { transform: none; box-shadow: none; }
		.mini.locked .mini-img img { filter: brightness(0) invert(1); opacity: .1; }
		.mini.locked h3 { color: var(--muted); }
		.mini.locked .mini-stats { opacity: .5; }

		.tcg-new {
			position: absolute;
			left: .5em;
			bottom: .5em;
			padding: .15em .7em;
			border-radius: 999px;
			font-size: .75em;
			font-weight: 800;
			color: #052e16;
			background: #4ade80;
			box-shadow: 0 0 1em rgba(74, 222, 128, .6);
		}

		.empty code { padding: 2px 8px; border-radius: 6px; background: rgba(255, 255, 255, .1); color: var(--accent); }

		@media (max-width: 700px) {
			.user-bar { position: static; align-self: center; margin-bottom: 10px; }
		}

		.empty { text-align: center; color: var(--muted); }
		@media (max-width: 600px) {
			body { padding: 18px 10px 24px; }
			h1 { font-size: 1.7rem; }
			.cover-page h2 { font-size: 2rem; }
		}
	</style>
</head>
<body>

	<div class="user-bar">
		<span class="user-name">{{ $user->name }}</span>
		<form method="POST" action="{{ route('logout') }}">
			@csrf
			<button type="submit">Déconnexion</button>
		</form>
	</div>

	<h1>Mon Pokédex</h1>
	<p class="subtitle">{{ $ownedCount }} / {{ $total }} Pokémon capturé(s)</p>

	@php
		$pages = $entries->chunk(9)->values();
	@endphp

	@if($pages->isEmpty())

		<p class="empty">Le catalogue est vide. Lance <code>php artisan pokemon:import</code> dans ton projet, puis recharge la page.</p>

	@else

		<div class="mode-switch" role="group" aria-label="Mode d'affichage">
			<button type="button" class="active" data-mode="book" aria-pressed="true">Livre</button>
			<button type="button" data-mode="booster" aria-pressed="false">Boosters</button>
		</div>

		<div class="stage" id="stage">
			<div class="scaler" id="scaler">
				<div class="book" id="book">

					{{-- Couverture : elle constitue la première page du livre --}}
					<div class="leaf cover-leaf">
						<div class="face front page right cover-page">
							<div class="cover-logo" aria-hidden="true"></div>
							<h2>MON<br>POKÉDEX</h2>
							<p>{{ $ownedCount }} / {{ $total }} Pokémon capturé(s)<br>Mon aventure commence ici !</p>
							<p class="cover-hint">Clique sur la page pour ouvrir</p>
						</div>
						<div class="face back page left inside-cover">
							<div class="inside-symbol">⚡</div>
							<h2>Bienvenue, Dresseur !</h2>
							<p>Ouvre des boosters pour remplir ton Pokédex, puis tourne les pages pour retrouver tes cartes.</p>
						</div>
					</div>

					@foreach($pages->chunk(2) as $leafIndex => $pair)
						@php $pair = $pair->values(); @endphp

						<div class="leaf">
							@foreach(['front' => 0, 'back' => 1] as $side => $k)
								<div class="face {{ $side }} page {{ $k === 0 ? 'right' : 'left' }}">

									@if($pair->has($k))
										<div class="page-grid">
											@foreach($pair[$k] as $entry)
												@if($entry['owned'])
													<div class="mini {{ $entry['is_shiny'] ? 'shiny' : '' }}"
														 title="Obtenu le {{ $entry['obtained_at'] }} · N° {{ $entry['number'] }}">

														<div class="mini-img">
															<img src="{{ $entry['image'] }}" alt="Image {{ $entry['name'] }}" loading="lazy">
														</div>

														<span class="mini-level">Niv. {{ $entry['level'] }}</span>
														@if($entry['is_shiny'])
															<span class="mini-shiny">✨</span>
														@endif
														@if($entry['count'] > 1)
															<span class="mini-count">×{{ $entry['count'] }}</span>
														@endif

														<div class="mini-body">
															<div class="mini-title">
																<h3>{{ $entry['name'] }}</h3>
																<span class="genre {{ $entry['genre'] ? 'female' : 'male' }}">{{ $entry['genre'] ? '♀' : '♂' }}</span>
															</div>
															<div class="life-bar">
																<div style="width: {{ min(100, max(0, $entry['life'] / $maxLife * 100)) }}%"></div>
															</div>
															<div class="mini-stats">
																<span>{{ $entry['life'] }} PV</span>
																<span>{{ $entry['height'] }} m</span>
																<span>{{ $entry['weight'] }} kg</span>
															</div>
														</div>
													</div>
												@else
													<div class="mini locked" title="N° {{ $entry['number'] }} · pas encore obtenu">
														<div class="mini-img">
															<img src="{{ $entry['image'] }}" alt="" loading="lazy">
														</div>
														<span class="mini-level">N° {{ $entry['number'] }}</span>
														<div class="mini-body">
															<div class="mini-title">
																<h3>???</h3>
															</div>
															<div class="life-bar">
																<div style="width: 0%"></div>
															</div>
															<div class="mini-stats">
																<span>— PV</span>
																<span>— m</span>
																<span>— kg</span>
															</div>
														</div>
													</div>
												@endif
											@endforeach
										</div>
										<div class="page-number">— {{ $leafIndex * 2 + $k + 2 }} —</div>
									@endif

								</div>
							@endforeach
						</div>
					@endforeach

				</div>
			</div>
		</div>

		<div class="controls" id="bookControls">
			<button id="prev" aria-label="Page précédente">◀ Précédent</button>
			<span id="indicator"></span>
			<button id="next" aria-label="Page suivante">Suivant ▶</button>
		</div>

		{{-- Mode Boosters --}}
		<section class="booster-mode" id="boosterMode" hidden>
			<div class="booster-stage">

		{{-- 1. Choix du booster (les paquets sont générés en JS : une carte par série) --}}
		{{-- Logo : dépose ton fichier dans public/images/pokemon-logo.png, il s'affiche en haut de chaque paquet (masqué s'il est absent) --}}
		<div class="pack-wrap" id="packWrap">
			<div class="pack-row" id="packRow"></div>
			<p class="pack-hint">Choisis ton booster pour l'ouvrir</p>
		</div>

				{{-- 2. Les cartes, une à la fois --}}
				<div class="viewer" id="viewer" hidden>
					<div class="viewer-progress" id="viewerProgress"></div>
					<div class="viewer-card-area" id="viewerArea">
						<div class="viewer-tilt" id="viewerTilt">
							<div class="vcard" id="vcard" tabindex="0" role="button" aria-label="Carte du booster">
								<div class="vcard-face vcard-back">
							{{-- Logo du dos des cartes : public/images/card-back-logo.png (la Pokéball s'affiche tant qu'il est absent) --}}
							<img class="vcard-logo" src="{{ asset('images/card-back-logo.png') }}" alt=""
								 onload="this.parentElement.classList.add('has-logo')" onerror="this.remove()">
						</div>
								<div class="vcard-face vcard-front" id="vcardFront"></div>
							</div>
						</div>
					</div>
				</div>

				{{-- 3. Récapitulatif --}}
				<div class="booster-cards" id="recap" hidden></div>
			</div>

			<p class="booster-info" id="boosterInfo"></p>

			<div class="controls">
				<button type="button" id="stepBtn" hidden>Retourner la carte</button>
				<button type="button" id="skipBtn" class="ghost" hidden>Passer</button>
				<button type="button" id="boosterAgain" hidden>🎁 Nouveau booster</button>
			</div>
		</section>


        <div class="pokemon-modal" id="pokemonModal" role="dialog" aria-modal="true" aria-label="Détail du Pokémon">
            <div class="pokemon-modal-card">
                <button class="pokemon-modal-close" id="pokemonModalClose" aria-label="Fermer">×</button>
                <h2 id="modalPokemonName">Pokémon</h2>
                <div class="modal-level" id="modalPokemonLevel"></div>
                <img id="modalPokemonImage" src="" alt="">
                <div class="modal-stats">
                    <div class="modal-stat"><strong id="modalPokemonLife">—</strong>PV</div>
                    <div class="modal-stat"><strong id="modalPokemonHeight">—</strong>Taille</div>
                    <div class="modal-stat"><strong id="modalPokemonWeight">—</strong>Poids</div>
                </div>
                <p id="modalPokemonShiny" style="margin-top:12px;text-align:center;color:var(--accent);font-weight:700"></p>
            </div>
        </div>

		<script>
			const PAGE_W = 540;   // même valeur que --w
			const PAGE_H = 700;   // même valeur que --h
			const DURATION = 800;

			const book = document.getElementById('book');
			const scaler = document.getElementById('scaler');
			const stage = document.getElementById('stage');
			const leaves = Array.from(book.querySelectorAll('.leaf'));
			const total = leaves.length;
			const totalPages = {{ $pages->count() + 1 }};
			const prevBtn = document.getElementById('prev');
			const nextBtn = document.getElementById('next');
			const indicator = document.getElementById('indicator');

			let current = 0; // nombre de feuilles déjà tournées

			function layout() {
				leaves.forEach((leaf, i) => {
					leaf.classList.toggle('flipped', i < current);
					leaf.style.zIndex = i < current ? i + 1 : total - i;
				});
			}

			function update() {
				// livre fermé : page de droite centrée / ouvert : centré / fin : page de gauche centrée
				let shift = 0;
				if (current === 0) shift = 0;
				else if (current === total) shift = PAGE_W;
				else shift = PAGE_W / 2;
				book.style.transform = 'translateX(' + shift + 'px)';

				const left = current * 2;
				const right = current * 2 + 1;
				const parts = [];
				if (current > 0 && left <= totalPages) parts.push(left);
				if (current < total && right <= totalPages) parts.push(right);
				indicator.textContent = 'Page' + (parts.length > 1 ? 's ' : ' ') + parts.join(' – ') + ' / ' + totalPages;

				prevBtn.disabled = current === 0;
				nextBtn.disabled = current === total;
			}

			function next() {
				if (current >= total) return;
				leaves[current].style.zIndex = total + 1;
				current++;
				leaves[current - 1].classList.add('flipped');
				update();
				setTimeout(layout, DURATION);
			}

			function prev() {
				if (current <= 0) return;
				current--;
				leaves[current].style.zIndex = total + 1;
				leaves[current].classList.remove('flipped');
				update();
				setTimeout(layout, DURATION);
			}

			function fit() {
				// Le livre est agrandi, puis réduit uniquement si l'écran est trop petit.
				const availableHeight = Math.max(420, window.innerHeight - 175);
				const scale = Math.min(1.08, (window.innerWidth - 48) / (PAGE_W * 2), availableHeight / PAGE_H);
				const safeScale = Math.max(0.42, scale);
				scaler.style.transform = 'scale(' + safeScale + ')';
				stage.style.height = (PAGE_H * safeScale) + 'px';
			}

			prevBtn.addEventListener('click', prev);
			nextBtn.addEventListener('click', next);

			// Clic sur une carte : ouvrir sa version agrandie sans tourner la page.
            const pokemonModal = document.getElementById('pokemonModal');
            const closePokemonModal = () => pokemonModal.classList.remove('open');
            const modalCloseButton = document.getElementById('pokemonModalClose');

            function openPokemonCard(mini) {
                const image = mini.querySelector('.mini-img img');
                const name = mini.querySelector('.mini-title h3');
                const level = mini.querySelector('.mini-level');
                const genre = mini.querySelector('.genre');
                const stats = mini.querySelectorAll('.mini-stats span');
                document.getElementById('modalPokemonName').textContent = (name?.textContent || 'Pokémon') + (genre ? ' ' + genre.textContent : '');
                document.getElementById('modalPokemonLevel').textContent = level ? level.textContent : '';
                document.getElementById('modalPokemonImage').src = image ? image.src : '';
                document.getElementById('modalPokemonImage').alt = name ? name.textContent : 'Pokémon';
                document.getElementById('modalPokemonLife').textContent = stats[0]?.textContent || '—';
                document.getElementById('modalPokemonHeight').textContent = stats[1]?.textContent || '—';
                document.getElementById('modalPokemonWeight').textContent = stats[2]?.textContent || '—';
                document.getElementById('modalPokemonShiny').textContent = mini.classList.contains('shiny') ? '✨ Pokémon Shiny !' : '';
                pokemonModal.classList.add('open');
            }

            book.addEventListener('click', (e) => {
                const mini = e.target.closest('.mini');
                if (mini) {
                    e.stopPropagation();
                    if (!mini.classList.contains('locked')) openPokemonCard(mini);
                    return;
                }
                const page = e.target.closest('.page');
                if (!page) return;
                page.classList.contains('right') ? next() : prev();
            });

            modalCloseButton.addEventListener('click', closePokemonModal);
            pokemonModal.addEventListener('click', (e) => {
                if (e.target === pokemonModal) closePokemonModal();
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closePokemonModal();
            });

			document.addEventListener('keydown', (e) => {
				if (mode !== 'book') return;
				if (e.key === 'ArrowRight') next();
				if (e.key === 'ArrowLeft') prev();
			});

			window.addEventListener('resize', fit);

			/* ---------- Mode Boosters ---------- */
			const BOOSTER_SIZE = 5;
			const MAX_LIFE = {{ $maxLife }};
			const PACK_ART = @json($packArt);
			const OPEN_URL = @json(route('boosters.open'));
			const LOGIN_URL = @json(route('login'));
			const CSRF = document.querySelector('meta[name="csrf-token"]').content;

			const modeButtons = document.querySelectorAll('.mode-switch button');
			const bookControls = document.getElementById('bookControls');
			const boosterMode = document.getElementById('boosterMode');
			const packWrap = document.getElementById('packWrap');
			const packRow = document.getElementById('packRow');
			const LOGO_URL = @json(asset('images/pokemon-logo.png'));
			const viewer = document.getElementById('viewer');
			const viewerProgress = document.getElementById('viewerProgress');
			const viewerArea = document.getElementById('viewerArea');
			const viewerTilt = document.getElementById('viewerTilt');
			const vcard = document.getElementById('vcard');
			const vcardFront = document.getElementById('vcardFront');
			const recap = document.getElementById('recap');
			const boosterInfo = document.getElementById('boosterInfo');
			const stepBtn = document.getElementById('stepBtn');
			const skipBtn = document.getElementById('skipBtn');
			const againBtn = document.getElementById('boosterAgain');

			let mode = 'book';
			let boosterBusy = false;
			let cards = [];
			let cardIndex = 0;
			let collectionChanged = false; // vrai dès qu'un booster a été ouvert : le livre doit être rechargé

			function setMode(next) {
				if (next === 'book' && collectionChanged) {
					window.location.reload();
					return;
				}
				mode = next;
				const isBooster = next === 'booster';
				stage.hidden = isBooster;
				bookControls.hidden = isBooster;
				boosterMode.hidden = !isBooster;
				modeButtons.forEach((b) => {
					const active = b.dataset.mode === next;
					b.classList.toggle('active', active);
					b.setAttribute('aria-pressed', active ? 'true' : 'false');
				});
				if (!isBooster) fit();
			}

			function el(tag, className, text) {
				const node = document.createElement(tag);
				if (className) node.className = className;
				if (text !== undefined) node.textContent = text;
				return node;
			}

			function capturedLabel(p) {
				return p.obtained_at ? 'Obtenu le ' + p.obtained_at : '';
			}

			// Mini-carte (récap) : mêmes classes que le livre => la modale d'agrandissement fonctionne telle quelle
			function buildMini(p) {
				const mini = el('div', 'mini' + (p.is_shiny ? ' shiny' : ''));
				const label = capturedLabel(p);
				if (label) mini.title = label + ' · N° ' + p.number;

				const imgWrap = el('div', 'mini-img');
				const img = document.createElement('img');
				img.src = p.image;
				img.alt = 'Image ' + p.name;
				imgWrap.appendChild(img);
				mini.appendChild(imgWrap);

				mini.appendChild(el('span', 'mini-level', 'Niv. ' + p.level));
				if (p.is_shiny) mini.appendChild(el('span', 'mini-shiny', '✨'));
				if (p.is_new) mini.appendChild(el('span', 'mini-count mini-new', 'NEW'));

				const body = el('div', 'mini-body');
				const title = el('div', 'mini-title');
				title.appendChild(el('h3', '', p.name));
				title.appendChild(el('span', 'genre ' + (p.genre ? 'female' : 'male'), p.genre ? '♀' : '♂'));
				body.appendChild(title);

				const bar = el('div', 'life-bar');
				const fill = document.createElement('div');
				fill.style.width = Math.min(100, Math.max(0, p.life / MAX_LIFE * 100)) + '%';
				bar.appendChild(fill);
				body.appendChild(bar);

				const stats = el('div', 'mini-stats');
				stats.appendChild(el('span', '', p.life + ' PV'));
				stats.appendChild(el('span', '', p.height + ' m'));
				stats.appendChild(el('span', '', p.weight + ' kg'));
				body.appendChild(stats);

				mini.appendChild(body);
				return mini;
			}

			// Grande carte (une à la fois)
			function buildTcg(p) {
				const card = el('div', 'tcg' + (p.is_shiny ? ' is-shiny' : ''));

				const head = el('div', 'tcg-head');
				const nameWrap = el('div', 'tcg-namewrap');
				nameWrap.appendChild(el('h3', 'tcg-name', p.name));
				nameWrap.appendChild(el('span', 'genre ' + (p.genre ? 'female' : 'male'), p.genre ? '♀' : '♂'));
				head.appendChild(nameWrap);
				const hp = el('span', 'tcg-hp');
				hp.appendChild(el('small', '', 'PV'));
				hp.appendChild(document.createTextNode(String(p.life)));
				head.appendChild(hp);
				card.appendChild(head);

				const art = el('div', 'tcg-art');
				const img = document.createElement('img');
				img.src = p.image;
				img.alt = 'Image ' + p.name;
				art.appendChild(img);
				art.appendChild(el('span', 'tcg-level', 'Niv. ' + p.level));
				if (p.is_shiny) art.appendChild(el('span', 'tcg-badge', '✨ Shiny'));
				if (p.is_new) art.appendChild(el('span', 'tcg-new', 'Nouveau !'));
				card.appendChild(art);

				const bar = el('div', 'tcg-bar');
				const fill = document.createElement('div');
				fill.style.width = Math.min(100, Math.max(0, p.life / MAX_LIFE * 100)) + '%';
				bar.appendChild(fill);
				card.appendChild(bar);

				const stats = el('div', 'tcg-stats');
				[['Taille', p.height + ' m'], ['Poids', p.weight + ' kg'], ['N°', '#' + String(p.number).padStart(3, '0')]].forEach(([label, value]) => {
					const chip = el('div', 'tcg-stat');
					chip.appendChild(el('strong', '', value));
					chip.appendChild(document.createTextNode(label));
					stats.appendChild(chip);
				});
				card.appendChild(stats);

				const foot = capturedLabel(p);
				if (foot) card.appendChild(el('div', 'tcg-foot', foot));

				card.appendChild(el('div', 'tcg-holo'));
				card.appendChild(el('div', 'tcg-glare'));
				return card;
			}

			function shuffled(list) {
				const a = list.slice();
				for (let i = a.length - 1; i > 0; i--) {
					const j = Math.floor(Math.random() * (i + 1));
					[a[i], a[j]] = [a[j], a[i]];
				}
				return a;
			}

			// Le tirage se fait sur le serveur : il choisit les 5 cartes ET les enregistre dans ta collection
			async function fetchBooster() {
				const response = await fetch(OPEN_URL, {
					method: 'POST',
					credentials: 'same-origin',
					headers: {
						'X-CSRF-TOKEN': CSRF,
						'Accept': 'application/json',
						'X-Requested-With': 'XMLHttpRequest',
					},
				});
				if (response.status === 401 || response.status === 419) {
					window.location.href = LOGIN_URL; // session expirée
					throw new Error('Session expirée, reconnexion…');
				}
				let data = null;
				try { data = await response.json(); } catch (e) { /* réponse non JSON */ }
				if (!response.ok || !data || !Array.isArray(data.cards)) {
					throw new Error((data && data.message) || 'Impossible d\'ouvrir le booster, réessaie.');
				}
				return data.cards;
			}

			function renderProgress() {
				viewerProgress.replaceChildren();
				cards.forEach((p, i) => {
					let cls = 'dot';
					if (i < cardIndex) cls += ' done';
					if (i === cardIndex) cls += ' active';
					if (p.is_shiny) cls += ' star';
					viewerProgress.appendChild(el('span', cls));
				});
			}

			function renderControls() {
				const inRecap = !recap.hidden;
				const hasCards = cards.length > 0;
				const revealed = vcard.classList.contains('revealed');
				const last = cardIndex === cards.length - 1;

				stepBtn.hidden = inRecap || !hasCards;
				skipBtn.hidden = inRecap || !hasCards || last;
				againBtn.hidden = !inRecap;

				stepBtn.textContent = !revealed ? 'Retourner la carte' : (last ? 'Voir le récap' : 'Carte suivante ▶');

				if (!hasCards) boosterInfo.textContent = '';
				else if (inRecap) boosterInfo.textContent = 'Booster terminé — clique sur une carte pour l\'agrandir';
				else if (!revealed) boosterInfo.textContent = 'Carte ' + (cardIndex + 1) + ' / ' + cards.length + ' — clique sur la carte pour la retourner';
				else boosterInfo.textContent = cards[cardIndex].is_shiny ? '✨ Carte shiny ! ✨' : 'Clique pour passer à la carte suivante';
			}

			function renderCard() {
				const p = cards[cardIndex];
				vcardFront.replaceChildren(buildTcg(p));
				vcard.classList.toggle('finale', !!p.is_shiny);
				vcard.setAttribute('aria-label', 'Carte ' + (cardIndex + 1) + ' sur ' + cards.length + ' : cliquer pour la retourner');
				renderProgress();
				renderControls();
			}

			function burst() {
				for (let i = 0; i < 22; i++) {
					const s = el('span', 'spark');
					const angle = Math.random() * Math.PI * 2;
					const dist = 120 + Math.random() * 150;
					s.style.setProperty('--dx', Math.cos(angle) * dist + 'px');
					s.style.setProperty('--dy', Math.sin(angle) * dist + 'px');
					viewerArea.appendChild(s);
					setTimeout(() => s.remove(), 1000);
				}
			}

			function revealCurrent() {
				boosterBusy = true;
				vcard.classList.add('revealed');
				renderControls();
				if (cards[cardIndex].is_shiny) setTimeout(burst, 350);
				setTimeout(() => { boosterBusy = false; }, 700);
			}

			function goToNextCard() {
				boosterBusy = true;
				viewerArea.classList.add('leaving');
				setTimeout(() => {
					vcard.classList.add('no-flip');
					vcard.classList.remove('revealed');
					viewerArea.classList.remove('leaving');
					renderCard();
					void vcard.offsetWidth;
					vcard.classList.remove('no-flip');
					viewerArea.classList.add('entering');
					setTimeout(() => {
						viewerArea.classList.remove('entering');
						boosterBusy = false;
					}, 420);
				}, 280);
			}

			function showRecap() {
				viewer.hidden = true;
				recap.replaceChildren();
				cards.forEach((p, i) => {
					const tile = el('div', 'recap-card');
					tile.style.setProperty('--i', i);
					tile.appendChild(buildMini(p));
					recap.appendChild(tile);
				});
				recap.hidden = false;
				renderControls();
			}

			function step() {
				if (boosterBusy || !cards.length || !recap.hidden) return;
				if (!vcard.classList.contains('revealed')) {
					revealCurrent();
				} else if (cardIndex < cards.length - 1) {
					cardIndex++;
					goToNextCard();
				} else {
					showRecap();
				}
			}

			// Séries de boosters (noms et couleurs inventés : visuel uniquement)
			const SERIES = [
				{ id: 'braise', no: '01', name: 'BRAISE', c1: '#b91c1c', c2: '#ea580c', c3: '#fbbf24' },
				{ id: 'maree',  no: '02', name: 'MARÉE',  c1: '#1d4ed8', c2: '#0891b2', c3: '#67e8f9' },
				{ id: 'orage',  no: '03', name: 'ORAGE',  c1: '#4c1d95', c2: '#7c3aed', c3: '#facc15' },
				{ id: 'sylve',  no: '04', name: 'SYLVE',  c1: '#065f46', c2: '#16a34a', c3: '#bef264' },
			];

			function renderPacks() {
				packRow.replaceChildren();
				SERIES.forEach((s) => {
					const btn = el('button', 'pack');
					btn.type = 'button';
					btn.dataset.series = s.id;
					btn.setAttribute('aria-label', 'Ouvrir un booster ' + s.name);
					btn.style.setProperty('--c1', s.c1);
					btn.style.setProperty('--c2', s.c2);
					btn.style.setProperty('--c3', s.c3);

					btn.appendChild(el('span', 'pack-top'));

					const body = el('span', 'pack-body');
					const logo = document.createElement('img');
					logo.className = 'pack-logo-img';
					logo.src = LOGO_URL;
					logo.alt = '';
					logo.onerror = () => logo.remove();
					body.appendChild(logo);

					const art = el('span', 'pack-art');
					shuffled(PACK_ART).slice(0, 2).forEach((src, i) => {
						const im = document.createElement('img');
						im.className = 'pack-mon pack-mon-' + (i + 1);
						im.src = src;
						im.alt = '';
						art.appendChild(im);
					});
					body.appendChild(art);

					const banner = el('span', 'pack-banner');
					banner.appendChild(el('small', '', 'Série ' + s.no));
					banner.appendChild(el('strong', '', s.name));
					body.appendChild(banner);
					body.appendChild(el('em', 'pack-chip', '5 cartes · 1 shiny'));

					btn.appendChild(body);
					btn.appendChild(el('span', 'pack-bottom'));
					btn.addEventListener('click', () => openPack(s, btn));
					packRow.appendChild(btn);
				});
			}

			function openPack(series, btn) {
				if (boosterBusy) return;
				boosterBusy = true;
				boosterMode.style.setProperty('--s1', series.c2);
				cardIndex = 0;
				boosterInfo.textContent = '';
				packRow.classList.add('picking');
				btn.classList.add('opening');

				// l'animation dure ~1,15 s ; le serveur répond pendant ce temps
				const animation = new Promise((resolve) => setTimeout(resolve, 1150));
				Promise.all([fetchBooster(), animation]).then(([drawn]) => {
					cards = drawn;
					collectionChanged = true;
					packWrap.hidden = true;
					packRow.classList.remove('picking');
					vcard.classList.add('no-flip');
					vcard.classList.remove('revealed');
					viewer.hidden = false;
					renderCard();
					void vcard.offsetWidth;
					vcard.classList.remove('no-flip');
					viewerArea.classList.add('entering');
					setTimeout(() => viewerArea.classList.remove('entering'), 450);
					boosterBusy = false;
				}).catch((error) => {
					packRow.classList.remove('picking');
					btn.classList.remove('opening');
					boosterBusy = false;
					boosterInfo.textContent = error.message;
				});
			}

			function anotherPack() {
				if (boosterBusy) return;
				cards = [];
				cardIndex = 0;
				recap.hidden = true;
				recap.replaceChildren();
				viewer.hidden = true;
				renderPacks();
				packWrap.hidden = false;
				renderControls();
				const first = packRow.querySelector('.pack');
				if (first) first.focus();
			}

			// Inclinaison 3D + reflet qui suit la souris
			viewerTilt.addEventListener('pointermove', (e) => {
				const r = viewerTilt.getBoundingClientRect();
				const x = (e.clientX - r.left) / r.width;
				const y = (e.clientY - r.top) / r.height;
				viewerTilt.style.setProperty('--ry', ((x - .5) * 16) + 'deg');
				viewerTilt.style.setProperty('--rx', ((.5 - y) * 16) + 'deg');
				viewerTilt.style.setProperty('--mx', (x * 100).toFixed(1));
				viewerTilt.style.setProperty('--my', (y * 100).toFixed(1));
			});
			viewerTilt.addEventListener('pointerleave', () => {
				viewerTilt.style.setProperty('--rx', '0deg');
				viewerTilt.style.setProperty('--ry', '0deg');
			});

			modeButtons.forEach((b) => b.addEventListener('click', () => setMode(b.dataset.mode)));
			vcard.addEventListener('click', step);
			vcard.addEventListener('keydown', (e) => {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					step();
				}
			});
			stepBtn.addEventListener('click', step);
			skipBtn.addEventListener('click', () => {
				if (boosterBusy || !cards.length) return;
				showRecap();
			});
			againBtn.addEventListener('click', anotherPack);
			recap.addEventListener('click', (e) => {
				const mini = e.target.closest('.mini');
				if (mini) openPokemonCard(mini);
			});
			document.addEventListener('keydown', (e) => {
				if (mode === 'booster' && e.key === 'ArrowRight' && !pokemonModal.classList.contains('open')) step();
			});

			renderPacks();

			layout();
			update();
			fit();
		</script>

	@endif

</body>
</html>
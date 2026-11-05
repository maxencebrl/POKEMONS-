@extends('auth.layout')

@section('title', 'Inscription')
@section('subtitle', 'Commence ta collection')

@section('content')
	<h2>Créer un compte</h2>

	<form method="POST" action="{{ route('register') }}">
		@csrf

		<div class="field">
			<label for="name">Pseudo</label>
			<input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="nickname" maxlength="30">
			@error('name') <p class="error">{{ $message }}</p> @enderror
		</div>

		<div class="field">
			<label for="email">Adresse e-mail</label>
			<input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
			@error('email') <p class="error">{{ $message }}</p> @enderror
		</div>

		<div class="field">
			<label for="password">Mot de passe (8 caractères minimum)</label>
			<input id="password" type="password" name="password" required autocomplete="new-password">
			@error('password') <p class="error">{{ $message }}</p> @enderror
		</div>

		<div class="field">
			<label for="password_confirmation">Confirme le mot de passe</label>
			<input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
		</div>

		<button type="submit" class="submit">Créer mon compte</button>
	</form>

	<p class="switch">Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
@endsection

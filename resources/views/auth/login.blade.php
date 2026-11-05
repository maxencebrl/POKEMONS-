@extends('auth.layout')

@section('title', 'Connexion')
@section('subtitle', 'Retrouve ta collection')

@section('content')
	<h2>Connexion</h2>

	<form method="POST" action="{{ route('login') }}">
		@csrf

		<div class="field">
			<label for="email">Adresse e-mail</label>
			<input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
			@error('email') <p class="error">{{ $message }}</p> @enderror
		</div>

		<div class="field">
			<label for="password">Mot de passe</label>
			<input id="password" type="password" name="password" required autocomplete="current-password">
			@error('password') <p class="error">{{ $message }}</p> @enderror
		</div>

		<label class="remember">
			<input type="checkbox" name="remember" value="1"> Rester connecté
		</label>

		<button type="submit" class="submit">Se connecter</button>
	</form>

	<p class="switch">Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte</a></p>
@endsection

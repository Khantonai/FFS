@extends('layouts.app')

@section('title', 'Connexion')

@section('style')
    <style>
        main {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            width: 300px;
        }

        label {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        input, select {
            padding: 0.5rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 0.5rem;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid #f5c6cb;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('content')

<main>

    <h1>Connexion</h1>
    <form action="{{ route('users.login') }}" method="POST">
        @csrf
        <label for="email">
            Email*
            <input type="email" name="email" id="email" required>
            @if ($errors->has('email'))
                <p class="error">{{ $errors->first('email') }}</p>
            @endif
        </label>
        <label for="password">
            Mot de passe*
            <input type="password" name="password" id="password" required>
            @if ($errors->has('password'))
                <p class="error">{{ $errors->first('password') }}</p>
            @endif
        </label>
        <label for="remember">
            <input type="checkbox" name="remember" id="remember">
            Se souvenir de moi
        </label>
        <input type="submit" value="Se connecter">
    </form>
@endsection
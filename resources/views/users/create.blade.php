@extends('layouts.app')

@section('title', 'Créer un utilisateur')

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

    <h1>Créer un utilisateur</h1>
    <form action="{{ route('users.register') }}" method="POST">
        @csrf
        <label for="pseudo">
            Pseudo*
            <input type="text" name="pseudo" id="pseudo" required>
            @if ($errors->has('pseudo'))
                <p class="error">{{ $errors->first('pseudo') }}</p>
            @endif
        </label>
        <label for="email">
            Email*
            <input type="email" name="email" id="email" required>
            @if ($errors->has('email'))
                <p class="error">{{ $errors->first('email') }}</p>
            @endif
        </label>
        <label for="password">
            Mot de passe (8 caractères minimum)*
            <input type="password" name="password" id="password" required>
            @if ($errors->has('password'))
                <p class="error">{{ $errors->first('password') }}</p>
            @endif
        </label>
        <label for="confirmed_password">
            Confirmer le mot de passe*
            <input type="password" name="confirmed_password" id="confirmed-password" required>
            @if ($errors->has('confirmed_password'))
                <p class="error">{{ $errors->first('confirmed_password') }}</p>
            @endif
        </label>
        <input type="submit" value="Créer">
    </form>
</main>
@endsection
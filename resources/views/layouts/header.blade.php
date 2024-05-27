<!-- resources/views/layouts/header.blade.php -->

<header id="header">
    <nav>
        <ul>
            <li><a href="/"><img src="{{ asset('storage/images/logo.svg') }}" alt=""></a></li>
            <li><a href="{{ route('experiences.index') }}">Expériences</a></li>
            <li><a href="{{ route('experiences.create') }}">Ajouter une expérience</a></li>
            @auth
            <li><a href="/dashboard">Dashboard</a></li>
                <li>
                    <form method="POST" action="{{ route('users.logout') }}">
                        @csrf
                        <button type="submit" class="header-button">Déconnexion</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('users.login') }}">Connexion</a></li>
                <li><a href="{{ route('users.create') }}">Inscription</a></li>
            @endauth
        </ul>
    </nav>
</header>
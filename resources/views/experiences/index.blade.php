<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Expériences</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                width: fit-content;
            }
            td {
                border: 1px solid #000;
                padding: 0.5rem;
                width: fit-content;
            }
            th {
                border: 1px solid #000;
                padding: 0.5rem;
                background-color: #f0f0f0;
                width: fit-content;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007BFF;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h1>Expériences</h1>
        <form action="/experiences" method="GET" id="search-form">
            <input type="text" name="search" placeholder="Rechercher..." id="search-field" value="{{ $search }}">
            <select name="activity" id="activity-select">
                <option value="">Toutes les activités</option>
                @foreach ($activities as $activity)
                    <option value="{{ $activity }}" <?php if ($activity_select && $activity_select == $activity) {echo 'selected';} ?>>{{ $activity }}</option>
                @endforeach
            </select>
            <a href="/experiences" class="button">Réinitialiser</a>
        </form>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Utilisateur</th>
                <th>Site</th>
                <th>Activité</th>
                <th>Date de création</th>
                <th>Créé il y a</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($experiences as $experience)
                <tr>
                    <td>{{ $experience->title }}</td>
                    <td>{{ substr(hash('sha256', $experience->email), 0, 6) }}</td>                    
                    <td>{{ $experience->site_name }}</td>
                    <td>{{ $experience->activity->name }}</td>
                    <td>{{ $experience->created_at->format('d/m/Y') }}</td>
                    <td>{{ $experience->created_at->diffForHumans() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

        



    </body>
    <script>
        var searchField = document.getElementById('search-field');

        searchField.addEventListener('focus', function() {
            document.cookie = "searchFieldFocused=true; path=/";
        });

        searchField.addEventListener('blur', function() {
            document.cookie = "searchFieldFocused=false; path=/";
        });

        

        if (document.cookie.includes('searchFieldFocused=true')) {
            document.getElementById('search-field').focus(); 
            document.getElementById('search-field').selectionStart = document.getElementById('search-field').value.length;
        }

        document.getElementById('search-field').addEventListener('input', function() {
            document.getElementById('search-form').submit();
        });

        document.getElementById('activity-select').addEventListener('input', function() {
            document.getElementById('search-form').submit();
        });

    </script>
</html>

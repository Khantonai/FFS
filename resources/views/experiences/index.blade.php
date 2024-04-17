<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Expériences</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            .clickable-row {
                cursor: pointer;
            }
            .clickable-row:hover {
                background-color: #f0f0f0;
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
            <div>
                <select name="date-period" id="date-period">
                    <option value="before" <?php if ($date_period && $date_period == 'before') {echo 'selected';} ?>>Avant</option>
                    <option value="after" <?php if ($date_period && $date_period == 'after') {echo 'selected';} ?>>Après</option>
                    <option value="between" <?php if ($date_period && $date_period == 'between') {echo 'selected';} ?>>Entre</option>
                </select>
                <input type="date" name="date" value="{{ $date }}" id="date">
                <input type="date" name="date2" value="{{ $date2 }}" style="<?php if ($date_period != 'between') {echo 'display: none;';} ?>" id="date2">
                <input type="submit" value="Filtrer">
            </div>
            <a href="/experiences" class="button">Réinitialiser</a>
        </form>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Site</th>
                <th>Activité</th>
                <th>Date de l'exp.</th>
                <th>Créé le</th>
                <th>Publié</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($experiences as $experience)
                <tr class="clickable-row" data-href="/experiences/{{ $experience->id }}">
                    <td>{{ $experience->title }}</td>
                    <td>{{ $experience->site_name }}</td>
                    <td>{{ $experience->activity->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($experience->date)->format('d/m/Y') }}</td>
                    <td>{{ $experience->created_at->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($experience->published_at)->diffForHumans() }}</td>
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

        document.getElementById('date-period').addEventListener('input', function() {
            document.getElementById('search-form').submit();
        });


        $(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });

    </script>
</html>

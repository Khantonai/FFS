@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="title-container">
    <h1>Bienvenue {{ Auth::user()->pseudo }}</h1>
    <h2>Dashboard</h2>
</div>
<form action="/experiences" method="GET" id="search-form">
    <input type="text" name="search" placeholder="Rechercher..." id="search-field" value="{{ $search }}">
    <select name="activity-select" id="activity-select">
        <option value="">Toutes les activités</option>
        @foreach ($activities as $activity)
                <option value="{{ $activity->name }}" <?php    if ($activity_select && $activity_select == $activity->name) {
                echo 'selected';
            } ?>>{{ $activity->name }}</option>
        @endforeach
    </select>
    <div>
        <select name="date-period" id="date-period">
            <option value="before" <?php if ($date_period && $date_period == 'before') {
    echo 'selected';
} ?>>Avant
            </option>
            <option value="after" <?php if ($date_period && $date_period == 'after') {
    echo 'selected';
} ?>>Après</option>
            <option value="between" <?php if ($date_period && $date_period == 'between') {
    echo 'selected';
} ?>>Entre
            </option>
        </select>
        <input type="date" name="date" value="{{ $date }}" id="date">
        <input type="date" name="date2" value="{{ $date2 }}"
            style="<?php if ($date_period != 'between') {
    echo 'display: none;';
} ?>" id="date2">
        <input type="submit" value="Filtrer">
    </div>
    <a href="/experiences" class="button">Réinitialiser</a>
</form>
<br>
<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Site</th>
            <th>Activité</th>
            <th>Date de l'exp.</th>
            <th>Créé le</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($experiences as $experience)
            <tr class="clickable-row" data-href="{{ route('experiences.show', $experience->id) }}">
                <td>{{ $experience->title }}</td>
                <td>{{ $experience->site_name }}</td>
                <td>{{ $experience->activity->name }}</td>
                <td>{{ \Carbon\Carbon::parse($experience->date)->format('d/m/Y') }}</td>
                <td>{{ $experience->created_at->format('d/m/Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>



<script>
    var searchField = document.getElementById('search-field');

    searchField.addEventListener('focus', function () {
        document.cookie = "searchFieldFocused=true; path=/";
    });

    searchField.addEventListener('blur', function () {
        document.cookie = "searchFieldFocused=false; path=/";
    });

    if (document.cookie.includes('searchFieldFocused=true')) {
        document.getElementById('search-field').focus();
        document.getElementById('search-field').selectionStart = document.getElementById('search-field').value.length;
    }

    document.getElementById('search-field').addEventListener('input', function () {
        document.getElementById('search-form').submit();
    });

    document.getElementById('activity-select').addEventListener('input', function () {
        document.getElementById('search-form').submit();
    });

    document.getElementById('date-period').addEventListener('input', function () {
        document.getElementById('search-form').submit();
    });


    document.addEventListener('DOMContentLoaded', function () {
        var rows = document.querySelectorAll('.clickable-row');

        rows.forEach(function (row) {
            row.addEventListener('click', function () {
                window.location = row.getAttribute('data-href');
                console.log('clicked');
            });
        });
    });



</script>
@endsection
@extends('layouts.app')

@section('title', $experience->title)

@section('style')
<style>

    main {
        width: calc(100% - 460px);
        padding: 40px;
    }

    p {
        margin: 0;
    }

    h1 {

        font-size: 4rem;
    }

    #location {
        display: flex;
        gap: 5px;
    }

    #location h3:first-child::after {
        content: ", ";

    }

    #information {
        width: 300px;
        position: fixed;
        right: 1rem;
        top: 1rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        align-items: center;

    }

    #information > div {
        
        display: flex;
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
        border-radius: 20px;
        background-color: var(--green);
        color: white;
        
    }

    #information span {
        font-weight: bold;
        color: var(--blue);
    }

    #information img {
        width: 100%;
        max-height: 600px;
        border-radius: 10px;
    }

    #information h2 {
        margin: 0;
        text-align: center;
    }

    </style>
@endsection

@section('content')
<main>
    <section>
        <h1>{{ $experience->title }}</h1>
        <div id="location">
            <h3>{{ $experience->site_name }}</h3>
            <h3>{{ $experience->place }}</h3>
        </div>
        <p>{{ $experience->description }}</p>
    </section>
    <section id="information">
        <div>
            <h2>Informations</h2>
            <img src="{{ asset('storage/' . $experience->image) }}" alt="">
            <p><span>Activité :</span> {{ $experience->activity->name }}</p>
            <p><span>Date de l'expérience :</span> {{ \Carbon\Carbon::parse($experience->date)->format('d/m/y') }}</p>
            <p><span>Altitude :</span> {{ $experience->distance }}m</p>
            <?php
                switch($experience->priority) {
                    case 1:
                        $priorityText = "Pas d'urgence";
                        break;
                    case 2:
                        $priorityText = "À surveiller";
                        break;
                    case 3:
                        $priorityText = "Urgent";
                        break;
                    case 4:
                        $priorityText = "Dangereux";
                        break;
                    default:
                        $priorityText = "Non défini";
                } ?>
            <p><span>Priorité :</span> {{ $priorityText }}</p>
            <div class="divider"></div>
            <p>Publié le {{ \Carbon\Carbon::parse($experience->published_at)->format('d/m/y') }} à {{ \Carbon\Carbon::parse($experience->published_at)->format('h:m') }}</p>
        </div>
        <a href="{{ route('experiences.index') }}" class="button">Retourner à la liste des expériences</a>
    </section>
</main>
    
@endsection
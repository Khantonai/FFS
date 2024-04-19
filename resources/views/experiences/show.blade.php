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

    </style>
@endsection

@section('content')


<main>
    @if($experience != null && Auth::check())
        <div>
            <div style="display: flex; gap:5px;">
                <p>{{ $experience->first_name }}</p>
                <p>{{ $experience->last_name }}</p>
            </div>
            <p>{{ $experience->email }}</p>
        </div>
    @endif
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
            @if ($experience->published_at)
                <p>Publié le {{ \Carbon\Carbon::parse($experience->published_at)->format('d/m/y') }} à {{ \Carbon\Carbon::parse($experience->published_at)->format('H:i') }}</p>
            @else
                <p>Non publié</p>
            @endif
        </div>
        <a href="{{ route('experiences.index') }}" class="button">Retourner à la liste des expériences</a>
        @auth
            <a href="{{ route('experiences.edit', $experience->id) }}" class="button">Modifier</a>
            <table>
                <thead>
                    <tr>
                        <th>Modifié le</th>
                        <th>Par</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($edits->isEmpty())
                        <tr>
                            <td colspan="2">Aucune modification</td>
                        </tr>
                    @else

                        @foreach ($edits as $edit)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($edit->updated_at)->format('d/m/y à H:i') }}</td>
                                <td>{{ $edit->user->pseudo }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @endauth
    </section>
</main>
    
@endsection
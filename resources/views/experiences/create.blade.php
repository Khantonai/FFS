@extends('layouts.app')

@section('title', 'Soumettre une expérience')

@section('style')
    <style>
        @keyframes slideInFromLeft {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(0);
            }
        }

        body {
            background: #fff;
        }

        header {
            width: calc(50% - 280px);
            padding: 20px;
            /* background-color: var(--red); */
        }

        #notification {
            /* display: none; */
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: var(--grey);
            width: 250px;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #dddddd;
            border-left: 10px solid var(--red);
            transition: all 0.5s;
            font-weight: 700;
            animation: slideInFromLeft 0.5s;
            display: none;
        }

        form {
            display: flex;
        }

        section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: 20px;
            padding: 20px;
            width: 160px;
            height: 160px;
            position: fixed;
            right: 20px;
            transition: all 0.5s;
            background-color: var(--grey);
            gap: 0.5rem;
        }

        section input, section select, section textarea {
            border: 1px solid #dddddd;
            border-radius: 3px;
        }

        section.first-step {
            top: calc((100vh - 600px) * 0.25);
        }

        section.second-step {
            top: calc((100vh - 600px) * 0.5 + 200px);
        }

        section.third-step {
            top: calc((100vh - 600px) * 0.75 + 400px);
        }

        section.active {
            top: 20px;
            right: 50vw;
            transform: translateX(50%);
            width: 400px;
            height: min(600px, calc(100vh - 270px));
            overflow-y: scroll;
            justify-content: flex-start;
        }

        section.active input, section.active select, section.active textarea{
            padding: 6px 12px;
            border-radius: 3px;
            z-index: 999;
        }

        section.active::-webkit-scrollbar {
            width: 10px;
        }
        
        /* Handle */
        section.active::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        /* Handle on hover */
        section.active::-webkit-scrollbar-thumb:hover {
            background: #555; 
        }

        section.active label, section.active h2 {
            opacity: 1;
            height: auto;
            margin: 0.5rem 0;
        }

        section > div {
            display: flex;
            flex-direction: column;
        }

        section label, section h2 {
            opacity: 0;
            height: 0;
            margin: 0;
            transition: all 0.5s;
        }

        section h2 {
            font-family: 'Ubuntu', sans-serif;
            font-weight: 500;
        }

        section label {
            color: var(--red);
            font-weight: 700;
            width: fit-content;
        }



        #resume {
            display: flex;
            flex-direction: column;
        }

        #resume label {
            cursor: pointer;
            font-weight: 500;
        }

        #resume #resume-title{
            font-size: 20px;
            font-weight: 700;
        }

        #resume img {
            width: 100%;
        }

        .hide {
            display: none !important;
        }

        .step-viewer {
            position: absolute;
            display: flex;
            flex-direction: column;
            list-style: none;
            height: calc(100vh - 40px);
            justify-content: space-around;
            right: 260px;
            top: 0px;
        }

        .step-viewer li {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--red);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .step-viewer li.active, .step-viewer li:hover {
            background-color: var(--blue);
        }

        .step-viewer li.done {
            background-color: var(--green);
        }
        
        .form-button {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: 70px;
            width: 420px;
            gap: 1rem;
            display: flex;
            flex-direction: column;
        }

        .nav {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .nav button {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .reset-button {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid #c3e6cb;
            margin-bottom: 1rem;
        }

        .alert-danger ul {
            list-style: none;
            padding: 0;
        }

        .alert-danger li {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid #f5c6cb;
            margin-bottom: 1rem;
        }

        .submit-container {
            position: absolute;
            bottom: 20px;
            right: 50vw;
            transform: translateX(50%);
            width: 400px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        
        
        
    </style>
@endsection

@section('content')
  
    <header>
        <div id="notification">Veuillez remplir tous les champs obligatoires de l'étape <span></span>.</div>
        @if($experience != null && Auth::check())
            <h1>Modifier une expérience</h1>
        @else
            <h1>Soumettre une expérience</h1>
            <p>Ce formulaire vous permet de créer une nouvelle expérience. Veuillez remplir tous les champs requis et cliquer sur le bouton 'Soumettre' lorsque vous avez terminé.</p>        
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if($experience != null && Auth::check())
            <a href="{{ route('users.index') }}" class="button">Retourner au dashboard</a>
        @else
            <a href="{{ route('experiences.index') }}" class="button">Retourner à la liste des expériences</a>
        @endif
    </header>
    <main>
        @if($experience != null && Auth::check())
            <form method="POST" action="{{ route('experiences.update', ['experience' => $experience->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
        @else
            <form method="POST" action="{{ route('experiences.create') }}" enctype="multipart/form-data">
                @csrf
        @endif
            <section class="first-step active">
                <h2>Vos coordonnées</h2>
                <div>
                    <label for="email">Adresse e-mail*</label>
                    <input type="email" name="email" id="email" placeholder="Adresse e-mail"<?php echo ($experience != null && Auth::check()) ? 'value="'.$experience->email.'"' : ''; ?> required>
                </div>
                <div>
                    <label for="first_name">Prénom*</label>
                    <input type="text" name="first_name" id="first_name" placeholder="Prénom" <?php echo ($experience != null && Auth::check()) ? 'value="'.$experience->first_name.'"' : ''; ?> required>
                </div>
                <div>
                    <label for="last_name">Nom*</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Nom" <?php echo ($experience != null && Auth::check()) ? 'value="'.$experience->last_name.'"' : ''; ?> required>
                </div>
            </section>
            <section class="second-step">
                <h2>Informations sur l'expérience</h2>
                <div>
                    <label for="site_name">Nom du site*</label>
                    <input type="text" name="site_name" id="site_name" placeholder="Nom du site" <?php echo ($experience != null && Auth::check()) ? 'value="'.$experience->site_name.'"' : 'disabled'; ?> required>
                </div>
                <div>
                    <label for="place">Lieu*</label>
                    <input type="text" name="place" id="place" placeholder="Lieu" <?php echo ($experience != null && Auth::check()) ? 'value="'.$experience->place.'"' : 'disabled'; ?> required>
                </div>
                <div>
                    <label for="date">Date*</label>
                    <input type="date" name="date" id="date" <?php echo ($experience != null && Auth::check()) ? 'value="'.$experience->date.'"' : 'disabled'; ?> required>
                </div>
                <div>
                    <label for="activity_id">Activité*</label>
                    <select name="activity_id" id="activity_id" required <?php echo ($experience != null && Auth::check()) ? '' : 'disabled'; ?>>
                        <option value="">Choisissez une activité</option>
                        @foreach ($activities as $activity)
                            <option value="{{ $activity->id }}"<?php echo ($experience != null && Auth::check() && $experience->activity_id == $activity->id) ? 'selected' : ''; ?>>{{ $activity->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="distance">Altitude (en mètres)*</label>
                    <input type="number" name="distance" id="distance" placeholder="Altitude" <?php echo ($experience != null && Auth::check()) ? 'value="'.$experience->distance.'"' : 'disabled'; ?> required>
                </div>
                <div>
                    <label for="priority">Priorité</label>
                    <select name="priority" id="priority" <?php echo ($experience != null && Auth::check()) ? '' : 'disabled'; ?>>
                        <option value="1" <?php echo ($experience != null && Auth::check() && $experience->priority == 1) ? 'selected' : ''; ?>>Pas d'urgence</option>
                        <option value="2" <?php echo ($experience != null && Auth::check() && $experience->priority == 2) ? 'selected' : ''; ?>>À surveiller</option>
                        <option value="3" <?php echo ($experience != null && Auth::check() && $experience->priority == 3) ? 'selected' : ''; ?>>Urgent</option>
                        <option value="4" <?php echo ($experience != null && Auth::check() && $experience->priority == 4) ? 'selected' : ''; ?>>Dangereux</option>
                    </select>
                </div>
            </section>
            <section class="third-step">
                <h2>Décrivez en détails l'expérience</h2>
                <div>
                    <label for="title">Titre*</label>
                    <input type="text" name="title" id="title" placeholder="Titre" <?php echo ($experience != null && Auth::check()) ? 'value="'.$experience->title.'"' : 'disabled'; ?>>
                </div>

                <div>
                    <label for="description">Description*</label>
                    @if($experience != null && Auth::check())
                        <textarea name="description" id="description" placeholder="Description">{{ $experience->description }}</textarea>
                    @else
                        <textarea name="description" id="description" placeholder="Description" disabled></textarea>
                    @endif
                </div>

                <div>
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/gif, image/bmp, image/svg+xml, image/webp, image/heif, image/heic" <?php echo ($experience != null && Auth::check()) ? '' : 'disabled'; ?>>
                </div>
            </section>
            <section id="resume" class="hide">
                <h2>Résumé</h2>
                
                <label id="resume-title" for="title" class="third-step"></label>
                
                <div style="flex-direction: row; gap: 5px; align-items: center;">
                    <label id="resume-site_name" for="site_name" class="second-step"></label>
                    <label id="resume-place" for="place" class="second-step"></label>
                </div>
                <label id="resume-date" for="date" class="second-step"></label>
                <label id="resume-activity_id" for="activity_id" class="second-step"></label>
                <label id="resume-distance" for="distance" class="second-step"></label>
                <label id="resume-priority" for="priority" class="second-step"></label>
                
                <label id="resume-description" for="description" class="third-step"></label>
                @if($experience != null && Auth::check() && $experience->image)
                    <label id="resume-image" for="image" class="third-step"><img src="{{ $experience->image }}" alt=""></label>
                @else
                    <label id="resume-image" for="image" class="third-step">Pas d'image renseignée</label>
                @endif
                
                <label id="resume-email" for="email" class="first-step"></label>
                <div style="flex-direction: row; gap: 5px; align-items: center;">
                    <label id="resume-first_name" for="first_name" class="first-step"></label>
                    <label id="resume-last_name" for="last_name" class="first-step"></label>
                </div>
            </section>
            <div class="submit-container">
                @if($experience != null && Auth::check())
                    <input type="submit" value="Mettre à jour l'expérience">
                    @if($experience != null && Auth::check())
                        <button type="submit" name="published" value="published">Publier</button>
                    @endif
                @else
                    <input type="submit" value="Soumettre l'expérience" class="submit-exp no-click" disabled>
                @endif
            </div>
        </form>
        <ul class="step-viewer">
            <li class="first-step active">1</li>
            <li class="second-step">2</li>
            <li class="third-step">3</li>
        </ul>
        <div class="form-button">
            <div class="nav">
                <button class="prev no-click">
                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12H20M4 12L8 8M4 12L8 16" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                </button>
                <button class="next">
                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12H20M20 12L16 8M20 12L16 16" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                </button>
            </div>
            <div style="border-top: 1px solid #000; width: 100%;"></div>
            <div class="reset-button">
                <button class="reset">Réinitialiser cette étape</button>
                <button class="reset-all">Tout réinitialiser</button>
            </div>
            <div style="border-top: 1px solid #000; width: 100%;"></div>
        </div>
    </main>
   
    <script>
        // Resume builder =====================================
        const email = document.getElementById('email');
        const first_name = document.getElementById('first_name');
        const last_name = document.getElementById('last_name');
        const site_name = document.getElementById('site_name');
        const place = document.getElementById('place');
        const date = document.getElementById('date');
        const activity_id = document.getElementById('activity_id');
        const distance = document.getElementById('distance');
        const priority = document.getElementById('priority');
        const title = document.getElementById('title');
        const description = document.getElementById('description');
        const image = document.getElementById('image');
        const resumeEmail = document.getElementById('resume-email');
        const resumeFirstName = document.getElementById('resume-first_name');
        const resumeLastName = document.getElementById('resume-last_name');
        const resumeSiteName = document.getElementById('resume-site_name');
        const resumePlace = document.getElementById('resume-place');
        const resumeDate = document.getElementById('resume-date');
        const resumeActivityId = document.getElementById('resume-activity_id');
        const resumeDistance = document.getElementById('resume-distance');
        const resumePriority = document.getElementById('resume-priority');
        const resumeTitle = document.getElementById('resume-title');
        const resumeDescription = document.getElementById('resume-description');
        const resumeImage = document.querySelector('#resume-image');

        
        

        email.addEventListener('input', function() {
            resumeEmail.textContent = email.value;
        });

        first_name.addEventListener('input', function() {
            resumeFirstName.textContent = first_name.value;
        });

        last_name.addEventListener('input', function() {
            resumeLastName.textContent = last_name.value;
        });

        site_name.addEventListener('input', function() {
            resumeSiteName.textContent = "à " + site_name.value + ", ";
        });

        place.addEventListener('input', function() {
            resumePlace.textContent = place.value;
        });

        date.addEventListener('input', function() {
            let dateObj = new Date(date.value);
            let day = String(dateObj.getDate()).padStart(2, '0');
            let month = String(dateObj.getMonth() + 1).padStart(2, '0');
            let year = dateObj.getFullYear();

            resumeDate.textContent = `le ${day}/${month}/${year}`;
        });

        activity_id.addEventListener('input', function() {
            resumeActivityId.textContent = "Activité : " + activity_id.options[activity_id.selectedIndex].text;
        });

        distance.addEventListener('input', function() {
            resumeDistance.textContent = "Altitude : " + distance.value;
        });

        priority.addEventListener('input', function() {
            resumePriority.textContent = "Priorité : " + priority.options[priority.selectedIndex].text;
        });

        title.addEventListener('input', function() {
            resumeTitle.textContent = title.value;
        });

        description.addEventListener('input', function() {
            resumeDescription.textContent = "Description : " + description.value;
        });

        image.addEventListener('change', function() {
            let file = this.files[0];
            let reader = new FileReader();

            reader.onloadend = function() {
                resumeImage.innerHTML = '<img src="' + reader.result + '" alt=""/>';
            }

            reader.readAsDataURL(file);
        });

        <?php 
            if($experience != null && Auth::check()) {
                echo 'resumeEmail.textContent = "'.addslashes($experience->email).'";';
                echo 'resumeFirstName.textContent = "'.addslashes($experience->first_name).'";';
                echo 'resumeLastName.textContent = "'.addslashes($experience->last_name).'";';
                echo 'resumeSiteName.textContent = "'.addslashes($experience->site_name).'";';
                echo 'resumePlace.textContent = "'.addslashes($experience->place).'";';
                echo 'resumeDate.textContent = "'.\Carbon\Carbon::parse($experience->date)->format('d/m/Y').'";';
                echo 'resumeActivityId.textContent = "'.addslashes($experience->activity->name).'";';
                echo 'resumeDistance.textContent = "'.addslashes($experience->distance).'";';
                echo 'resumePriority.textContent = "'.addslashes($experience->priority == 1 ? "Pas d'urgence" : ($experience->priority == 2 ? "À surveiller" : ($experience->priority == 3 ? "Urgent" : ($experience->priority == 4 ? "Dangereux" : "Non identifié"))) ).'";';
                echo 'resumeTitle.textContent = "'.addslashes($experience->title).'";';
                echo 'resumeDescription.textContent = "'.addslashes(str_replace(array("\r", "\n"), '', $experience->description)).'";';
                if ($experience->image) {
                    echo 'resumeImage.innerHTML = "<img src=\''. asset("storage/" . addslashes($experience->image)) .'\'>";';
                }
            }

        ?>

        //=============================================


        var isShownNotification = false;
        

        document.querySelectorAll(".first-step").forEach(function(button) {
            button.addEventListener('click', function() {
                document.querySelector("section.first-step").classList.add('active');
                document.querySelector("section.second-step").classList.remove('active');
                document.querySelector("section.third-step").classList.remove('active');

                document.querySelector(".step-viewer li:first-child").classList.replace('done', 'active');
                document.querySelector(".step-viewer li:nth-child(2)").classList.remove('active');
                document.querySelector(".step-viewer li:nth-child(2)").classList.remove('done');
                document.querySelector(".step-viewer li:last-child").classList.remove('active');
                document.querySelector(".step-viewer li:last-child").classList.remove('done');

                document.querySelector("#notification").style.display = 'none';

                document.querySelector(".prev").classList.add("no-click");
                document.querySelector(".next").classList.remove("no-click");
                try {
                    document.querySelector(".submit-exp").classList.add("no-click");
                    document.querySelector(".submit-exp").disabled = true; 
                } catch (error) {}

                document.querySelector("#resume").classList.replace('active', 'hide');
            });
        });

        document.querySelectorAll(".second-step").forEach(function(button) {
            button.addEventListener('click', function() {
                if (email.value && first_name.value && last_name.value) {
                    document.querySelector("section.first-step").classList.remove('active');
                    document.querySelector("section.second-step").classList.add('active');
                    document.querySelector("section.third-step").classList.remove('active');

                    document.querySelector(".step-viewer li:first-child").classList.replace('active', 'done');
                    document.querySelector(".step-viewer li:nth-child(2)").classList.add('active');
                    document.querySelector(".step-viewer li:nth-child(2)").classList.remove('done');
                    document.querySelector(".step-viewer li:last-child").classList.remove('active');
                    document.querySelector(".step-viewer li:last-child").classList.remove('done');
                    document.querySelector("#notification").style.display = 'none';

                    document.querySelector(".prev").classList.remove("no-click");
                    document.querySelector(".next").classList.remove("no-click");
                    try {
                        document.querySelector(".submit-exp").classList.add("no-click");
                        document.querySelector(".submit-exp").disabled = true; 
                    } catch (error) {}

                    document.querySelector("#resume").classList.replace('active', 'hide');

                }
                else {
                    document.querySelector("#notification").style.display = 'block';
                    document.querySelector("#notification span").textContent = '1';
                    if (!isShownNotification) {
                        setTimeout(function() {
                            document.querySelector("#notification").style.display = 'none';
                            isShownNotification = false;
                        }, 5000);
                    }
                    isShownNotification = true;
                }
            });
        });

        document.querySelectorAll(".third-step").forEach(function(button) {
            button.addEventListener('click', function() {
                if (email.value && first_name.value && last_name.value) {
                    document.querySelector("section.first-step").classList.remove('active');
                    document.querySelector("section.second-step").classList.add('active');
                    document.querySelector("section.third-step").classList.remove('active');
                    document.querySelector(".step-viewer li:last-child").classList.remove('done');

                    document.querySelector(".step-viewer li:first-child").classList.replace('active', 'done');
                    document.querySelector(".step-viewer li:nth-child(2)").classList.add('active');
                    document.querySelector("#notification").style.display = 'none';

                    document.querySelector(".prev").classList.remove("no-click");
                    document.querySelector(".next").classList.remove("no-click");
                    try {
                        document.querySelector(".submit-exp").classList.add("no-click");
                        document.querySelector(".submit-exp").disabled = true; 
                    } catch (error) {}

                    if (site_name.value && place.value && date.value && activity_id.value && distance.value && priority.value) {
                        document.querySelector("section.first-step").classList.remove('active');
                        document.querySelector("section.second-step").classList.remove('active');
                        document.querySelector("section.third-step").classList.add('active');

                        document.querySelector(".step-viewer li:first-child").classList.replace('active', 'done');
                        document.querySelector(".step-viewer li:nth-child(2)").classList.replace('active', 'done');
                        document.querySelector(".step-viewer li:last-child").classList.add('active');
                        document.querySelector("#notification").style.display = 'none';
                        
                        document.querySelector("#resume").classList.replace('active', 'hide');

                    }
                    else {
                        document.querySelector("#notification").style.display = 'block';
                        document.querySelector("#notification span").textContent = '2';
                        if (!isShownNotification) {
                            setTimeout(function() {
                                document.querySelector("#notification").style.display = 'none';
                                isShownNotification = false;
                            }, 5000);
                        }
                        isShownNotification = true;
                    }

                }
                else {
                    document.querySelector("#notification").style.display = 'block';
                    document.querySelector("#notification span").textContent = '1';
                    if (!isShownNotification) {
                        setTimeout(function() {
                            document.querySelector("#notification").style.display = 'none';
                            isShownNotification = false;
                        }, 5000);
                    }
                    isShownNotification = true;
                }
                

            });
        });

        document.querySelectorAll("#email, #first_name, #last_name").forEach(function(input) {
            input.addEventListener('input', function() {
                if (email.value && first_name.value && last_name.value) {
                    site_name.disabled = false;
                    place.disabled = false;
                    date.disabled = false;
                    activity_id.disabled = false;
                    distance.disabled = false;
                    priority.disabled = false;
                }
                else {
                    site_name.disabled = true;
                    place.disabled = true;
                    date.disabled = true;
                    activity_id.disabled = true;
                    distance.disabled = true;
                    priority.disabled = true;
                }
            });
        });

        document.querySelectorAll("#site_name, #place, #date, #activity_id, #distance, #priority").forEach(function(input) {
            input.addEventListener('input', function() {
                if (site_name.value && place.value && date.value && activity_id.value && distance.value && priority.value) {
                    title.disabled = false;
                    description.disabled = false;
                    image.disabled = false;
                }
                else {
                    title.disabled = true;
                    description.disabled = true;
                    image.disabled = true;
                }
            });
        });

        // Button action ==============================

        document.querySelector(".prev").addEventListener('click', function() {
            if (document.querySelector("section.second-step").classList.contains('active')) {
                document.querySelector("section.first-step").click();
            }
            else if (document.querySelector("section.third-step").classList.contains('active')) {
                document.querySelector("section.second-step").click();
            }
            else if (document.querySelector("#resume").classList.contains('active')) {
                document.querySelector("section.third-step").click();
                document.querySelector(".step-viewer li:last-child").classList.replace('done', 'active');
            }
        });

        document.querySelector(".next").addEventListener('click', function() {
            if (document.querySelector("section.first-step").classList.contains('active')) {
                document.querySelector("section.second-step").click();
            }
            else if (document.querySelector("section.second-step").classList.contains('active')) {
                document.querySelector("section.third-step").click();
            }
            else if (title.value && description.value) {
                document.querySelector("section.third-step").classList.replace('active', 'done');
                document.querySelector("#resume").classList.replace('hide', 'active');
                document.querySelector(".next").classList.add("no-click");
                try {
                    document.querySelector(".submit-exp").classList.remove("no-click");
                    document.querySelector(".submit-exp").disabled = false;
                } catch (error) { 
                }
                document.querySelector(".step-viewer li:last-child").classList.replace('active', 'done');

                
            }
        });

        

        document.querySelector(".reset").addEventListener('click', function() {
            if (document.querySelector("section.active").id != "resume") {
                document.querySelector("section.active").querySelectorAll('input, select:not(#priority), textarea').forEach(function(input) {
                    input.value = '';
                    if (!email.value && !first_name.value && !last_name.value) {
                        site_name.disabled = true;
                        place.disabled = true;
                        date.disabled = true;
                        activity_id.disabled = true;
                        distance.disabled = true;
                        priority.disabled = true;
                    }
    
                    if (!site_name.value && !place.value && !date.value && !activity_id.value && !distance.value && !priority.value) {
                        title.disabled = true;
                        description.disabled = true;
                        image.disabled = true;
                    }
                });
            }
        });

        document.querySelector(".reset-all").addEventListener('click', function() {
            window.location.reload();
        });
        window.onload = function() {
            let today = new Date().toISOString().split('T')[0];
            document.getElementById('date').setAttribute('max', today);
        }
    </script>

@endsection
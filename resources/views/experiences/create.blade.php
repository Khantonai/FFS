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
            height: min(600px, calc(100vh - 80px));
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
            margin-top: 1rem;
        }

        #resume label {
            cursor: pointer;
            font-weight: 500;
        }

        #resume #resume-title{
            font-size: 20px;
            font-weight: 700;
        }

        #resume-site_name::after {
            content: ',';
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
            bottom: 20px;
            width: 420px;
            gap: 1rem;
            display: flex;
            flex-direction: column;
        }

        .nav {
            display: flex;
            justify-content: space-between;
        }

        .reset-button {
            display: flex;
            justify-content: center;
            gap: 1rem;
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

        
        
        
        
    </style>
@endsection

@section('content')
    <header>
        <div id="notification">Veuillez remplir tous les champs obligatoires de l'étape <span></span>.</div>
        <h1>Soumettre une expérience</h1>
        <p>Ce formulaire vous permet de créer une nouvelle expérience. Veuillez remplir tous les champs requis et cliquer sur le bouton 'Soumettre' lorsque vous avez terminé.</p>        @if(session('success'))
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
        <a href="{{ route('experiences.index') }}" class="button">Retourner à la liste des expériences</a>
    </header>
    <main>
        <form method="POST" action="{{ route('experiences.create') }}">
            @csrf
            <section class="first-step active">
                <h2>Vos coordonnées</h2>
                <div>
                    <label for="email">Adresse e-mail*</label>
                    <input type="email" name="email" id="email" placeholder="Adresse e-mail" required>
                </div>
                <div>
                    <label for="first_name">Prénom*</label>
                    <input type="text" name="first_name" id="first_name" placeholder="Prénom">
                </div>
                <div>
                    <label for="last_name">Nom*</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Nom" required>
                </div>
            </section>
            <section class="second-step">
                <h2>Informations sur l'expérience</h2>
                <div>
                    <label for="site_name">Nom du site*</label>
                    <input type="text" name="site_name" id="site_name" placeholder="Nom du site" required disabled>
                </div>
                <div>
                    <label for="place">Lieu*</label>
                    <input type="text" name="place" id="place" placeholder="Lieu" required disabled>
                </div>
                <div>
                    <label for="date">Date*</label>
                    <input type="date" name="date" id="date" required disabled>
                </div>
                <div>
                    <label for="activity_id">Activité*</label>
                    <select name="activity_id" id="activity_id" required disabled>
                        <option value="">Choisissez une activité</option>
                        @foreach ($activities as $activity)
                            <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="distance">Altitude*</label>
                    <input type="number" name="distance" id="distance" placeholder="Altitude" required disabled>
                </div>
                <div>
                    <label for="priority">Priorité</label>
                    <select name="priority" id="priority" disabled>
                        <option value="1">Pas d'urgence</option>
                        <option value="2">À surveiller</option>
                        <option value="3">Urgent</option>
                        <option value="4">Dangereux</option>
                    </select>
                </div>
            </section>
            <section class="third-step">
                <h2>Décrivez en détails l'expérience</h2>
                <div>
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" placeholder="Titre" disabled>
                </div>

                <div>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" placeholder="Description" disabled></textarea>
                </div>

                <div>
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/gif, image/bmp, image/svg+xml, image/webp, image/heif, image/heic" disabled>
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
                <label id="resume-image" for="image" class="third-step">Pas d'image renseignée</label>
                
                <label id="resume-email" for="email" class="first-step"></label>
                <div style="flex-direction: row; gap: 5px; align-items: center;">
                    <label id="resume-first_name" for="first_name" class="first-step"></label>
                    <label id="resume-last_name" for="last_name" class="first-step"></label>
                </div>

                <input type="submit" value="Soumettre l'expérience">
            </section>
        </form>
        <ul class="step-viewer">
            <li class="first-step active">1</li>
            <li class="second-step">2</li>
            <li class="third-step">3</li>
        </ul>
        <div class="form-button">
            <div class="nav">
                <button class="prev">Précédent</button>
                <button class="next">Suivant</button>
            </div>
            <div class="reset-button">
                <button class="reset">Réinitialiser cette étape</button>
                <button class="reset-all">Tout réinitialiser</button>
            </div>
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
            resumeSiteName.textContent = site_name.value;
        });

        place.addEventListener('input', function() {
            resumePlace.textContent = place.value;
        });

        date.addEventListener('input', function() {
            let dateObj = new Date(date.value);
            let day = String(dateObj.getDate()).padStart(2, '0');
            let month = String(dateObj.getMonth() + 1).padStart(2, '0');
            let year = dateObj.getFullYear();

            resumeDate.textContent = `${day}/${month}/${year}`;
        });

        activity_id.addEventListener('input', function() {
            resumeActivityId.textContent = activity_id.options[activity_id.selectedIndex].text;
        });

        distance.addEventListener('input', function() {
            resumeDistance.textContent = distance.value;
        });

        priority.addEventListener('input', function() {
            resumePriority.textContent = priority.options[priority.selectedIndex].text;
        });

        title.addEventListener('input', function() {
            resumeTitle.textContent = title.value;
        });

        description.addEventListener('input', function() {
            resumeDescription.textContent = description.value;
        });

        image.addEventListener('change', function() {
            let file = this.files[0];
            let reader = new FileReader();

            reader.onloadend = function() {
                resumeImage.innerHTML = '<img src="' + reader.result + '" alt=""/>';
            }

            reader.readAsDataURL(file);
        });

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

                document.querySelector("#notification").style.display = 'none';

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
                    document.querySelector("#notification").style.display = 'none';

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

                    document.querySelector(".step-viewer li:first-child").classList.replace('active', 'done');
                    document.querySelector(".step-viewer li:nth-child(2)").classList.add('active');
                    document.querySelector("#notification").style.display = 'none';

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
                
            }
        });

        

        document.querySelector(".reset").addEventListener('click', function() {
            console.log(document.querySelector("section.active"))
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
        });

        document.querySelector(".reset-all").addEventListener('click', function() {
            window.location.reload();
        });
    </script>

@endsection
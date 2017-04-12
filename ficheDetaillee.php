<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Résultat</title>
        <link rel="stylesheet" href="CSS/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>

    <body>
        <!--Formulaire de recherche-->
        <form class="form-inline" id="formulaire" action="resultats.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="film">Titre du film</label></br>
                <input type="text" class="form-control" id="film" placeholder="film" name="film">
            </div></br></br>
            <button type="submit" class="btn btn-primary">Recherche</button>
        </form>
        <p id="idfilm"></p>
        <p id="titre"></p>
        <p id="synopsis"></p>
        <p id="punchline"></p>
        <div>Genres : <p id="genres" style="display: inline;"></p></div></br>
        <p id="langue"></p>
        <p id="dateDeSortie"></p>
        <p id="PhotoRealisateur"></p>
        <p id="realisateur"></p>
        <p id="acteurs"></p>
        <p id="affiche"></p></br>
        <p>Acteurs : </p></br>
        <p id="photoActeurs"></p>
        <P id="bandeAnnonce"></p>
        

        <script>
            
            //Recupération de l'ID du film sur la base d'une recherche sur le titre du film
            var settings = {
                "async": true,
                "crossDomain": true,
                "url": "https://api.themoviedb.org/3/search/movie?api_key=e8a06e24fc3024fae50dfc6aa6e37d40&query=<?= $_GET['film'] ?>",
                "method": "GET",
                "headers": {},
                "data": "{}"
            }
            $.ajax(settings).done(function(response) {
                var idFilm = response.results[0].id;

                //Recherche des premières infos (Id film, titre, synopsis, punchline, budget, affiche, langhe et date de sortie)
                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "https://api.themoviedb.org/3/movie/"+idFilm+"?language=FR&api_key=e8a06e24fc3024fae50dfc6aa6e37d40",
                    "method": "GET",
                    "headers": {},
                    "data": "{}"
                }

                $.ajax(settings).done(function(responseSupp) {

                    $("#idfilm").append("ID : " + idFilm);              
                    $("#titre").append("Titre : " + responseSupp.original_title);
                    $("#synopsis").append("Synopsis : " + responseSupp.overview);
                    if(typeof responseSupp.tagline != "undefined"){
                        $("#punchline").append("Punch line : " + responseSupp.tagline);
                        }
                    $("#budget").append("Budget : " + responseSupp.budget);
                    $("#affiche").append("<img src=https://image.tmdb.org/t/p/w300_and_h450_bestv2/" + responseSupp.poster_path + ">");
                    for (var i in responseSupp.genres) {
                        $("#genres").append(" " + responseSupp.genres[i].name);
                    }
                    $("#langue").append("Langue originale : " + responseSupp.spoken_languages[0].name);
                    $("#dateDeSortie").append("Date de sortie : " + responseSupp.release_date);
                });

                // Recherche des noms et photos des cinq premiers acteurs ainsi que le réalisateur
                var settings = {
                "async": true,
                "crossDomain": true,
                "url": "https://api.themoviedb.org/3/movie/" + idFilm + "/credits?api_key=e8a06e24fc3024fae50dfc6aa6e37d40",
                "method": "GET",
                "headers": {},
                "data": "{}"
                }
                $.ajax(settings).done(function(responseActors) {
                    // Acteurs
                    for (i = 0; i<6; i++) {
                    $("#photoActeurs").append("<img src=https://image.tmdb.org/t/p/w132_and_h132_bestv2/"  + responseActors.cast[i].profile_path + " style='border-radius: 50%;'><em style='width: 140px;display: inline-block;'>" + responseActors.cast[i].name + " </em>");
                    }
                    // Réalisateur
                    for (var i in responseActors.crew) {
                            if(responseActors.crew[i].job == "Director"){
                            $("#realisateur").append("Réalisateur : " + responseActors.crew[i].name);
                            $("#PhotoRealisateur").append("<img src=https://image.tmdb.org/t/p/w132_and_h132_bestv2/"  + responseActors.crew[i].profile_path + " style='border-radius: 50%;'>");
                            }
                    }
                });
                // Recherche de la bande annonce
                var settings = {
                "async": true,
                "crossDomain": true,
                "url": "https://api.themoviedb.org/3/movie/" + idFilm + "/videos?language=FR&api_key=e8a06e24fc3024fae50dfc6aa6e37d40",
                "method": "GET",
                "headers": {},
                "data": "{}"
                }

                $.ajax(settings).done(function (responseBandeAnnonce) {
                    console.log(responseBandeAnnonce);
                    // Vérification si nous avons la bande annonce
                    if(typeof responseBandeAnnonce.results[0] != "undefined"){
                        var bandeAnnonce = responseBandeAnnonce.results[0].key;
                        $("#bandeAnnonce").append("<iframe width='560' height='315' src=https://www.youtube.com/embed/" + bandeAnnonce + " frameborder='0' allowfullscreen></iframe>");
                    }
                });
            });
            
        </script>
    </body>
</html>
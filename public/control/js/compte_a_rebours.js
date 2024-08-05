function compte_a_rebours(date_fin, stop) {
    // alert('date_fin');
    var x = setInterval(function() {
            // Calculer le temps restant en secondes
            var temps_restant = Math.floor((date_fin - new Date()) / 1000);

            // Vérifier si le compte à rebours est terminé
            if ((temps_restant < 0) & (stop == 0)) {
                var temps_depasse = Math.abs(temps_restant);
                var jours = Math.floor(temps_depasse / (60 * 60 * 24));
                var heures = Math.floor((temps_depasse % (60 * 60 * 24)) / (60 * 60));
                var minutes = Math.floor((temps_depasse % (60 * 60)) / 60);
                var secondes = temps_depasse % 60;
                document.getElementById("compte_a_rebours").innerHTML = jours + " J " + heures + " h " + minutes + " m " + secondes + " s ";
                document.getElementById("compte_a_rebours").style.color = "red"; // Changer la couleur du texte en rouge
                document.getElementById("compte_a_rebours").style.animation = "blink 1.5s infinite"; // Faire clignoter le texte
            } else if ((temps_restant < 0) & (stop == 1)) {
                clearInterval(x);
                document.getElementById("compte_a_rebours").innerHTML = "Compte terminé.";
            } else {

                // Convertir le temps restant en jours, heures, minutes et secondes
                var jours = Math.floor(temps_restant / (60 * 60 * 24));
                var heures = Math.floor((temps_restant % (60 * 60 * 24)) / (60 * 60));
                var minutes = Math.floor((temps_restant % (60 * 60)) / 60);
                var secondes = temps_restant % 60;

                // Afficher le compte à rebours
                document.getElementById("compte_a_rebours").innerHTML = jours + " J " + heures + " h " + minutes + " m " + secondes + " s";
            }
        },
        1000); // Actualiser toutes les secondes
}

function compte_a_rebours_apres_ajout_du_temps(admin_add_timestamp, stop_) {
    // alert('admin_add');
    var x = setInterval(function() {
        // Calculer le temps restant en secondes
        var temps_restant = Math.floor((admin_add_timestamp - new Date()) / 1000);

        // Vérifier si le compte à rebours est terminé
        if ((temps_restant < 0) & (stop_ == 0)) {
            var temps_depasse = Math.abs(temps_restant);
            var jours = Math.floor(temps_depasse / (60 * 60 * 24));
            var heures = Math.floor((temps_depasse % (60 * 60 * 24)) / (60 * 60));
            var minutes = Math.floor((temps_depasse % (60 * 60)) / 60);
            var secondes = temps_depasse % 60;
            document.getElementById("compte_a_rebours").innerHTML = jours + " J " + heures + " h " + minutes + " m " + secondes + " s ";
            document.getElementById("compte_a_rebours").style.color = "red"; // Changer la couleur du texte en rouge
            document.getElementById("compte_a_rebours").style.animation = "blink 1.5s infinite"; // Faire clignoter le texte
        } else if ((temps_restant < 0) & (stop_ == 1)) {
            clearInterval(x);
            document.getElementById("compte_a_rebours").innerHTML = "Compte terminé.";
        } else {

            // Convertir le temps restant en jours, heures, minutes et secondes
            var jours = Math.floor(temps_restant / (60 * 60 * 24));
            var heures = Math.floor((temps_restant % (60 * 60 * 24)) / (60 * 60));
            var minutes = Math.floor((temps_restant % (60 * 60)) / 60);
            var secondes = temps_restant % 60;

            // Afficher le compte à rebours
            document.getElementById("compte_a_rebours").innerHTML = jours + " J " + heures + " h " + minutes + " m " + secondes + " s ";
        }
    }, 1000); // Actualiser toutes les secondes
}

// Fonction pour arrêter le compte à rebours
function stopCompteARebours() {
    // alert('stopCompteARebours');
    clearInterval(x);
}



// Ajouter un événement d'écouteur de clic au bouton pour arrêter le compte à rebours
var boutonStop = document.getElementById("bouton-stop");
boutonStop.addEventListener("click", stopCompteARebours);

function current_time() {
    // alert('current_time');
    // Récupération de l'heure actuelle
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();

    // Conversion en format HH:MM
    if (hours < 10) {
        hours = "0" + hours;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
}
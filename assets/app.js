/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
import './styles/global.scss';

//const $ = require('jquery');
//require('bootstrap');
$(document).ready(function () {
    $('[data-toggle="popover"]').popover();

    //Récupération du bouton retour vers le haut de la page
    var mybutton = document.getElementById("pi-topBtn");
    // Affichage du bouton lorsque l'utilisateur scroll de plus de 20px
    window.onscroll = function () {
        pi_scroll_function()
    };
    function pi_scroll_function() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }
    // Retour en haut de la page après un clic sur le bouton
    function pi_top_function() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }

    //Modification de la couleur de fond des boutons des types d'oeuvres
    var pi_check_logo = document.getElementById("searchType[Logo]");
    var pi_check_illustration = document.getElementById("searchType[Illustration]");
    var pi_check_affiche = document.getElementById("searchType[Affiche]");
    //Pour logo, ajoute ou retire la classe pi-btn-rouge-clicked en fonction de l'état de la checkbox
    function pi_changement_couleur_bouton_logo() {
        if ($(this).is(":checked")) {
            document.getElementById("pi-oeuvre-libelle-Logo").classList.add("pi-btn-rouge-clicked");
        } else {
            document.getElementById("pi-oeuvre-libelle-Logo").classList.remove("pi-btn-rouge-clicked");
        }
    }
    ;
    //Pour illustration, ajoute ou retire la classe pi-btn-rouge-clicked en fonction de l'état de la checkbox
    function pi_changement_couleur_bouton_illustration() {
        if ($(this).is(":checked")) {
            document.getElementById("pi-oeuvre-libelle-Illustration").classList.add("pi-btn-rouge-clicked");
        } else {
            document.getElementById("pi-oeuvre-libelle-Illustration").classList.remove("pi-btn-rouge-clicked");
        }
    }
    ;
    //Pour affiche, ajoute ou retire la classe pi-btn-rouge-clicked en fonction de l'état de la checkbox
    function pi_changement_couleur_bouton_affiche() {
        if ($(this).is(":checked")) {
            document.getElementById("pi-oeuvre-libelle-Affiche").classList.add("pi-btn-rouge-clicked");
        } else {
            document.getElementById("pi-oeuvre-libelle-Affiche").classList.remove("pi-btn-rouge-clicked");
        }
    }
    ;
    //Ajout d'EventListener sur les clics sur les checkbox associées
    pi_check_logo.addEventListener("click", pi_changement_couleur_bouton_logo, false);
    pi_check_illustration.addEventListener("click", pi_changement_couleur_bouton_illustration, false);
    pi_check_affiche.addEventListener("click", pi_changement_couleur_bouton_affiche, false);
})


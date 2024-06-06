// Attendre que le contenu du document soit chargé
document.addEventListener('DOMContentLoaded', function () {
    // Récupérer l'élément du menu burger et les liens de navigation
    const burgerMenu = document.getElementById('burger-menu');
    const navLinks = document.querySelector('header nav ul');

    // Vérifier si les éléments existent
    if (burgerMenu && navLinks) {
        // Ajouter un écouteur d'événement au clic sur le menu burger
        burgerMenu.addEventListener('click', function () {
            // Basculer la classe 'active' sur les liens de navigation pour les afficher/masquer
            navLinks.classList.toggle('active');
        });
    }

    // Vérifier si l'inscription a été réussie à l'aide des attributs de données
    if (document.body.dataset.registrationSuccess === 'true') {
        // Récupérer la modale de succès d'inscription et l'élément de fermeture
        const registrationModal = document.getElementById("registrationSuccessModal");
        const span = registrationModal.getElementsByClassName("close")[0];

        // Vérifier si la modale et l'élément de fermeture existent
        if (registrationModal && span) {
            // Afficher la modale
            registrationModal.style.display = "block";

            // Ajouter un écouteur d'événement au clic sur l'élément de fermeture pour masquer la modale
            span.onclick = function() {
                registrationModal.style.display = "none";
            }

            // Ajouter un écouteur d'événement au clic en dehors de la modale pour masquer la modale
            window.onclick = function(event) {
                if (event.target == registrationModal) {
                    registrationModal.style.display = "none";
                }
            }
        }
    }

    // Vérifier si le pronostic a été réussi à l'aide des attributs de données
    if (document.body.dataset.predictionSuccess === 'true') {
        // Récupérer la modale de succès de pronostic et l'élément de fermeture
        const predictionModal = document.getElementById("predictionSuccessModal");
        const span = predictionModal.getElementsByClassName("close")[0];

        // Vérifier si la modale et l'élément de fermeture existent
        if (predictionModal && span) {
            // Afficher la modale
            predictionModal.style.display = "block";

            // Ajouter un écouteur d'événement au clic sur l'élément de fermeture pour masquer la modale
            span.onclick = function() {
                predictionModal.style.display = "none";
            }

            // Ajouter un écouteur d'événement au clic en dehors de la modale pour masquer la modale
            window.onclick = function(event) {
                if (event.target == predictionModal) {
                    predictionModal.style.display = "none";
                }
            }
        }
    }

    // Validation du formulaire d'inscription
    const registrationForm = document.querySelector('form[action="index.php?route=register"]');
    if (registrationForm) {
        // Ajouter un écouteur d'événement à la soumission du formulaire d'inscription
        registrationForm.addEventListener('submit', function(event) {
            // Récupérer les valeurs des champs mot de passe et confirmation du mot de passe
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            // Vérifier si le mot de passe a au moins 7 caractères
            if (password.length < 7) {
                event.preventDefault(); // Empêcher la soumission du formulaire
                alert('Le mot de passe doit contenir au moins 7 caractères.');
            } else if (password !== confirmPassword) {
                event.preventDefault(); // Empêcher la soumission du formulaire
                alert('Les mots de passe ne correspondent pas.');
            }
        });
    }

    // Vérification du nom d'utilisateur en temps réel
    const usernameInput = document.getElementById('username');
    const usernameError = document.getElementById('username-error');

    // Vérifier si les éléments de saisie du nom d'utilisateur et d'affichage des erreurs existent
    if (usernameInput && usernameError) {
        // Ajouter un écouteur d'événement à la saisie dans le champ du nom d'utilisateur
        usernameInput.addEventListener('input', function() {
            const username = usernameInput.value;
            // Si le nom d'utilisateur n'est pas vide
            if (username.length > 0) {
                // Envoyer une requête fetch pour vérifier si le nom d'utilisateur existe
                fetch(`index.php?route=check-username&username=${encodeURIComponent(username)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Si le nom d'utilisateur existe, afficher l'erreur, sinon la masquer
                        if (data.exists) {
                            usernameError.style.display = 'block';
                        } else {
                            usernameError.style.display = 'none';
                        }
                    });
            } else {
                // Masquer l'erreur si le champ est vide
                usernameError.style.display = 'none';
            }
        });
    }
});

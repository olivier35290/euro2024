// Attendre que le contenu du document soit chargé
document.addEventListener('DOMContentLoaded', function() {
    
    // Fonction pour attacher des écouteurs d'événements aux boutons de suppression de match
    function attachDeleteListeners() {
        // Sélectionner tous les boutons avec la classe 'delete-match-btn' et ajouter un écouteur de clic
        document.querySelectorAll('.delete-match-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Récupérer l'ID du match à partir de l'attribut data-match-id du bouton
                const matchId = this.dataset.matchId;
                // Appeler la fonction deleteMatch avec l'ID du match
                deleteMatch(matchId);
            });
        });
    }

    // Appeler la fonction pour attacher les écouteurs d'événements de suppression
    attachDeleteListeners();

    // Fonction pour supprimer un match
    function deleteMatch(matchId) {
        // Demander confirmation à l'utilisateur avant de supprimer le match
        if (confirm('Êtes-vous sûr de vouloir supprimer ce match ?')) {
            // Envoyer une requête fetch pour supprimer le match par son ID
            fetch(`index.php?route=delete-match&id=${matchId}`, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprimer la ligne du tableau correspondant au match supprimé
                    document.getElementById(`match-${matchId}`).remove();
                    // Mettre à jour le classement des utilisateurs après la suppression réussie
                    updateLeaderboard(data.users);
                } else {
                    alert('Erreur lors de la suppression du match.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la suppression du match.');
            });
        }
    }

    // Fonction pour mettre à jour le classement des utilisateurs
    function updateLeaderboard(users) {
        const leaderboard = document.getElementById('leaderboard');
        if (leaderboard) {
            // Vider le contenu actuel du tableau de classement
            leaderboard.innerHTML = '';
            // Pour chaque utilisateur, ajouter une nouvelle ligne au tableau de classement
            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `<td>${user.username}</td><td>${user.score}</td>`;
                leaderboard.appendChild(row);
            });
        }
    }

    // Fonction pour mettre à jour les informations d'un match
    function updateMatch(match) {
        const matchesTable = document.querySelector('table tbody');
        if (matchesTable) {
            const row = document.getElementById(`match-${match.match_id}`);
            if (row) {
                // Si la ligne du match existe, mettre à jour son contenu
                row.innerHTML = `
                    <td>
                        <img src="${match.team1_flag}" alt="${match.team1_name} flag" width="20">
                        ${match.team1_name} vs 
                        <img src="${match.team2_flag}" alt="${match.team2_name} flag" width="20">
                        ${match.team2_name}
                    </td>
                    <td>${match.match_date}</td>
                    <td>${match.result}</td>
                    <td><button class="delete-match-btn" data-match-id="${match.match_id}">Supprimer</button></td>
                `;
            } else {
                // Si la ligne du match n'existe pas, créer une nouvelle ligne
                const newRow = document.createElement('tr');
                newRow.id = `match-${match.match_id}`;
                newRow.innerHTML = `
                    <td>
                        <img src="${match.team1_flag}" alt="${match.team1_name} flag" width="20">
                        ${match.team1_name} vs 
                        <img src="${match.team2_flag}" alt="${match.team2_name} flag" width="20">
                        ${match.team2_name}
                    </td>
                    <td>${match.match_date}</td>
                    <td>${match.result}</td>
                    <td><button class="delete-match-btn" data-match-id="${match.match_id}">Supprimer</button></td>
                `;
                matchesTable.appendChild(newRow);
            }
            // Ré-attacher les écouteurs d'événements aux nouveaux boutons de suppression
            attachDeleteListeners();
        }
    }

    // Sélectionner le formulaire pour mettre à jour le résultat d'un match
    const matchForm = document.querySelector('form[action="index.php?route=update-match-result"]');
    if (matchForm) {
        // Ajouter un écouteur d'événement pour la soumission du formulaire
        matchForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Empêcher le rechargement de la page
            const formData = new FormData(matchForm); // Créer un FormData à partir du formulaire
            // Envoyer une requête fetch pour mettre à jour le résultat du match
            fetch('index.php?route=update-match-result', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour le match et le classement après une mise à jour réussie
                    updateMatch(data.match);
                    updateLeaderboard(data.users);
                } else {
                    alert('Erreur lors de la mise à jour du résultat du match.');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la mise à jour du résultat du match:', error);
                alert('Erreur lors de la mise à jour du résultat du match.');
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour attacher des écouteurs d'événements aux boutons de suppression
    function attachDeleteListeners() {
        document.querySelectorAll('.delete-match-btn').forEach(button => {
            button.addEventListener('click', function() {
                const matchId = this.dataset.matchId;
                deleteMatch(matchId);
            });
        });
    }

    // Appel initial de la fonction pour attacher les écouteurs
    attachDeleteListeners();

    // Fonction pour supprimer un match
    function deleteMatch(matchId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce match ?')) {
            fetch(`index.php?route=delete-match&id=${matchId}`, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprimer la ligne du tableau après suppression réussie
                    document.getElementById(`match-${matchId}`).remove();
                    // Mettre à jour le classement après suppression réussie
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

    // Fonction pour mettre à jour le tableau du classement
    function updateLeaderboard(users) {
        const leaderboard = document.getElementById('leaderboard');
        if (leaderboard) {
            leaderboard.innerHTML = '';
            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `<td>${user.username}</td><td>${user.score}</td>`;
                leaderboard.appendChild(row);
            });
        }
    }

    // Fonction pour mettre à jour un match dans le tableau
    function updateMatch(match) {
        const matchesTable = document.querySelector('table tbody');
        if (matchesTable) {
            const row = document.getElementById(`match-${match.match_id}`);
            if (row) {
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
            // Réattacher les écouteurs d'événements aux nouveaux boutons de suppression
            attachDeleteListeners();
        }
    }

    // Sélection du formulaire de mise à jour du résultat du match
    const matchForm = document.querySelector('form[action="index.php?route=update-match-result"]');
    if (matchForm) {
        matchForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(matchForm);
            fetch('index.php?route=update-match-result', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour le match modifié et le classement après mise à jour réussie
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

// Sélectionner le formulaire
const form = document.querySelector("form");

if (form) {
    form.addEventListener("submit", function () {
        // Attendre un moment pour que le formulaire soit soumis avant de vider les champs
        setTimeout(() => {
            const inputs = form.querySelectorAll("input");
            inputs.forEach(input => {
                input.value = ""; // Réinitialiser la valeur de chaque champ
            });
        }, 5); // Attendre 10 ms pour s'assurer que la soumission est terminée
    });
}

//--------------------------------Dasbord js----------------------
document.addEventListener('DOMContentLoaded', function() {
    // Chargement initial des utilisateurs
    loadContent('users');

    // Gestion de la navigation
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            // Retirer la classe active de tous les liens
            document.querySelectorAll('nav a').forEach(el => {
                el.classList.remove('bg-gray-100');
            });
            // Ajouter la classe active au lien cliqué
            this.classList.add('bg-gray-100');
            // Charger le contenu
            loadContent(this.dataset.target);
        });
    });
});

function loadContent(section) {
    fetch(`admin_actions_process?action=get_${section}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('content').innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function confirmAction(action, id, type) {
    const modal = document.getElementById('confirmModal');
    const confirmBtn = document.getElementById('confirmBtn');
    modal.classList.remove('hidden');

    confirmBtn.onclick = function() {
        fetch(`admin_actions_process`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=${action}&id=${id}&type=${type}`
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                loadContent(type + 's'); // Recharger la section courante
            }
            closeModal();
        });
    };
}

function closeModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}

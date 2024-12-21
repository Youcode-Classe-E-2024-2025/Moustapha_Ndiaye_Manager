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

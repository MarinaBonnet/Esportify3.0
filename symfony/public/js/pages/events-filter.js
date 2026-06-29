console.log("events-filter chargé");

const select = document.getElementById("sort-events");
const results = document.getElementById("events-results");

if (select && results) {
    select.addEventListener("change", async () => {
        const sort = select.value;

        try {
            const response = await fetch(`/evenement/filter?sort=${sort}`);

            if (!response.ok) {
                throw new Error("Erreur lors du chargement des événements");
            }

            const evenements = await response.json();

            results.replaceChildren();

            evenements.forEach((evenement) => {
                const article = document.createElement("article");
                article.classList.add("event-card");

                const titre = document.createElement("h3");
                titre.textContent = evenement.titre;

                const joueurs = document.createElement("p");
                joueurs.innerHTML = `<i class="fa-solid fa-users"></i> ${evenement.nbPlaces} joueurs`;

                const dateStart = document.createElement("p");
                dateStart.textContent = `Début : ${evenement.dateStart}`;

                const dateEnd = document.createElement("p");
                dateEnd.textContent = `Fin : ${evenement.dateEnd}`;

                const lien = document.createElement("a");
                lien.href = `/evenement/${evenement.id}`;
                lien.textContent = "Voir les détails";
                lien.classList.add("btn-secondary");

                article.append(titre, joueurs, dateStart, dateEnd, lien);
                results.appendChild(article);
            });
        } catch (error) {
            console.error(error);
            results.innerHTML = `<p class="events-page__empty">Impossible de charger les événements.</p>`;
        }
    });
}

console.log("events-filter chargé");

const select = document.getElementById("sort-events");
const results = document.getElementById("events-results");

if (select && results) {
    select.addEventListener("change", async () => {
        console.log("filtre changé");

        const sort = select.value;

        const response = await fetch(`/evenement/filter?sort=${sort}`);
        const evenements = await response.json();

        results.replaceChildren();

        evenements.forEach((evenement) => {
            const article = document.createElement("article");
            article.classList.add("event-card");

            if (evenement.image) {
                const image = document.createElement("img");
                image.src = `/${evenement.image}`;
                image.alt = evenement.titre;
                article.appendChild(image);
            }

            const titre = document.createElement("h2");
            titre.textContent = evenement.titre;

            const joueurs = document.createElement("p");
            joueurs.textContent = `Joueurs : ${evenement.nbPlaces}`;

            const date = document.createElement("p");
            date.textContent = `Début : ${evenement.dateStart}`;

            const organisateur = document.createElement("p");
            organisateur.textContent = `Organisateur : ${evenement.organisateur}`;

            const lien = document.createElement("a");
            lien.href = `/evenement/${evenement.id}`;
            lien.textContent = "Voir l'événement";

            article.appendChild(titre);
            article.appendChild(joueurs);
            article.appendChild(date);
            article.appendChild(organisateur);
            article.appendChild(lien);

            const now = new Date();
            const eventEnd = new Date(evenement.dateEnd);

            if (eventEnd <= now) {
                const classement = document.createElement("a");
                classement.href = `/evenement/${evenement.id}/classement`;
                classement.textContent = "Voir le classement";

                article.appendChild(classement);
            }

            results.appendChild(article);
        });
    });
}

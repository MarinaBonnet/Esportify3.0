class EventModal {
    constructor() {
        this.modal = document.getElementById("event-modal");
        this.body = document.getElementById("event-modal-body");

        this.init();
    }

    init() {
        if (!this.modal || !this.body) {
            return;
        }

        document.addEventListener("click", (event) => {
            const detailButton = event.target.closest(
                "[data-open-event-modal]",
            );
            const closeButton = event.target.closest("[data-close-modal]");

            if (detailButton) {
                this.open(detailButton.dataset.eventId);
            }

            if (closeButton) {
                this.close();
            }
        });

        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape") {
                this.close();
            }
        });
    }

    async open(eventId) {
        this.show();
        this.showLoading();

        try {
            const response = await fetch(`/evenement/${eventId}/details`);
            if (!response.ok) {
                throw new Error("Erreur de chargement");
            }
            const evenement = await response.json();

            this.render(evenement);
        } catch (error) {
            console.error(error);
            this.showError();
        }
    }

    show() {
        this.modal.classList.add("is-open");
        this.modal.setAttribute("aria-hidden", "false");
    }

    close() {
        this.modal.classList.remove("is-open");
        this.modal.setAttribute("aria-hidden", "true");
        this.clear();
    }

    clear() {
        this.body.replaceChildren();
    }

    showLoading() {
        this.clear();

        const loading = document.createElement("p");
        loading.classList.add("event-modal__loading");
        loading.textContent = "Chargement...";

        this.body.appendChild(loading);
    }

    showError() {
        this.clear();

        const error = document.createElement("p");
        error.classList.add("event-modal__error");
        error.textContent = "Impossible de charger les détails de l'événement.";

        this.body.appendChild(error);
    }

    render(evenement) {
        this.clear();

        this.body.append(
            this.createTitle(evenement),
            this.createImage(evenement),
            this.createDescription(evenement),
            this.createInformations(evenement),
            this.createActions(evenement),
        );
    }

    createTitle(evenement) {
        const title = document.createElement("h2");
        title.classList.add("event-modal__title");
        title.textContent = evenement.titre;

        return title;
    }

    createImage(evenement) {
        const fragment = document.createDocumentFragment();

        if (!evenement.image) {
            return fragment;
        }

        const image = document.createElement("img");
        image.classList.add("event-modal__image");
        image.src = evenement.image;
        image.alt = evenement.titre;

        return image;
    }

    createDescription(evenement) {
        const description = document.createElement("p");
        description.classList.add("event-modal__description");
        description.textContent = evenement.description;

        return description;
    }

    createInformations(evenement) {
        const list = document.createElement("ul");
        list.classList.add("event-modal__infos");

        list.append(
            this.createInfo("Joueurs", `${evenement.nbPlaces}`),
            this.createInfo("Organisateur", evenement.organisateur),
            this.createInfo("Début", evenement.dateStart),
            this.createInfo("Fin", evenement.dateEnd),
        );

        return list;
    }

    createInfo(label, value) {
        const item = document.createElement("li");

        const strong = document.createElement("strong");
        strong.textContent = `${label} : `;

        const text = document.createTextNode(value ?? "Non renseigné");

        item.append(strong, text);

        return item;
    }

    createActions(evenement) {
        const actions = document.createElement("div");
        actions.classList.add("event-modal__actions");

        const secondaryActions = document.createElement("div");
        secondaryActions.classList.add("event-modal__actions-secondary");

        const now = new Date();
        const endDate = new Date(evenement.dateEndRaw ?? evenement.dateEnd);

        if (evenement.isAuthenticated) {
            if (endDate > now) {
                const participateButton = document.createElement("a");
                participateButton.href = evenement.participateUrl;
                participateButton.classList.add("btn", "btn--primary");
                participateButton.textContent = "Participer";

                actions.appendChild(participateButton);

                const favoriteButton = document.createElement("button");
                favoriteButton.type = "button";
                favoriteButton.classList.add("btn", "btn--secondary");
                favoriteButton.dataset.eventId = evenement.id;
                favoriteButton.dataset.favoriteEvent = "true";
                favoriteButton.textContent = "☆ Ajouter aux favoris";

                secondaryActions.appendChild(favoriteButton);
            } else {
                const finished = document.createElement("p");
                finished.classList.add("event-modal__notice");
                finished.textContent = "🏁 Cet événement est terminé.";

                actions.appendChild(finished);
            }
        } else {
            const notice = document.createElement("p");
            notice.classList.add("event-modal__notice");
            notice.textContent =
                "Connectez-vous pour participer ou ajouter cet événement à vos favoris.";

            const loginLink = document.createElement("a");
            loginLink.href = "/login";
            loginLink.classList.add("btn", "btn--secondary");
            loginLink.textContent = "Se connecter";

            actions.appendChild(notice);
            secondaryActions.appendChild(loginLink);
        }

        const detailLink = document.createElement("a");
        detailLink.href = `/evenement/${evenement.id}`;
        detailLink.classList.add("btn", "btn--secondary");
        detailLink.textContent = "Voir la page complète";

        secondaryActions.appendChild(detailLink);

        const closeButton = document.createElement("button");
        closeButton.type = "button";
        closeButton.classList.add("btn", "btn--secondary");
        closeButton.textContent = "Fermer";
        closeButton.dataset.closeModal = "true";

        secondaryActions.appendChild(closeButton);
        actions.append(secondaryActions);

        return actions;
    }
}

new EventModal();

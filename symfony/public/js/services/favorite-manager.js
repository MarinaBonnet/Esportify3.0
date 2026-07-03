class FavoriteManager {
    constructor() {
        this.init();
    }

    init() {
        document.addEventListener("click", (event) => {
            const button = event.target.closest("[data-favorite-event]");

            if (!button) {
                return;
            }

            this.toggle(button);
        });
    }

    async toggle(button) {
        const eventId = button.dataset.eventId;

        try {
            button.disabled = true;

            const response = await fetch(`/evenement/${eventId}/favori`, {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            const contentType = response.headers.get("content-type");

            if (!contentType?.includes("application/json")) {
                throw new Error(
                    "Vous devez être connecté pour utiliser les favoris.",
                );
            }

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message);
            }

            this.updateButton(button, data.favorite);
        } catch (error) {
            console.error(error);
            alert(error.message);
        } finally {
            button.disabled = false;
        }
    }

    updateButton(button, isFavorite) {
        button.textContent = isFavorite
            ? "★ Retirer des favoris"
            : "☆ Ajouter aux favoris";

        button.classList.toggle("is-favorite", isFavorite);
    }
}

new FavoriteManager();

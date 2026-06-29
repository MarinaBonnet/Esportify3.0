class Carousel {
    constructor(container) {
        this.container = container;
        this.track = container.querySelector(".games-carousel__track");
        this.prev = container.querySelector(".js-carousel-prev");
        this.next = container.querySelector(".js-carousel-next");

        console.log(this.prev, this.next, this.track);

        if (!this.track || !this.prev || !this.next) {
            return;
        }

        this.bindEvents();
    }

    bindEvents() {
        this.prev.addEventListener("click", () => {
            this.scroll(-1);
        });

        this.next.addEventListener("click", () => {
            this.scroll(1);
        });
    }

    scroll(direction) {
        const card = this.track.querySelector(".games-carousel__item");

        if (!card) {
            return;
        }

        const gap = 16;
        const scrollAmount = card.offsetWidth + gap;

        console.log("scroll", direction, scrollAmount);

        this.track.scrollBy({
            left: direction * scrollAmount,
            behavior: "smooth",
        });
    }
}

document.querySelectorAll(".js-carousel").forEach((container) => {
    new Carousel(container);
});

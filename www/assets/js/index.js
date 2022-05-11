// import Cards from "./assets/js/cards.js";
// import Checker from "./assets/js/checker.js";
import Carousel from "./assets/js/carousel.js";

window.addEventListener("DOMContentLoaded", () => {
  const submitBtn = document.querySelector(".btn-search");

  // const cards = new Cards();
  const carousel = new Carousel();

  carousel.showCarouselInfo();
  // cards.getMoviesExample();

  submitBtn.addEventListener("click", (e) => {
    e.preventDefault();

    // const checker = new Checker();
    checker.verifyInput();
  });
});

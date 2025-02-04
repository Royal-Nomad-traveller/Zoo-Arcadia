document.addEventListener("DOMContentLoaded", function() {
    const carousel  = document.querySelector(".carousel");

    function scrollLeft() {
        if (carousel) {
            carousel.scrollBy({ left: -300, behavior: "smooth"});
        }
    }

    function scrollRight() {
        if(carousel) {
            carousel.scrollBy({ left: 300, behavior: "smooth"});
        }
    }

    document.querySelector(".arrow.left").addEventListener("click", scrollLeft);
    document.querySelector(".arrow.right").addEventListener("click", scrollRight);
});

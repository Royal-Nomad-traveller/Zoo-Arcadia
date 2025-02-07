document.addEventListener("DOMContentLoaded", function () {
    // Animation
    function animateAndRedirect(buttonId, targetPage) {
        const button    = document.getElementById(buttonId);

        if(button) {
            button.addEventListener("click", function (event) {
                event.preventDefault();

                // Animation fondu
                document.body.style.transition  = "opacity 0.8s";
                document.body.style.opacity     = "0";

                setTimeout(function (){
                    window.location.href        = targetPage;
                }, 800);
            })
        }
    }

    // Les boutons la fonction aux boutons avec leur page de destination
    animateAndRedirect("btn-habitat", "habitat.html");
    animateAndRedirect("btn-animaux", "habitat.html");
    animateAndRedirect("btn-services", "services.html");
})
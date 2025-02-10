const animauxParHabitat = {
    savane : [
        { nom: "Bambi", race: "Antilope", image: "../images/img-animaux/savane-animaux/antilope.jpg" },
        { nom: "Rafiki", race: "Babouin", image: "../images/img-animaux/savane-animaux/babouin.jpg" },
        { nom: "Zazou", race: "Calao à bec rouge", image: "../images/img-animaux/savane-animaux/calao-a-bec-rouge.jpg" },
        { nom: "Ecouteur", race: "Élephant", image: "../images/img-animaux/savane-animaux/elephant.jpg" },
        { nom: "La Rose", race: "Flamants", image: "../images/img-animaux/savane-animaux/flamants.jpg" },
        { nom: "Le grand cou", race: "Girafe", image: "../images/img-animaux/savane-animaux/girafe.jpg" },
        { nom: "Black Panther", race: "Guépard", image: "../images/img-animaux/savane-animaux/guepard.jpg" },
        { nom: "Mufasa", race: "Lion d'Afrique", image: "../images/img-animaux/savane-animaux/lion.jpg" }
    ],

    jungle : [
        { nom: "Cocoo", race: "Coati", image: "../images/img-animaux/jungle-animaux/coati.jpg" },
        { nom: "Lému", race: "Lémurien", image: "../images/img-animaux/jungle-animaux/lemurien.jpg" },
        { nom: "Louisse", race: "Ourang-outon", image: "../images/img-animaux/jungle-animaux/ourang-outan.jpg" },
        { nom: "Baloo", race: "Ours", image: "../images/img-animaux/jungle-animaux/ours.jpg" },
        { nom: "Bagheera", race: "Panthère noir", image: "../images/img-animaux/jungle-animaux/panthere-noir.jpg" },
        { nom: "Merveille", race: "Paon", image: "../images/img-animaux/jungle-animaux/paon.jpg" },
        { nom: "Bla-bla", race: "Perroquet", image: "../images/img-animaux/jungle-animaux/perroquet.jpg" },
        { nom: "Le vilain", race: "Python", image: "../images/img-animaux/jungle-animaux/python.jpg" }
    ],

    marais : [
        { nom: "Crocodaïle", race: "Crocodile", image: "../images/img-animaux/marais-animaux/crocodile.jpg" },
        { nom: "Hipom", race: "Hpopotame", image: "../images/img-animaux/marais-animaux/hipopotame.jpg" },
        { nom: "Saladre", race: "Salamandre", image: "../images/img-animaux/marais-animaux/salamandre.jpg" },
        { nom: "Michelangelo", race: "Tortue de marais", image: "../images/img-animaux/marais-animaux/tortue.jpg" }
    ]
};

document.addEventListener("DOMContentLoaded", () => {
    // Les boutons "voir les animaux"
    const buttons   = document.querySelectorAll(".btn-habitat");

    // Contenair animaux
    const animauxContenair      = document.getElementById("animaux-container");
    const titreHabitat          = document.getElementById("titre-habitat");

    buttons.forEach((button, index) => {
        button.addEventListener("click", () => {
            // L'habitat slectionné
            let habitat;
            switch (index) {
                case 0:
                    habitat =   "savane";
                    break;
                case 1:
                    habitat =   "jungle";
                    break;
                case 2:
                    habitat =   "marais";
                    break;
            }

            // Le titre de l'ahabitat 
            titreHabitat.textContent    = `Animaux de la ${habitat.charAt(0).toUpperCase() + habitat.slice(1)}`;

            // Les animaux associés de l'habitat
            const animaux  = animauxParHabitat[habitat];

            // Les cartes 
            animauxContenair.innerHTML = "";
            animaux.forEach(animal => {
                const cardAnimaux = 
                ` <div class="col-md-3">
                    <div class="card habitat-card">
                        <img src="${animal.image}" class="card-img-top" alt="${animal.nom}">
                        <div class="card-body card-animal">
                            <h5 class="card-title">${animal.nom}</h5>
                            <p class="card-text card-animal">${animal.race}</p>
                            <button class="btn btn-habitat voir-details" data-nom="${animal.nom}" data-race="${animal.race}" data-image="${animal.image}">
                                Voir détails
                            </button>
                        </div>
                    </div>
                  </div> `;
                animauxContenair.innerHTML += cardAnimaux;
            });
        });
    });
});




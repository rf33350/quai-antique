$(document).ready(function () {
    const apiKey = "8214e0d8ff9f5db5d193da6c6cef9bea";

    // Remplacez "VOTRE_ADRESSE" par l'adresse précise du restaurant
    const address = "32 Place Monge, 73000 Chambéry";
    const city = extractCityFromAddress(address);

    // Géocodez l'adresse pour obtenir les coordonnées géographiques (latitude et longitude)
    const geocodeUrl = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(address)}&format=json&limit=1`;
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;

    $.ajax({
        url: apiUrl,
        method: "GET",
        success: function (data) {

            const temperature = data.main.temp;
            const humidity = data.main.humidity;

            // Affichez les informations météorologiques sur la page
            const weatherDiv = document.getElementById("weather");
            weatherDiv.innerHTML = `
                <p>Les prévisions météo d'aujourd'hui à ${city}:</p>
                <p>Température : ${temperature} °C</p>
                <p>Humidité : ${humidity} %</p>
            `;

        },
        error: function () {
            // En cas d'erreur, affichez un message d'erreur
            const weatherDiv = document.getElementById("weather");
            weatherDiv.innerHTML = "Impossible de récupérer les prévisions météo pour le moment.";
        }
    });


    $.ajax({
        url: geocodeUrl,
        method: "GET",
        success: function (data) {
            if (data && data.length > 0) {

                // Affichez la carte avec l'adresse précise
                const latitude = data[0].lat;
                const longitude = data[0].lon;
                displayMap(address, latitude, longitude);
            } else {
                const mapDiv = document.getElementById("map");
                mapDiv.innerHTML = "Impossible de géocoder l'adresse. Veuillez vérifier l'adresse saisie.";
            }
        },
        error: function () {
            const mapDiv = document.getElementById("map");
            mapDiv.innerHTML = "Une erreur s'est produite lors du géocodage de l'adresse.";
        }
    });


});



function displayMap(address, latitude, longitude) {
    // Créez une carte Leaflet centrée sur la latitude et la longitude de l'adresse
    const map = L.map('map').setView([latitude, longitude], 13);

    // Ajoutez une couche de tuile OpenStreetMap à la carte
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    // Ajoutez un marqueur pour l'adresse précise
    L.marker([latitude, longitude]).addTo(map).bindPopup(address);
}
function extractCityFromAddress(address) {
    // Recherche de la dernière occurrence du code postal (ici on considère que le code postal est un nombre à 5 chiffres)
    const postalCodeRegex = /\b\d{5}\b/g;
    const postalCodeMatch = address.match(postalCodeRegex);

    if (postalCodeMatch && postalCodeMatch.length > 0) {
        const postalCodeIndex = address.lastIndexOf(postalCodeMatch[postalCodeMatch.length - 1]);

        // Extraire la partie de l'adresse qui suit le code postal (nom de la ville)
        const city = address.slice(postalCodeIndex + postalCodeMatch[postalCodeMatch.length - 1].length + 1).trim();
        return city;
    } else {
        // Si le code postal n'est pas trouvé, renvoyer toute l'adresse
        return address;
    }
}
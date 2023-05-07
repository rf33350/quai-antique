// récupérer le champ "Heure d'arrivée"
/*const reservationFormHours = document.querySelectorAll('.reservationFormHour');*/
const arrivalHourField = document.querySelector('.arrival_hour');

// les choix d'heure pour le service "midi"
const midiChoices = [
    { label: '12h00', value: '12:00:00' },
    { label: '12h15', value: '12:15:00' },
    { label: '12h30', value: '12:30:00' },
    { label: '12h45', value: '12:45:00' },
    { label: '13h00', value: '13:00:00' },
    { label: '13h15', value: '13:15:00' },
    { label: '13h30', value: '13:30:00' },
    { label: '13h45', value: '13:45:00' },
];

// les choix d'heure pour le service "soir"
const soirChoices = [
    { label: '19h30', value: '19:30:00' },
    { label: '19h45', value: '19:45:00' },
    { label: '20h00', value: '20:00:00' },
    { label: '20h15', value: '20:15:00' },
    { label: '20h30', value: '20:30:00' },
    { label: '20h45', value: '20:45:00' },
    { label: '21h00', value: '21:00:00' },
    { label: '21h15', value: '21:15:00' },
];

// ajouter un événement "change" sur le champ "Service"
const serviceField = document.querySelector('.reservationFormService');
serviceField.addEventListener('change', () => {
    // récupérer la valeur sélectionnée dans le champ "Service"
    const serviceValue = serviceField.value;

    // mettre à jour les choix en fonction de la valeur de "Service"
    let choices = [];
    if (serviceValue === 'midi') {
        choices = midiChoices;
    } else if (serviceValue === 'soir') {
        choices = soirChoices;
    }

    // générer les boutons HTML pour les choix d'heure
    const buttons = choices.map(choice => {
        return `<option value="${choice.value}" >
                    <button type="button" value="${choice.value}">${choice.label}</button>
                </option>`;
    });
    // mettre à jour le champ "Heure d'arrivée"
    /*for (let i = 0; i < arrivalHourFields.length; i++) {
        reservationFormHours[i].innerHTML = buttons[i];
    }*/
    arrivalHourField.innerHTML = buttons;
});



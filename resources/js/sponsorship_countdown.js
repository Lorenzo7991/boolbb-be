const daysCounter = document.getElementById('days');
const hoursCounter = document.getElementById('hours');
const minutesCounter = document.getElementById('minutes');
const secondsCounter = document.getElementById('seconds');
const counter = document.getElementById('counter');

//Scaletta valori temporali 
const msPerSecond = 1000;
const msPerMinute = msPerSecond * 60;
const msPerHour = msPerMinute * 60;
const msPerDay = msPerHour * 24;

//Data di scadenza
let expirationDate = counter.dataset.expirationDate;
expirationDate = new Date(expirationDate);
const msToExpiration = expirationDate.getTime();

const countdown = () => {


    // Recupero la data odierna
    const now = new Date();

    const msNow = now.getTime();

    // Calcolo quanti millisecondi mancano da oggi alla scadenza
    const msLeft = msToExpiration - msNow;
    if (msLeft <= 0) {
        clearInterval(interval);
        return;
    }

    // Calcolo quanto manca
    const daysLeft = Math.floor(msLeft / msPerDay);
    const hoursLeft = Math.floor((msLeft % msPerDay) / msPerHour);
    const minutesLeft = Math.floor((msLeft % msPerHour) / msPerMinute);
    const secondsLeft = Math.floor((msLeft % msPerMinute) / msPerSecond);

    // Mostro in pagina
    daysCounter.innerText = String(daysLeft).padStart(2, "0");
    hoursCounter.innerText = String(hoursLeft).padStart(2, "0");
    minutesCounter.innerText = String(minutesLeft).padStart(2, "0");
    secondsCounter.innerText = String(secondsLeft).padStart(2, "0");
}
const interval = setInterval(countdown, 1000)

// Grafico visualizzazioni
const ctx = document.getElementById('myChart');
// const graphType = document.getElementById('graph-type')




// Array di visualizzazioni (Arriva come stringa e tramite JSON.parse lo riconverto in array di oggetti)
let views = JSON.parse(ctx.dataset.views);

const numBars = views.length;
// const backgroundColors = generateRandomColors(numBars);


const daysWithViews = views.reduce((res, view) => {
    if (!res.includes(view.date)) res.push(view.date);
    return res;
}, [])



//! Views per giorno--------------------------
let viewsPerDay = {}
// Trasformo viewsPerDay in un oggetto dove ogni chiave è una data e ha come valore corrispettivo il numero di visualizzazioni di quel giorno
for (let view of views) {
    let date = view.date;
    viewsPerDay[date] = (viewsPerDay[date] || 0) + 1;
}

// Riordino gli elementi dell'oggetto per chiave
viewsPerDay = Object.fromEntries(
    Object.entries(viewsPerDay).sort(([chiaveA], [chiaveB]) => chiaveA.localeCompare(chiaveB))
);


// Funzione per convertire una data da formato americano a italiano
function convertToItalianDate(americanDate) {
    // Dividi la data in parti (anno, mese, giorno)
    const parts = americanDate.split('-');

    // Crea una nuova data utilizzando le parti (mese - 1 perché i mesi sono 0-based in JavaScript)
    const date = new Date(parts[0], parts[1] - 1, parts[2]);

    // Ottieni il giorno, il mese e l'anno dalla data
    const day = date.getDate();
    const month = date.getMonth() + 1; // Aggiungi 1 perché i mesi sono 0-based
    const year = date.getFullYear();

    // Formatta la data nel formato italiano (DD/MM/YYYY)
    var italianDate = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + year;

    return italianDate;
}

// Funzione per convertire le chiavi di un oggetto contenenti date da formato americano a italiano
function convertKeysToItalianDates(object) {
    const convertedObject = {};
    for (var key in object) {
        if (object.hasOwnProperty(key)) {
            const italianDate = convertToItalianDate(key);
            convertedObject[italianDate] = object[key];
        }
    }
    return convertedObject;
}

viewsPerDay = convertKeysToItalianDates(viewsPerDay);
//! Fine views per giorno---------------



// Funzione per contare le views per ogni mese dell'anno
function countViewsPerMonth(views) {
    // Oggetto che conta le views di ogni mese
    const viewsPerMonth = {};

    // Array dei mesi
    const monthNames = [
        "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
        "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"
    ];

    // Inizializzo il conteggio a zero per tutti i mesi
    monthNames.forEach(function (monthName) {
        viewsPerMonth[monthName] = 0;
    });

    // Itero su ogni view
    views.forEach(function (view) {
        // Divido la data in un array che avrà anno, mese, giorno
        const parts = view.date.split('-');
        // La trasformo in un oggetto date 
        const date = new Date(parts[0], parts[1] - 1, parts[2]); // In JavaScript i mesi partono da 0

        // Ottengo il nome del mese dalla data
        const monthName = monthNames[date.getMonth()];

        // Incremento il conteggio per il mese corrispondente
        viewsPerMonth[monthName]++;
    });

    // Trasformo l'oggetto viewsPerMonth in un array di oggetti che avrà chiave month e chiave views
    const result = [];
    for (const monthName in viewsPerMonth) {
        result.push({ month: monthName, views: viewsPerMonth[monthName] });
    }

    return result;
}

// Ottiengo il conteggio delle views per ogni mese
const viewsCountPerMonth = countViewsPerMonth(views);





//! Grafico con visualizzazioni al giorno
// const graph = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: Object.keys(
//             viewsPerDay), // Creo una barra per ogni giorno (chiave nell'oggetto viewsPerDay)
//         datasets: [{
//             label: 'Visualizzazioni al giorno',
//             data: Object.keys(viewsPerDay).map(function (
//                 date
//             ) { // Ad ogni barra assegno il valore delle sue visualizzazioni
//                 return viewsPerDay[date];
//             }),
//             // backgroundColor: backgroundColors,
//             borderWidth: 1
//         }]
//     },
//     options: {
//         layout: {
//             padding: 0 // Da qui modifica il padding del grafico
//         },
//         responsive: true,
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         },
//         // plugins: {
//         //     subtitle: {
//         //         display: true,
//         //         text: 'Custom Chart Subtitle'
//         //     }
//         // }
//     }
// });
//! Fine grafico con visualizzazioni al giorno


const graph = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: viewsCountPerMonth.map(month => {
            return month.month
        }), // Creo una barra per ogni giorno (chiave nell'oggetto viewsPerDay)
        datasets: [{
            label: 'Visualizzazioni al mese',
            data: viewsCountPerMonth.map(month => {
                return month.views
            }),
            borderWidth: 1
        }]
    },
    options: {
        layout: {
            padding: 0 // Da qui modifica il padding del grafico
        },
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        // plugins: {
        //     subtitle: {
        //         display: true,
        //         text: 'Custom Chart Subtitle'
        //     }
        // }
    }
});

// Event Listener per cambiare il tipo di grafico al cambio del valore selezionato dalla select
// graphType.addEventListener('change', () => {
//     graph.config.type = graphType.value;
//     graph.update();
// })
//Highcharts Dokumentation -> https://api.highcharts.com/highcharts/
var drawChartOptions = {
    title: {
        text: 'Kundenfrequenz'
    },
    chart:{
        type: 'column'
    },
    credits: {
        position: {
            align: 'left', 
            x: 10
        }
    },
    xAxis: {
        categories: []
    },
    yAxis: [{
        title: '',
        allowDecimals: false
    }],
    series:[{
        name: '', 
        data: []
        } 
    ] 
}

// Diagramm beim Laden der Seite erstellen
Highcharts.setOptions({colors:['#0ea9ab']});
var barChart = Highcharts.chart('container', drawChartOptions);

const xmlhttp = new XMLHttpRequest();

xmlhttp.onload = function (){
    if(xmlhttp.status === 200){
        dataArray = xmlhttp.response;
        barChart.series[0].update({name: dataArray[0]});
        barChart.xAxis[0].setCategories(dataArray[1]);
        barChart.series[0].setData([parseInt(dataArray[2])]);
        document.getElementById('kundenzahlGesamtFeld').innerHTML = dataArray[3];
    }
}

xmlhttp.responseType = "json";
//Aufruf localhost
// xmlhttp.open('GET', "http://localhost/kfm/phpScripts/kfAktuell.php");
//Aufruf Live-Server
xmlhttp.open('GET', "https://kfm.htl-ottakring.schulwebspace.at/phpScripts/kfAktuell.php");
xmlhttp.send();

const btnKfAktuell = document.getElementById('btnKfAktuell');
const btnKfWoche = document.getElementById('btnKfWoche');
const btnKfSechsTage = document.getElementById('btnKfSechsTage');

// Kundenfrequenz für Heute
btnKfAktuell.addEventListener('click', function(e){
    e.preventDefault();

    xmlhttp.onload = function (){
        if(xmlhttp.status === 200){
            dataArray = xmlhttp.response;
            barChart.xAxis[0].setCategories(dataArray[1]);
            barChart.series[0].setData([parseInt(dataArray[2])]);
            document.getElementById('kundenzahlGesamtFeld').innerHTML = dataArray[3];
        }
    }
    //Aufruf localhost
    // xmlhttp.open('GET', "http://localhost/kfm/phpScripts/kfAktuell.php");
    //Aufruf Live-Server
    xmlhttp.open('GET', "https://kfm.htl-ottakring.schulwebspace.at/phpScripts/kfAktuell.php");
    xmlhttp.send();
})

// Kundenfrequenz für Woche
btnKfWoche.addEventListener('click', function(e){
    e.preventDefault();
    
    xmlhttp.onload = function (){
        if(xmlhttp.status === 200){
            dataArray = xmlhttp.response;
            barChart.series[0].update({data:[parseInt(dataArray[2][0]), parseInt(dataArray[2][1]), parseInt(dataArray[2][2]), parseInt  (dataArray[2][3]), parseInt(dataArray[2][4]), parseInt(dataArray[2][5])]});
            barChart.xAxis[0].update({categories: [dataArray[1][0], dataArray[1][1], dataArray[1][2], dataArray[1][3], dataArray[1][4],  dataArray[1][5]]});
            document.getElementById('kundenzahlGesamtFeld').innerHTML = dataArray[3];
        }
    }
    //Aufruf localhost
    // xmlhttp.open('GET', "http://localhost/kfm/phpScripts/kfWoche.php");
    //Aufruf Live-Server
    xmlhttp.open('GET', "https://kfm.htl-ottakring.schulwebspace.at/phpScripts/kfWoche.php");
    xmlhttp.send();
})

// Kundenfrequenz letzten sechs Tage
btnKfSechsTage.addEventListener('click', function(e){
    e.preventDefault();
    
    xmlhttp.onload = function (){
        dataArray = xmlhttp.response;
        barChart.xAxis[0].update({categories: [
            dataArray[1][0], dataArray[1][1], dataArray[1][2], dataArray[1][3], dataArray[1][4], dataArray[1][5]   
        ]});
        barChart.series[0].update({data:[ 
            parseInt(dataArray[2][0]), parseInt(dataArray[2][1]), parseInt(dataArray[2][2]), parseInt(dataArray[2][3]), parseInt(dataArray[2][4]), parseInt(dataArray[2][5])
        ]});
        document.getElementById('kundenzahlGesamtFeld').innerHTML = dataArray[3];
    }
    // Aufruf localhost
    // xmlhttp.open('GET', "http://localhost/kfm/phpScripts/kfLetztenSechsTage.php");
    // Aufruf Live-Server
    xmlhttp.open('GET', "https://kfm.htl-ottakring.schulwebspace.at/phpScripts/kfLetztenSechsTage.php");
    xmlhttp.send();
})




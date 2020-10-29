<?php

    //Prüft, ob eine aktive Session besteht
    if (isset($_REQUEST['loggedin'])) {
        session_start();
        
    } else {
        // localhost Weiterleitung
        // header('Location: http://localhost/kfm/anmelden.php?notauthorized');

        // Live-Server Weiterleitung
        header('Location: https://kfm.htl-ottakring.schulwebspace.at/anmelden.php?notauthorized');
    }
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <?php require('meta.php');?>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script src="javaScript/chartScript.js" defer></script>
        <title>Simple Statistics Kundenbereich</title>
    </head>
    <body>
        <header class="main-header">
            <a href="index.php"><img class="logo" src="pics/simplestats4.png" alt="Simple Statistics Logo"></a>
            <nav>
                <a class="button" href="anmelden.php?logout">Abmelden</a>
            </nav>
        </header>
        <main class="layout-customer">
            <section class="welcomeHeading">
                <p>Willkommen!</p>
                <p><?= $_SESSION['email']; ?></p>
            </section>
            <header class="zeitraumHeading">
                <h1 class="headingLarge">Kundenfrequenz - Zeitraum wählen</h1>
            </header>
            
            <section class="kfBtns layout-button">
                <button class="button theme-gray sizeFix" id="btnKfAktuell">Heute</button>
                <button class="button theme-gray sizeFix" id="btnKfWoche">Letzte Woche</button>
                <button class="button theme-gray sizeFix" id="btnKfSechsTage">Letzten 6 Tage</button>
            </section>
            <div class="chart" id="container"></div>
            <section class="kundenzahlGesamt">
                <h1>Kundenzahl - Gesamt</h1>
                <p class="kundenzahlGesamtFeld" id="kundenzahlGesamtFeld"></p>
            </section>
        </main>
        <?php require('footer.php');?>
    </body>
</html>
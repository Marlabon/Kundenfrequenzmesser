<?php
    session_start();
    error_reporting(E_ALL);
    // Verbindung localhost
    // include_once 'localhostVerbindung.php';

    // Verbindung Live-Server
    include_once 'liveServerVerbindung.php';
    
    $arrayDatum = [];
    $arrayKundenanzahl = [];
    $geschaeftName = [];
    $kundenzahlSumme = [];
    $email = $_SESSION['email'];

    //Zuordnen des Geschäfts zu angemeldeten Kunden
    $a = "SELECT g.G_ID FROM session s
        INNER JOIN kunde k ON s.K_ID=k.K_ID
        INNER JOIN geschaeft g ON k.K_ID=g.K_ID
        WHERE s.datum = Current_Date AND k.email = '$email'";
    
    $b = $pdo->query($a);
    foreach($b as $row){
        $G_ID = $row['G_ID'];
    }

    //Hole Daten für Geschäft
    $sql = "SELECT g.name, d.datum, d.kanzahl, SUM(d.kanzahl) FROM daten d INNER JOIN geschaeft g ON d.G_ID=g.G_ID WHERE d.datum = current_date() AND g.G_ID = $G_ID";
            
    foreach($pdo->query($sql) as $row){   
        if($row[0]===''){
            print_r('Keine Daten gefunden!');
        }else{
            array_push($geschaeftName, $row['name']);
            array_push($arrayDatum, $row['datum']);
            array_push($arrayKundenanzahl, $row['kanzahl']);
            array_push($kundenzahlSumme, $row['kanzahl']);
        }
    }

    echo json_encode([$geschaeftName, $arrayDatum, $arrayKundenanzahl, $kundenzahlSumme]);
?>
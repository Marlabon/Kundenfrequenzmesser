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

    $a = "SELECT g.G_ID FROM session s
    INNER JOIN kunde k ON s.K_ID=k.K_ID
    INNER JOIN geschaeft g ON k.K_ID=g.K_ID
    WHERE s.datum = Current_Date AND k.email = '$email'";
    
    $b = $pdo->query($a);
    foreach($b as $row){
        $G_ID = $row['G_ID'];
    }

    $letzterMontag = date("Y-m-d", strtotime("last week monday"));
    $letzterSamstag = date("Y-m-d", strtotime("last week saturday"));   

    $sql = "SELECT d.datum, d.kanzahl FROM daten d INNER JOIN geschaeft g ON d.G_ID=g.G_ID WHERE datum BETWEEN '$letzterMontag' AND '$letzterSamstag' AND d.G_ID = $G_ID";

    foreach($pdo->query($sql) as $row){   
        if($row[0]===''){
            print_r('Keine Daten gefunden!');
        }else{
            array_push($arrayDatum, $row['datum']);
            array_push($arrayKundenanzahl, $row['kanzahl']);
        }
    }

    $sql = "SELECT SUM(kanzahl) FROM daten WHERE datum BETWEEN '$letzterMontag' AND '$letzterSamstag' AND G_ID = $G_ID";

        foreach($pdo->query($sql) as $row){   
            if($row[0]===''){
                print_r('Keine Daten gefunden!');
            }else{
                $kundenzahlSumme = $row['SUM(kanzahl)'];
            }
        }

    echo json_encode([$geschaeftName, $arrayDatum, $arrayKundenanzahl, $kundenzahlSumme]);
?>
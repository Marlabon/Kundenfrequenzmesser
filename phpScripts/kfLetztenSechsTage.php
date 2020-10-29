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
    $aktuellesDatum = date("Y-m-d");
    $email = $_SESSION['email'];


    $a = "SELECT g.G_ID FROM session s
    INNER JOIN kunde k ON s.K_ID=k.K_ID
    INNER JOIN geschaeft g ON k.K_ID=g.K_ID
    WHERE s.datum = '$aktuellesDatum' AND k.email = '$email'";
    
    $b = $pdo->query($a);
    foreach($b as $row){
        $G_ID = $row['G_ID'];
    }

    $letzterSonntag = date("Y-m-d", strtotime("last sunday"));
    $sonntag = date("Y-m-d", strtotime("sunday"));
    $endDatum = date("Y-m-d");

    $zeitraumArray = [];

    for($i = 0; $i<6; $i++){
        array_push($zeitraumArray, date("Y-m-d", time()-(24*60*60)*$i));
        
    }
    
    if($key = array_search($letzterSonntag, $zeitraumArray) || array_search($sonntag, $zeitraumArray) !== false){
        $startDatum = date("Y-m-d",time()-(24*60*60)*6);
        
    }else{
        $startDatum = date("Y-m-d", strtotime("-5 days"));
    }

    $sql = "SELECT d.datum, d.kanzahl FROM daten d INNER JOIN geschaeft g ON d.G_ID=g.G_ID WHERE datum BETWEEN '$startDatum' AND '$endDatum' AND d.G_ID = $G_ID";
    
    foreach($pdo->query($sql) as $row){   
        if($row[0]===''){
            print_r('Keine Daten gefunden!');
        }else{
            array_push($arrayDatum, $row['datum']);
            array_push($arrayKundenanzahl, $row['kanzahl']);
        }
    }

    $sql = "SELECT SUM(kanzahl) FROM daten WHERE datum BETWEEN '$startDatum' AND '$endDatum' AND G_ID = $G_ID";

    foreach($pdo->query($sql) as $row){   
        if($row[0]===''){
            print_r('Keine Daten gefunden!');
        }else{
            $kundenzahlSumme = $row['SUM(kanzahl)'];
        }
    }
    
    echo json_encode([$geschaeftName, $arrayDatum, $arrayKundenanzahl, $kundenzahlSumme]);
?>
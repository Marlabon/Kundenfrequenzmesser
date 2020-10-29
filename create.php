<?php 
    // include_once 'phpScripts/localhostVerbindung.php';

    // Verbindung Live-Server
    include_once 'phpScripts/liveServerVerbindung.php';
    
    $vorname = $nachname = $email = $password = $storeName = $storeId = "";
    $vornameErr = $nachnameErr = $emailErr = $passwordErr = "";
    
    function pruefen($userEingabe){
        $userEingabe = trim($userEingabe);
        $userEingabe = stripcslashes($userEingabe);
        $userEingabe = htmlspecialchars($userEingabe);
        return $userEingabe;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(empty($_POST['firstName'])){
          $vornameErr = "Vorname eintragen";
        }else{
            $vorname = pruefen($_POST['firstName']);
        }
        if(empty($_POST['lastName'])){
            $nachnameErr = "Nachname eintragen";
        }else{
            $password = pruefen($_POST['lastName']);
        }
        if(empty($_POST['email'])){
            $emailErr = "E-Mail-Adresse eintragen";
          }else{
              $email = pruefen($_POST['email']);
          }
          if(empty($_POST['password'])){
              $passwordErr = "Passwort eintragen";
          }else{
              $password = pruefen($_POST['password']);
          }

        
        $vorname=$_POST['firstName'];
        $nachname=$_POST['lastName'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $register = $pdo->prepare("INSERT INTO kunde(firstName, lastName, email, password) VALUES (:vname, :nname, :email, :hash)");
        $register->bindParam(":vname", $vorname);
        $register->bindParam(":nname", $nachname);
        $register->bindParam(":email", $email);
        $register->bindParam(":hash", $hash);
        $register->execute();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Benutzer anlgen</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <fieldset>
            <legend>Kunden anlegen:</legend>
            <label class="form-label" for="">Vorname:</label>
            <input type="text" name="firstName" id="" value="<?php echo$vorname; ?>">
            <p class="error"><?php echo $vornameErr?></p>
            <label class="form-label" for="">Nachname:</label>
            <input type="text" name="lastName" id="" value="<?php echo$nachname; ?>">
            <p class="error"><?php echo $nachnameErr?></p>
            <label class="form-label" for="">Email:</label>
            <input type="email" name="email" id="" value="<?php echo$email; ?>">
            <p class="error"><?php echo $emailErr?></p>
            <label class="form-label" for="">Passwort:</label>
            <input type="password" name="password" id="" value="<?php echo$password ?>">
            <p class="error"><?php echo $passwordErr?></p>
            <button type="submit">Kunde anlegen</button>
        </fieldset>
    </form>  
</body>
</html>
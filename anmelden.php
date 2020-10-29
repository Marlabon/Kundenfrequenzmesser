<?php
    session_start();

    if(isset($_REQUEST['logout'])){
        session_destroy();
    }

    // Verbindung localhost
    //include_once 'phpScripts/localhostVerbindung.php';
    
    // Verbindung Live-Server
    include_once 'phpScripts/liveServerVerbindung.php';
    
    $email = $password = "";
    $emailErr = $passwordErr = $accountErr = "";
    
    function pruefen($userEingabe){
        $userEingabe = trim($userEingabe);
        $userEingabe = stripcslashes($userEingabe);
        $userEingabe = htmlspecialchars($userEingabe);
        return $userEingabe;
    }

    //Prüfen, ob aktive Session besteht
    if (isset($_REQUEST['notauthorized'])) {
      $accountErr = 'Bitte anmelden, um in den Kundenbreich zu gelangen!';
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
      if(empty($_POST['email'])){
        $emailErr = "Bitte Ihre E-Mail-Adresse eintragen!";
      }else{
          $email = pruefen($_POST['email']);
      }
      if(empty($_POST['password'])){
          $passwordErr = "Bitte Ihr Passwort eintragen!";
      }else{
          $password = pruefen($_POST['password']);
      }
      
      
      $login = $pdo->prepare("SELECT email, password FROM kunde WHERE email=:email");
      $login->bindParam(':email', $email);
      $login->execute();
        if($login->rowCount() == 1){
          if($row = $login->fetch()){
            $hash = $row["password"];
              if(password_verify($password, $hash)){
                $_SESSION['email'] = $row['email'];
              $email = $row['email'];
              
                $sql = "SELECT K_ID FROM kunde WHERE email = '$email'";
                $K_ID = $pdo->query($sql);
              
                foreach ($K_ID as $row){
                  //Anmeldung des Kunden in Session eintragen
                  $insert = "INSERT INTO session(datum, K_ID) VALUES (Current_Date, $row[K_ID])";
                  $pdo->exec($insert);
                }
              
                //Weiterleitung localhost
                //header('Location: http://localhost/kfm/customer.php?loggedin');
              
                //Weiterleitung Live-Server
                header('Location: https://kfm.htl-ottakring.schulwebspace.at/customer.php?loggedin');
              }else{
                $passwordErr = "Bitte gültiges Passwort eintragen!"; 
              }
          }
        }else{
          $emailErr = "Bitte gültige E-Mail-Adresse eintragen!";
        }
    }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <?php require('meta.php');?>
    <title>Simple Statistics Anmelden</title>
</head>
<body>
  <header class="main-header">
    <a href="index.php">
      <img class="logo" src="pics/simplestats4.png" alt="Simple Statistics Logo">
    </a> 
    <nav>
        <a href="index.php" class="button">Zurück</a>
    </nav>
  </header>
  
    <main class="layout">
      <section class="info">
        <h1 class="headingLarge">Bitte Accountdaten eintragen</h1>
        <p class="accountErr"><?php echo $accountErr?></p>
      </section>

        <form class="layout-formular" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
          <section class="mail">  
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" size="30" value="<?php echo $email;?>">
            <p class="emailErr"><?php echo $emailErr;?></p>
          </section>
          
          <section class="password">
            <label for="password">Passwort:</label>
            <input type="password" id="password" name="password" size="30" value="<?php echo $password;?>">
            <p class="passwordErr"><?php echo $passwordErr;?></p>
          </section>
          
          <button class="button anmeldenBtn" name="login" type="submit">Anmelden</button>
        </form>
        <aside>
            <p class="passwordReset">Passwort vergessen, </p>
            <p>schreiben Sie uns eine Mail:</p>
            <address>
              <a href="mailto:simplestatistics@gmail.com">simplestatistics@gmail.com</a>
            </address>
        </aside>
    </main>
    <?php require('footer.php');?>
</body>
</html>

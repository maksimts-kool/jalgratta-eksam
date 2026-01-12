<?php  
require_once("konf.php");  

$viga = "";

if(isset($_REQUEST["sisestusnupp"])){ 
  $eesnimi = trim($_REQUEST["eesnimi"] ?? "");
  $perekonnanimi = trim($_REQUEST["perekonnanimi"] ?? "");
  
  if(empty($eesnimi) || strlen($eesnimi) < 3) {
    $viga = "Eesnimi peab olema vähemalt 3 tähemärki!";
  } 
  elseif(empty($perekonnanimi) || strlen($perekonnanimi) < 3) {
    $viga = "Perekonnanimi peab olema vähemalt 3 tähemärki!";
  }
  else {
    $kask = $yhendus->prepare(
      "INSERT INTO jalgrattaeksam(eesnimi, perekonnanimi) VALUES (?, ?)"
    ); 
    $kask->bind_param("ss", $eesnimi, $perekonnanimi); 
    $kask->execute(); 
    
    header("Location: $_SERVER[PHP_SELF]?lisatudeesnimi=$eesnimi"); 
    exit(); 
  } 
} 
?>
<!doctype html>
<html>

<head>
    <title>Kasutaja registreerimine</title>
    <style>
    .viga {
        color: red;
        font-weight: bold;
    }

    .edukas {
        color: green;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <h1>Registreerimine</h1>

    <?php 
  if($viga) { 
    echo "<p class='viga'>❌ $viga</p>"; 
  }
  if(isset($_REQUEST["lisatudeesnimi"])) { 
    echo "<p class='edukas'>✓ Kasutaja $_REQUEST[lisatudeesnimi] lisati edukalt!</p>"; 
  } 
  ?>

    <form action="?">
        <dl>
            <dt>Eesnimi:</dt>
            <dd>
                <input type="text" name="eesnimi" minlength="3" required />
                <small>(min 3 tähemärki)</small>
            </dd>

            <dt>Perekonnanimi:</dt>
            <dd>
                <input type="text" name="perekonnanimi" minlength="3" required />
                <small>(min 3 tähemärki)</small>
            </dd>

            <dt>
                <input type="submit" name="sisestusnupp" value="Registreeri" />
            </dt>
        </dl>
    </form>
</body>

</html>
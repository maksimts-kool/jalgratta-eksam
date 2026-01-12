<?php
$lehepealkiri = "Registreerimine";
require_once("konf.php");
require_once("header.php");

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
    
    header("Location: teooriaeksam.php?lisatudeesnimi=$eesnimi"); 
    exit(); 
  } 
}
?>

<div class="container">
    <h1>📝 Registreerimine</h1>

    <?php 
  if($viga) { 
    echo "<div class='viga'>❌ $viga</div>"; 
  }
  if(isset($_REQUEST["lisatudeesnimi"])) { 
    echo "<div class='edukas'>✓ Kasutaja $_REQUEST[lisatudeesnimi] lisati edukalt!</div>"; 
  }
  ?>

    <div class="info">
        <strong>ℹ️ Teave:</strong> Pärast registreerumist suunatakse sind teooriaeksamile.
    </div>

    <form method="POST">
        <dl>
            <dt>👤 Eesnimi</dt>
            <dd>
                <input type="text" name="eesnimi" minlength="3" required placeholder="Näiteks: Jaan" />
                <small>Vähemalt 3 tähemärki</small>
            </dd>

            <dt>👤 Perekonnanimi</dt>
            <dd>
                <input type="text" name="perekonnanimi" minlength="3" required placeholder="Näiteks: Tamm" />
                <small>Vähemalt 3 tähemärki</small>
            </dd>

            <dt>
                <input type="submit" name="sisestusnupp" value="Registreeri" />
            </dt>
        </dl>
    </form>
</div>

<?php require_once("footer.php"); ?>
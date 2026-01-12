<?php
$lehepealkiri = "Registreerimine";
require_once("konf.php");
require_once("funktsioonid.php");
require_once("header.php");

$viga = "";

if(isset($_POST["sisestusnupp"])){ 
  $eesnimi = getPOST("eesnimi");
  $perekonnanimi = getPOST("perekonnanimi");
  
  $validateesnimi = valideeriNimi($eesnimi);
  $validateperekonnanimi = valideeriNimi($perekonnanimi);
  
  if(!$validateesnimi['edukas']) {
    $viga = "Eesnimi: " . $validateesnimi['sõnum'];
  } 
  elseif(!$validateperekonnanimi['edukas']) {
    $viga = "Perekonnanimi: " . $validateperekonnanimi['sõnum'];
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
    echo kuvaTeade('viga', "❌ $viga");
  }
  if(isset($_GET["lisatudeesnimi"])) { 
    echo kuvaTeade('edukas', "✓ Kasutaja " . turvTekst($_GET["lisatudeesnimi"]) . " lisati edukalt!");
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
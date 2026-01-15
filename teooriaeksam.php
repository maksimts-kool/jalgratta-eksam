<?php
$lehepealkiri = "Teooriaeksam";
require_once("konf.php");
require_once("auth.php");
require_once("funktsioonid.php");

nouaSisselogimist('login.php?nouab_sisselogimist=1');

require_once("header.php");

$teade = "";
$viga = "";

if(onPostPäring() && !empty($_POST["teooriatulemus"]) && !empty($_POST["id"])){ 
  if(!onAdmin()) {
    $viga = "Ainult admin saab tulemusi sisestada!";
  } else {
  $tulemus = $_POST["teooriatulemus"];
  $id = (int)$_POST["id"];
  
  $valideeriTulemus = valideeriTeooriaTulemus($tulemus);
  
  if(!$valideeriTulemus['edukas']) {
    $viga = $valideeriTulemus['sõnum'];
  }
  else {
    $kask = $yhendus->prepare(
      "UPDATE jalgrattaeksam SET teooriatulemus=? WHERE id=?"
    ); 
    $kask->bind_param("ii", $tulemus, $id); 
    $kask->execute(); 
    
    $teade = "✓ Tulemus $tulemus sisestatud edukalt!";
    header("Refresh: 2");
  }
  }
}

$kask = $yhendus->prepare(
  "SELECT id, eesnimi, perekonnanimi FROM jalgrattaeksam WHERE teooriatulemus=-1"
); 
$kask->bind_result($id, $eesnimi, $perekonnanimi); 
$kask->execute(); 

$osalejaread = [];
while($kask->fetch()) {
  $osalejaread[] = [
    'id' => $id,
    'eesnimi' => $eesnimi,
    'perekonnanimi' => $perekonnanimi
  ];
}
?>

<div class="container">
    <h1>📚 Teooriaeksam</h1>

    <?php 
  echo kuvaTeade('viga', $viga);
  echo kuvaTeade('edukas', $teade);
  ?>

    <div class="info">
        <strong>ℹ️ Nõue:</strong> Vähemalt <strong>9 punkti 10-st</strong> on vajalik edasi minekuks!
    </div>

    <?php if(empty($osalejaread)) { ?>
    <div class="edukas">
        ✓ Kõik osalejad on teooriaeksamil tulemuse saanud!
    </div>
    <?php } else { ?>

    <table>
        <tr>
            <th>Eesnimi</th>
            <th>Perekonnanimi</th>
            <th>Tulemus (0-10)</th>
            <th>Tegevus</th>
        </tr>

        <?php foreach($osalejaread as $osaleja) { ?>
        <tr>
            <td><?php echo turvTekst($osaleja['eesnimi']); ?></td>
            <td><?php echo turvTekst($osaleja['perekonnanimi']); ?></td>
            <?php if(onAdmin()): ?>
            <td>
                <form method="POST" style="display: flex; gap: 10px;">
                    <input type="hidden" name="id" value="<?php echo $osaleja['id']; ?>" />
                    <input type="number" name="teooriatulemus" min="0" max="10" required style="width: 80px;" />
            </td>
            <td>
                <input type="submit" value="Sisesta" />
                </form>
            </td>
            <?php else: ?>
            <td colspan="2">⏳ Ootel</td>
            <?php endif; ?>
        </tr>
        <?php } ?>
    </table>

    <?php } ?>
</div>

<?php require_once("footer.php"); ?>
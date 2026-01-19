<?php
/*
  Lubade väljastamise leht
  Admin saab väljastada jalgratta lubasid või kustutada osalejaid
*/

$lehepealkiri = "Lubade Väljastus";
require_once("konf.php");
require_once("auth.php");
require_once("funktsioonid.php");

nouaSisselogimist('login.php?nouab_sisselogimist=1');

require_once("header.php");

$teade = "";
$viga = "";

if(onPostPäring() && !empty($_POST["vormistamine_id"])){ 
  if(onAdmin()) {
  $kask = $yhendus->prepare("UPDATE jalgrattaeksam SET luba=1 WHERE id=?"); 
  $kask->bind_param("i", $_POST["vormistamine_id"]); 
  $kask->execute(); 
  $teade = "✓ Luba väljastatud!";
  }
} 

if(onPostPäring() && !empty($_POST["kustuta_id"])){ 
  if(onAdmin()) {
  $kask = $yhendus->prepare("DELETE FROM jalgrattaeksam WHERE id=?"); 
  $kask->bind_param("i", $_POST["kustuta_id"]); 
  $kask->execute(); 
  $teade = "✓ Osaleja kustutatud!";
  }
} 

$kask = $yhendus->prepare(
  "SELECT id, eesnimi, perekonnanimi, teooriatulemus, slaalom, ringtee, t2nav, luba FROM jalgrattaeksam ORDER BY luba DESC"
); 
$kask->bind_result($id, $eesnimi, $perekonnanimi, $teooriatulemus, $slaalom, $ringtee, $t2nav, $luba); 
$kask->execute(); 
?>

<div class="container">
    <h1>📜 Lubade Väljastus</h1>

    <?php 
  echo kuvaTeade('viga', $viga);
  echo kuvaTeade('edukas', $teade);
  ?>

    <table>
        <tr>
            <th>Eesnimi</th>
            <th>Perekonnanimi</th>
            <th>Teooria</th>
            <th>Slaalom</th>
            <th>Ringtee</th>
            <th>Tänavasõit</th>
            <th>Luba</th>
            <th>Tegevused</th>
        </tr>

        <?php while($kask->fetch()) { 
      $voib_lubada = kontrollilubaMögus($teooriatulemus, $slaalom, $ringtee, $t2nav, $luba);
      $luba_link = ".";
      
      if($voib_lubada && onAdmin()) {
        $luba_link = "<form method='POST' style='display:inline;'>" .
                     "<input type='hidden' name='vormistamine_id' value='$id' />" .
                     "<input type='submit' value='📜 Väljasta luba' class='btn btn-info' />" .
                     "</form>";
      } elseif($voib_lubada && !onAdmin()) {
        $luba_link = "<span class='badge badge-warning'>⏳ Valmis</span>";
      } elseif($luba == 1) {
        $luba_link = "<span class='badge badge-success'>✓ Väljastatud</span>";
      }
    ?>
        <tr>
            <td><?php echo turvTekst($eesnimi); ?></td>
            <td><?php echo turvTekst($perekonnanimi); ?></td>
            <td><?php echo ($teooriatulemus == -1) ? "⏳" : "$teooriatulemus/10"; ?></td>
            <td><?php echo asenda($slaalom); ?></td>
            <td><?php echo asenda($ringtee); ?></td>
            <td><?php echo asenda($t2nav); ?></td>
            <td><?php echo $luba_link; ?></td>
            <td>
                <?php if(onAdmin()): ?>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="kustuta_id" value="<?php echo $id; ?>" />
                    <input type="submit" value="🗑️ Kustuta" class="btn btn-danger"
                        onclick="return confirm('Kustuta osaleja?')" />
                </form>
                <?php else: ?>
                -
                <?php endif; ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<?php require_once("footer.php"); ?>
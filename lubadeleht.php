<?php
$lehepealkiri = "Lubade Väljastus";
require_once("konf.php");
require_once("header.php");

$teade = "";
$viga = "";

// Luba väljastamine
if(!empty($_REQUEST["vormistamine_id"])){ 
  $kask = $yhendus->prepare("UPDATE jalgrattaeksam SET luba=1 WHERE id=?"); 
  $kask->bind_param("i", $_REQUEST["vormistamine_id"]); 
  $kask->execute(); 
  $teade = "✓ Luba väljastatud!";
} 

// Kustutamine
if(!empty($_REQUEST["kustuta_id"])){ 
  $kask = $yhendus->prepare("DELETE FROM jalgrattaeksam WHERE id=?"); 
  $kask->bind_param("i", $_REQUEST["kustuta_id"]); 
  $kask->execute(); 
  $teade = "✓ Osaleja kustutatud!";
} 

$kask = $yhendus->prepare(
  "SELECT id, eesnimi, perekonnanimi, teooriatulemus, slaalom, ringtee, t2nav, luba FROM jalgrattaeksam ORDER BY luba DESC"
); 
$kask->bind_result($id, $eesnimi, $perekonnanimi, $teooriatulemus, $slaalom, $ringtee, $t2nav, $luba); 
$kask->execute(); 

function asenda($nr){ 
  if($nr==-1){return "<span class='badge badge-warning'>⏳ Tegemata</span>";} 
  if($nr==1){return "<span class='badge badge-success'>✓ Korras</span>";} 
  if($nr==2){return "<span class='badge badge-danger'>✗ Ebaõnnestunud</span>";}
  return "Tundmatu"; 
}
?>

<div class="container">
    <h1>📜 Lubade Väljastus</h1>

    <?php 
  if($viga) echo "<div class='viga'>$viga</div>"; 
  if($teade) echo "<div class='edukas'>$teade</div>"; 
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
      $voib_lubada = ($teooriatulemus >= 9 && $slaalom == 1 && $ringtee == 1 && $t2nav == 1 && $luba == -1);
      $luba_link = ".";
      
      if($voib_lubada) {
        $luba_link = "<a href='?vormistamine_id=$id' class='btn btn-info'>📜 Väljasta luba</a>";
      } elseif($luba == 1) {
        $luba_link = "<span class='badge badge-success'>✓ Väljastatud</span>";
      }
    ?>
        <tr>
            <td><?php echo htmlspecialchars($eesnimi); ?></td>
            <td><?php echo htmlspecialchars($perekonnanimi); ?></td>
            <td><?php echo ($teooriatulemus == -1) ? "⏳" : "$teooriatulemus/10"; ?></td>
            <td><?php echo asenda($slaalom); ?></td>
            <td><?php echo asenda($ringtee); ?></td>
            <td><?php echo asenda($t2nav); ?></td>
            <td><?php echo $luba_link; ?></td>
            <td>
                <a href="?kustuta_id=<?php echo $id; ?>" class="btn btn-danger"
                    onclick="return confirm('Kustuta osaleja?')">🗑️ Kustuta</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<?php require_once("footer.php"); ?>
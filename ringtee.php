<?php
$lehepealkiri = "Ringtee";
require_once("konf.php");
require_once("header.php");

$teade = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["korras_id"])){ 
  $kask = $yhendus->prepare("UPDATE jalgrattaeksam SET ringtee=1 WHERE id=?"); 
  $kask->bind_param("i", $_POST["korras_id"]); 
  $kask->execute(); 
  $teade = "✓ Tulemus sisestatud!";
} 

if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["vigane_id"])){ 
  $kask = $yhendus->prepare("UPDATE jalgrattaeksam SET ringtee=2 WHERE id=?"); 
  $kask->bind_param("i", $_POST["vigane_id"]); 
  $kask->execute(); 
  $teade = "✓ Tulemus sisestatud!";
} 

$kask = $yhendus->prepare(
  "SELECT id, eesnimi, perekonnanimi FROM jalgrattaeksam WHERE teooriatulemus>=9 AND ringtee=-1"
); 
$kask->bind_result($id, $eesnimi, $perekonnanimi); 
$kask->execute(); 

$osalejaread = [];
while($kask->fetch()) {
  $osalejaread[] = ['id' => $id, 'eesnimi' => $eesnimi, 'perekonnanimi' => $perekonnanimi];
}
?>

<div class="container">
    <h1>🔄 Ringtee</h1>

    <?php if($teade) echo "<div class='edukas'>$teade</div>"; ?>

    <div class="info">
        Kontrollige ringteesõitu ja märkige tulemus.
    </div>

    <?php if(empty($osalejaread)) { ?>
    <div class="edukas">✓ Kõik osalejad on ringteesõidu sooritanud!</div>
    <?php } else { ?>

    <table>
        <tr>
            <th>Eesnimi</th>
            <th>Perekonnanimi</th>
            <th>Tulemus</th>
        </tr>

        <?php foreach($osalejaread as $osaleja) { ?>
        <tr>
            <td><?php echo htmlspecialchars($osaleja['eesnimi']); ?></td>
            <td><?php echo htmlspecialchars($osaleja['perekonnanimi']); ?></td>
            <td>
                <form method="POST" style="display: flex; gap: 10px;">
                    <input type="hidden" name="korras_id" value="<?php echo $osaleja['id']; ?>" />
                    <input type="submit" value="✓ Korras" class="btn btn-info" />
                </form>
                <form method="POST" style="display: flex; gap: 10px;">
                    <input type="hidden" name="vigane_id" value="<?php echo $osaleja['id']; ?>" />
                    <input type="submit" value="✗ Ebaõnnestunud" class="btn btn-danger" />
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <?php } ?>
</div>

<?php require_once("footer.php"); ?>
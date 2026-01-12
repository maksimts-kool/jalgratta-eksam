<?php  
require_once("konf.php");  

$teade = "";
$viga = "";

if(!empty($_REQUEST["teooriatulemus"]) && !empty($_REQUEST["id"])){ 
  $tulemus = (int)$_REQUEST["teooriatulemus"];
  $id = (int)$_REQUEST["id"];
  
  if($tulemus < 0 || $tulemus > 10) {
    $viga = "Tulemus peab olema 0-10!";
  }
  elseif($tulemus < 9) {
    $viga = "Vajalik on vähemalt 9 punkti! Saite ainult $tulemus punkti.";
  }
  else {
    $kask = $yhendus->prepare(
      "UPDATE jalgrattaeksam SET teooriatulemus=? WHERE id=?"
    ); 
    $kask->bind_param("ii", $tulemus, $id); 
    $kask->execute(); 
    
    $teade = "Tulemus $tulemus sisestatud edukalt!";
    header("Refresh: 2");
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
<!doctype html>
<html>

<head>
    <title>Teooriaeksam</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>📚 Teooriaeksam</h1>

        <?php 
    if($viga) { 
      echo "<div class='viga'>❌ $viga</div>"; 
    }
    if($teade) { 
      echo "<div class='edukas'>✓ $teade</div>"; 
    }
    ?>

        <p><strong>Nõue:</strong> Vähemalt 9 punkti 10-st</p>

        <?php if(empty($osalejaread)) { ?>
        <p style="color: #7f8c8d; font-style: italic;">
            Kõik osalejad on teooriaeksamil tulemuse saanud! ✓
        </p>
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
                <td><?php echo htmlspecialchars($osaleja['eesnimi']); ?></td>
                <td><?php echo htmlspecialchars($osaleja['perekonnanimi']); ?></td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $osaleja['id']; ?>" />
                        <input type="number" name="teooriatulemus" min="0" max="10" required style="width: 80px;" />
                </td>
                <td>
                    <input type="submit" value="Sisesta" />
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>

        <?php } ?>
    </div>
</body>

</html>
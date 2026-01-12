<?php
$lehepealkiri = "Avaleht";
require_once("konf.php");
require_once("header.php");

// Statistika - kogus registreeritud
$kask = $yhendus->prepare("SELECT COUNT(*) as kogus FROM jalgrattaeksam");
$kask->bind_result($kogus);
$kask->execute();
$kask->fetch();
$kask->close();

// Statistika - edukalt läbinud
$kask2 = $yhendus->prepare("SELECT COUNT(*) as lope FROM jalgrattaeksam WHERE luba=1");
$kask2->bind_result($lope);
$kask2->execute();
$kask2->fetch();
$kask2->close();
?>

<div class="container">
    <h1>🏠 Tervist!</h1>

    <div style="background-color: #3498db; color: white; padding: 30px; border-radius: 8px; margin: 20px 0;">
        <h2 style="color: white; border: none; margin-top: 0;">Jalgratta Eksami Süsteem</h2>
        <p style="color: #ecf0f1; margin-bottom: 0;">Tere tulemast! Siin saad registreeruda jalgratta eksamile ja
            testida oma teadmisi.</p>
    </div>

    <h2>📊 Statistika</h2>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;">
        <div style="background-color: #d5f4e6; padding: 20px; border-radius: 8px; text-align: center;">
            <h3 style="color: #27ae60; font-size: 2em; margin: 0;">
                <?php echo $kogus; ?>
            </h3>
            <p style="margin-bottom: 0;">Registreeritud osalejat</p>
        </div>
        <div style="background-color: #d6eaf8; padding: 20px; border-radius: 8px; text-align: center;">
            <h3 style="color: #2980b9; font-size: 2em; margin: 0;">
                <?php echo $lope; ?>
            </h3>
            <p style="margin-bottom: 0;">Eksamit läbinud</p>
        </div>
    </div>

    <h2>📋 Eksami etapid</h2>
    <table>
        <tr>
            <th>Järg</th>
            <th>Nimi</th>
            <th>Kirjeldus</th>
            <th>Nõue</th>
        </tr>
        <tr>
            <td><span class="badge badge-info">1</span></td>
            <td><strong>Teooriaeksam</strong></td>
            <td>10 küsimusest õigete vastuste andmine</td>
            <td>Vähemalt <strong>9 punkti</strong></td>
        </tr>
        <tr>
            <td><span class="badge badge-info">2</span></td>
            <td><strong>Slaalom</strong></td>
            <td>Slaalomsõidu reeglitepärane läbimine</td>
            <td>Teooria läbimine</td>
        </tr>
        <tr>
            <td><span class="badge badge-info">3</span></td>
            <td><strong>Ringtee</strong></td>
            <td>Ringteesõidu sooritamine</td>
            <td>Teooria läbimine</td>
        </tr>
        <tr>
            <td><span class="badge badge-info">4</span></td>
            <td><strong>Tänavasõit</strong></td>
            <td>Liikluses sõitmise eksamimine</td>
            <td>Slaalom + Ringtee läbimine</td>
        </tr>
        <tr>
            <td><span class="badge badge-success">✓</span></td>
            <td><strong>Luba</strong></td>
            <td>Jalgratta sõitumisluba</td>
            <td>Kõik etapid korras</td>
        </tr>
    </table>

    <h2>🚀 Alustamiseks</h2>
    <p>Klõpsa navigatsioonile "<strong>Registreerimine</strong>" ja sisesta oma nimi!</p>
    <a href="registreerimine.php" class="btn">📝 Registreeri nüüd</a>
</div>

<?php require_once("footer.php"); ?>
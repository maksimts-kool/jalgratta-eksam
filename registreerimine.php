<?php
$lehepealkiri = "Registreerimine";
require_once("konf.php");
require_once("auth.php");
require_once("funktsioonid.php");

suunaKuiSissologitud('index.php');

$viga = "";
$edu = "";

if(isset($_POST["regist_nupp"])){ 
    $kasutajanimi = getPOST("kasutajanimi");
    $parool = getPOST("parool");
    $paroolKinnitatud = getPOST("parool_kinnita");
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
        $tulemus = registreeriKasutaja($yhendus, $kasutajanimi, $parool, $paroolKinnitatud);
        
        if($tulemus['edukas']) {
            $getUserId = $yhendus->prepare("SELECT id FROM kasutajad WHERE kasutajanimi = ?");
            $getUserId->bind_param("s", $kasutajanimi);
            $getUserId->execute();
            $getUserId->bind_result($newUserId);
            $getUserId->fetch();
            $getUserId->close();
            
            $kask = $yhendus->prepare(
                "INSERT INTO jalgrattaeksam(kasutaja_id, eesnimi, perekonnanimi) VALUES (?, ?, ?)"
            );
            $kask->bind_param("iss", $newUserId, $eesnimi, $perekonnanimi);
            $kask->execute();
            $kask->close();
            
            header("Location: login.php?registered=1");
            exit();
        } else {
            $viga = $tulemus['sõnum'];
        }
    }
}

require_once("header.php");
?>

<div class="container">
    <h1>📝 Registreerimine</h1>

    <?php 
    if($viga) { 
        echo kuvaTeade('viga', "❌ $viga");
    }
    if($edu) { 
        echo kuvaTeade('edukas', "✓ $edu<br>Suunatakse sisselogimise lehele...");
    }
    ?>

    <div class="info">
        <strong>ℹ️ Teave:</strong> Loo endale kasutajakonto, et pääseda ligi jalgratta eksamile.
        Pärast registreerumist saad sisse logida ja alustada eksamit.
    </div>

    <form method="POST">
        <dl>
            <dt>👤 Eesnimi</dt>
            <dd>
                <input type="text" name="eesnimi" minlength="3" required placeholder="Näiteks: Jaan"
                    value="<?php echo isset($_POST['eesnimi']) ? turvTekst($_POST['eesnimi']) : ''; ?>" />
                <small>Vähemalt 3 tähemärki</small>
            </dd>

            <dt>👤 Perekonnanimi</dt>
            <dd>
                <input type="text" name="perekonnanimi" minlength="3" required placeholder="Näiteks: Tamm"
                    value="<?php echo isset($_POST['perekonnanimi']) ? turvTekst($_POST['perekonnanimi']) : ''; ?>" />
                <small>Vähemalt 3 tähemärki</small>
            </dd>

            <dt>👤 Kasutajanimi</dt>
            <dd>
                <input type="text" name="kasutajanimi" minlength="3" required placeholder="Vähemalt 3 tähemärki"
                    value="<?php echo isset($_POST['kasutajanimi']) ? turvTekst($_POST['kasutajanimi']) : ''; ?>" />
                <small>Vähemalt 3 tähemärki</small>
            </dd>

            <dt>🔒 Parool</dt>
            <dd>
                <input type="password" name="parool" minlength="6" required placeholder="Vähemalt 6 tähemärki" />
                <small>Vähemalt 6 tähemärki</small>
            </dd>

            <dt>🔒 Kinnita Parool</dt>
            <dd>
                <input type="password" name="parool_kinnita" minlength="6" required
                    placeholder="Sisesta parool uuesti" />
                <small>Sisesta sama parool uuesti</small>
            </dd>

            <dt>
                <input type="submit" name="regist_nupp" value="Registreeri" />
            </dt>
        </dl>
    </form>

    <div style="margin-top: 20px; text-align: center;">
        <p>Juba on kasutaja? <a href="login.php" class="btn" style="display: inline-block; padding: 10px 20px;">Logi
                sisse</a></p>
    </div>
</div>

<?php require_once("footer.php"); ?>
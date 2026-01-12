<?php
if (!isset($lehepealkiri)) {
  $lehepealkiri = "Jalgratta eksam";
}
?>
<!doctype html>
<html lang="et">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lehepealkiri; ?> - Jalgratta Eksam</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <h1>Jalgratta Eksam</h1>
                <p class="tagline">Testi oma teadmisi ja oskusi</p>
            </div>
        </div>
    </header>

    <nav class="navbar">
        <div class="nav-content">
            <ul class="nav-menu">
                <li><a href="index.php" class="nav-link">🏠 Avaleht</a></li>
                <li><a href="registreerimine.php" class="nav-link">📝 Registreerimine</a></li>
                <li><a href="teooriaeksam.php" class="nav-link">📚 Teooria</a></li>
                <li><a href="slaalom.php" class="nav-link">🏁 Slaalom</a></li>
                <li><a href="ringtee.php" class="nav-link">🔄 Ringtee</a></li>
                <li><a href="t2navasoit.php" class="nav-link">🛣️ Tänavasõit</a></li>
                <li><a href="lubadeleht.php" class="nav-link">📜 Lubad</a></li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
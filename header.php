<?php
if (!isset($lehepealkiri)) {
  $lehepealkiri = "Jalgratta eksam";
}

if (!function_exists('turvTekst')) {
    require_once("funktsioonid.php");
}

if (!function_exists('onSissologitud')) {
    require_once("auth.php");
}
?>
<!doctype html>
<html lang="et">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lehepealkiri; ?> - Jalgratta Eksam</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Roboto', 'ui-sans-serif', 'system-ui', '-apple-system', 'Segoe UI', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style type="text/tailwindcss">
        @layer base {
            body {
                @apply min-h-screen flex flex-col bg-slate-50 text-slate-900 font-sans;
            }

            h1 {
                @apply text-3xl font-semibold text-slate-900 mb-6;
            }

            h2 {
                @apply text-xl font-semibold text-slate-900 mt-8 mb-4;
            }

            h3 {
                @apply text-lg font-semibold text-slate-900;
            }

            p {
                @apply mb-4 leading-relaxed;
            }

            a {
                @apply text-blue-700 hover:text-blue-800 underline decoration-blue-300/60 hover:decoration-blue-400;
            }

            table {
                @apply w-full border-collapse overflow-hidden rounded-xl border border-slate-200 bg-white;
            }

            thead {
                @apply bg-slate-100;
            }

            th {
                @apply bg-slate-100 text-slate-700 font-semibold px-4 py-3 text-left;
            }

            td {
                @apply px-4 py-3 border-t border-slate-200 text-slate-800;
            }

            tr:hover {
                @apply bg-slate-50;
            }

            form {
                @apply my-6;
            }

            dl {
                @apply grid gap-4;
            }

            dt {
                @apply font-semibold text-slate-800;
            }

            dd small {
                @apply block mt-1 text-xs text-slate-500;
            }

            input[type="text"],
            input[type="password"],
            input[type="number"],
            select,
            textarea {
                @apply w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm outline-none;
                @apply focus:border-blue-500 focus:ring-2 focus:ring-blue-200;
            }

            input[type="submit"] {
                @apply inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 font-medium text-white shadow-sm;
                @apply hover:bg-blue-700 active:bg-blue-800 transition;
                @apply cursor-pointer;
            }
        }

        @layer components {
            .header {
                @apply bg-blue-700 text-white shadow;
            }

            .header-content {
                @apply max-w-6xl mx-auto px-6 py-6 flex items-center justify-between gap-6;
            }

            .logo h1 {
                @apply text-2xl md:text-3xl font-semibold text-white mb-1;
            }

            .header p {
                @apply text-blue-100;
            }

            .tagline {
                @apply text-sm text-blue-100 mb-0;
            }

            .navbar {
                @apply sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200;
            }

            .nav-content {
                @apply max-w-6xl mx-auto px-4;
            }

            .nav-menu {
                @apply flex flex-wrap gap-2 py-2 list-none;
            }

            .nav-link {
                @apply inline-flex items-center gap-2 px-4 py-2 rounded-full text-slate-700 no-underline;
                @apply hover:bg-slate-100 hover:text-slate-900 transition;
            }

            .main-content {
                @apply flex-1 max-w-6xl w-full mx-auto px-4 py-6;
            }

            .container {
                @apply bg-white border border-slate-200 rounded-2xl shadow-sm p-6 md:p-8 mb-6;
            }

            .btn {
                @apply inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 font-medium text-white no-underline shadow-sm;
                @apply hover:bg-blue-700 active:bg-blue-800 transition;
            }

            .btn-info {
                @apply bg-sky-600 hover:bg-sky-700 active:bg-sky-800;
            }

            .btn-danger {
                @apply bg-red-600 hover:bg-red-700 active:bg-red-800;
            }

            .info {
                @apply rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-blue-900 mb-4;
            }

            .viga {
                @apply rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-900 mb-4;
            }

            .edukas {
                @apply rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900 mb-4;
            }

            .badge {
                @apply inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold;
            }

            .badge-success {
                @apply bg-emerald-100 text-emerald-800;
            }

            .badge-warning {
                @apply bg-amber-100 text-amber-800;
            }

            .badge-danger {
                @apply bg-red-100 text-red-800;
            }

            .badge-info {
                @apply bg-sky-100 text-sky-800;
            }

            .footer {
                @apply border-t border-slate-200 bg-white;
            }

            .footer-content {
                @apply max-w-6xl mx-auto px-6 py-6;
            }

            .footer-info {
                @apply text-sm text-slate-500 mb-0;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <h1>Jalgratta Eksam</h1>
                <p class="tagline">Testi oma teadmisi ja oskusi</p>
            </div>
            <div class="text-right">
                <?php if(onSissologitud()): ?>
                    <p class="my-1">
                        👤 <strong class="text-white"><?php echo turvTekst(kasutajanimi()); ?></strong>
                        <?php if(onAdmin()): ?>
                            <span class="ml-2 inline-flex items-center rounded-full bg-red-500/20 px-2 py-0.5 text-xs font-semibold text-red-50 ring-1 ring-inset ring-red-200/30">ADMIN</span>
                        <?php else: ?>
                            <span class="ml-2 inline-flex items-center rounded-full bg-sky-500/20 px-2 py-0.5 text-xs font-semibold text-sky-50 ring-1 ring-inset ring-sky-200/30">KASUTAJA</span>
                        <?php endif; ?>
                    </p>
                    <p class="my-1">
                        <a href="logout.php" class="text-yellow-200 hover:text-yellow-100 underline decoration-yellow-200/40 hover:decoration-yellow-200">🚪 Logi välja</a>
                    </p>
                <?php else: ?>
                    <p class="my-1">
                        <a href="login.php" class="text-yellow-200 hover:text-yellow-100 underline decoration-yellow-200/40 hover:decoration-yellow-200">🔐 Logi sisse</a> |
                        <a href="registreerimine.php" class="text-yellow-200 hover:text-yellow-100 underline decoration-yellow-200/40 hover:decoration-yellow-200">📝 Registreeri</a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <nav class="navbar">
        <div class="nav-content">
            <ul class="nav-menu">
                <li><a href="index.php" class="nav-link">🏠 Avaleht</a></li>
                <?php if(onSissologitud()): ?>
                    <li><a href="teooriaeksam.php" class="nav-link">📚 Teooria</a></li>
                    <li><a href="slaalom.php" class="nav-link">🏁 Slaalom</a></li>
                    <li><a href="ringtee.php" class="nav-link">🔄 Ringtee</a></li>
                    <li><a href="t2navasoit.php" class="nav-link">🛣️ Tänavasõit</a></li>
                    <li><a href="lubadeleht.php" class="nav-link">📜 Lubad</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main class="main-content">
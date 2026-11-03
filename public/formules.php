<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formules</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ballet:opsz@16..72&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="global.css" rel="stylesheet">
    <link href="formules.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . "/../templates/header.php" ; ?>
<main>
    <h1 class="formulas-title">Nos formules</h1>
    <p class="text formula-subtitle">Vous pourrez choisir votre formules</p>

    <article class="formula-card">
        <p>★</p>
        <h2 class="h2-title">Solo</h2>
        <img src="images/elno13.jpg" class="img-formulas" alt="image-solo">
        <p class="text">Dans la formule solo vous trouverez Nino, etc ...</p>
        <div class="formula-bottom">
            <p class="formula-price">À partir de 100 euros</p>
            <a href="#" class="btn">Réserver</a>
        </div>
    </article>

    <article class="formula-card">
        <p>★★</p>
        <h2 class="h2-title">Duo</h2>
        <img src="images/elno17.jpg" class="img-formulas" alt="image-solo">
        <p class="text">Dans la formule duo vous trouverez Nino avec Elliott, etc ...</p>
        <div class="formula-bottom">
            <p class="formula-price">À partir de 300 euros</p>
            <a href="#" class="btn">Réserver</a>
        </div>
    </article>


</main>
<?php require __DIR__ . "/../templates/footer.php" ; ?>
</body>
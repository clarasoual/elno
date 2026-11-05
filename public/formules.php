<?php
require __DIR__ . '/../src/database.php' ; 
$pdo = getPdo() ;
$formulas = $pdo->query('SELECT id, name, description, price, sample_songs, photo, video FROM formulas ORDER BY id')->fetchAll() ;
?>

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

    <?php
    foreach ($formulas as $formula): ?>

    <article class="formula-card">
        <p>★</p>
        <h2 class="h2-title"><?= $formula['name'] ?></h2>
        <img src="<?= $formula['photo']?>" class="img-formulas" alt="Photo de la formule <?= $formula['name']?>">
        <p class="text"><?= $formula['description'] ?></p>
        <div class="formula-bottom">
            <p class="formula-price">À partir de <?= $formula['price'] ?></p>
            <a href="#" class="btn">Réserver</a>
        </div>
    </article>

    <?php endforeach; ?>

</main>
<?php require __DIR__ . "/../templates/footer.php" ; ?>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Pinyon+Script&display=swap" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . "/../templates/header.php" ; ?>
    <main>
        <section class="hero">
            <img src="#" alt="Image Musiciens" class="img-hero">
            <h1 class="h1-title">Bienvenue chez Elno !</h1>
            <a href="#" class="btn">Réserver</a>
        </section>

        <section class="presentation">
            <h2 class="h2-title">Elno, c'est quoi ?</h2>
            <p class="text">Elno est un groupe de musique composé de 2 artistes, Elliott et Nino.</p>
            <a href="#" class="btn">En savoir +</a>
            <p class="text">Nos prestations sont sous forme de formules, il y en a 2 différentes pour l'instant.</p>
            <a href="#" class="btn">Voir les formules</a>
        </section>

        <section class="socials">
            <h2 class="h2-title">Jetez un coup d'oeil à l'ambiance en suivant notre compte Instagram !</h2>
            <a href="#" class="instagram">Instagram</a>
        </section>

        <section class="index-CTA">
            <h2 class="h2-title">Convaincus ?</h2>
            <a href="#" class="btn">Réservez</a>
            <p class="text">Pour plus de questions, contactez le 0607080910</p>
        </section>
    </main>
    
<?php require __DIR__ . "/../templates/footer.php" ; ?>

</body>
</html>
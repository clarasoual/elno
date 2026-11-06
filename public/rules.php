<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Règlement</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ballet:opsz@16..72&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="global.css" rel="stylesheet">
    <link href="rules.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . "/../templates/header.php" ; ?>
<main>
<h1 class="rules-h1">Règlement</h1>
<p class="rules-intro">Avant d'effectuer une demande de réservation, veuillez lire le règlement ci-dessous. Vous pouvez le consulter à tout moment en bas du site.</p>

<div class="rules-grid">
<section class="rules-section">
    <p class="rules-number">1.</p>
    <h2 class="h2-title">Votre demande</h2>
    <p class="rules-text">Le formulaire envoie une demande de réservation, pas une réservation définitive. Nino étudie chaque demande et vous répond sous 72 h pour confirmer la date ou vous proposer une alternative. Votre réservation n’est confirmée qu’après cette réponse.</p>
</section>

<section class="rules-section">
    <p class="rules-number">2.</p>
    <h2 class="h2-title">Paiement</h2>
    <p class="rules-text">Le paiement ne se fait pas sur le site. Une fois votre réservation confirmée, vous recevrez une facture émise par notre association. Le règlement s’effectue par virement bancaire ou par chèque. Pour cela, vos coordonnées vous seront demandées dans le formulaire.</p>
</section>

<section class="rules-section">
    <p class="rules-number">3.</p>
    <h2 class="h2-title">Annulation</h2>
    <p class="rules-text">En cas d’annulation de votre part, merci de prévenir Nino au plus tôt. [Conditions et délais d’annulation à définir.]</p>
</section>

<section class="rules-section">
    <p class="rules-number">4.</p>
    <h2 class="h2-title">Sur place</h2>
    <p class="rules-text">Pour jouer dans de bonnes conditions, nous avons besoin d’un espace abrité et d’une prise électrique à proximité. [Autres besoins à confirmer.]</p>
</section>

<section class="rules-section">
    <p class="rules-number">5.</p>
    <h2 class="h2-title">Déplacements</h2>
    <p class="rules-text">Nous nous déplaçons autour de Bordeaux. [Zone et éventuels frais de déplacement à définir.]</p>
</section>

</div>

</main>
<?php require __DIR__ . "/../templates/footer.php" ; ?>
</body>
</html>
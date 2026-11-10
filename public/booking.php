<?php
require __DIR__ . '/../src/database.php' ; 
$pdo = getPdo() ;
$formulas = $pdo->query('SELECT id, name FROM formulas ORDER BY id')->fetchAll() ;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de réservation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ballet:opsz@16..72&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="global.css" rel="stylesheet">
    <link href="booking.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . "/../templates/header.php" ; ?>
<main>
    <h1 class="booking-h1">Votre demande de réservation</h1>
    <form action="booking.php" method="post" class="booking-form">
        <fieldset>
            <legend>Vous êtes</legend>

            <label>
                <input type="radio" name="client_type" value="particulier" required>
                Particulier
            </label>
            <label>
                <input type="radio" name="client_type" value="professionnel" required>
                Professionnel
            </label>
        </fieldset>
        <fieldset>
            <legend>Votre événement</legend>

            <label for="formula">Formule</label>
            <select id="formula" name="formula_id" required>
                <option value="">Choisissez votre formule</option>
                <?php
                foreach ($formulas as $formula): ?>
                <option value="<?= htmlspecialchars($formula['id']) ?>"><?= htmlspecialchars($formula['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="duration">Durée de la prestation</label>
            <select id="duration" name="prestation_duration" required>
                <option value="">Choisissez une durée</option>
                <option value="moins_1h">Moins d'1 heure</option>
                <option value="1h_2h">Entre 1 et 2 heures</option>
                <option value="2h_3h">Entre 2 et 3 heures</option>
                <option value="plus_3h">Plus de 3 heures</option>
            </select>

            <label for="event-date">Date de l'événement</label>
            <input type="date" id="event-date" name="event_date" min="<?= date('Y-m-d') ?>" required>

            <label for="event-location">Adresse exacte du lieu</label>
            <input type="text" id="event-location" name="event_location" maxlength="300" required>
            <p class="booking-hint">Max. 150 km de Bordeaux. Elno a besoin de l'adresse pour calculer les frais de déplacement.</p>

            <label for="event-type">Type d'événement</label>
            <select id="event-type" name="event_type" required>
                <option value="">Choisissez votre type d'événement</option>
                <option value="mariage">Mariage</option>
                <option value="repas_entreprise">Repas d'entreprise</option>
                <option value="soiree_privee">Soirée privée</option>
                <option value="bar_guinguette">Bar ou guinguette</option>
                <option value="restaurant">Restaurant</option>
                <option value="association">Association</option>
                <option value="autre">Autre (précisez dans la description)</option>
            </select>
        </fieldset>
    </form>




</main>
<?php require __DIR__ . "/../templates/footer.php" ; ?>
</body>
</html>
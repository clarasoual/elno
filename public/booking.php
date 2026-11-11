<?php
require __DIR__ . '/../src/database.php' ; 
$pdo = getPdo() ;
$formulas = $pdo->query('SELECT id, name FROM formulas ORDER BY id')->fetchAll() ;
$errors = [] ;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstName = trim($_POST['first_name'] ?? '') ;

    if ($firstName === '') {
        $errors['first_name'] = 'Indiquez votre prénom.' ;
    }

    $lastName = trim($_POST['last_name'] ?? '') ;

    if ($lastName === '') {
        $errors['last_name'] = 'Indiquez votre nom.' ;
    } 

    $email = trim($_POST['email'] ?? '') ;

    if ($email === '') {
        $errors['email'] = 'Indiquez votre adresse mail.' ;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Cette adresse mail n\'est pas valide.' ;
    }

    $phoneNumber = trim($_POST['phone_number'] ?? '') ;

    if ($phoneNumber === '') {
        $errors['phone_number'] = 'Indiquez votre numéro de téléphone.' ;
    } 

    $address = trim($_POST['address'] ?? '') ;

    if ($address === '') {
        $errors['address'] = 'Indiquez votre adresse de facturation.' ;
    } 

    $eventLocation = trim($_POST['event_location'] ?? '') ;

    if ($eventLocation === '') {
        $errors['event_location'] = 'Indiquez l\'adresse du lieu.' ;
    } 
        
    $eventDescription = trim($_POST['event_description'] ?? '') ;

    if ($eventDescription === '') {
        $errors['event_description'] = 'Décrivez votre événement.' ;
    } 

    $clientType = $_POST['client_type'] ?? '' ;

    if (!in_array($clientType, ['particulier', 'professionnel'], true)) {
        $errors['client_type'] = 'Indiquez si vous êtes un particulier ou un professionnel.' ;
    }

    $prestationDuration = $_POST['prestation_duration'] ?? '' ;

    if (!in_array($prestationDuration, ['moins_1h', '1h_2h', '2h_3h', 'plus_3h'], true)) {
        $errors['prestation_duration'] = 'Indiquez la durée souhaitée de la prestation.' ;
    }

    $eventType = $_POST['event_type'] ?? '' ;

    if (!in_array($eventType, ['mariage', 'repas_entreprise', 'soiree_privee', 'bar_guinguette', 'restaurant', 'association', 'autre'], true)) {
        $errors['event_type'] = 'Indiquez le type d\'événement.' ;
    }

    $formulaId = (int) ($_POST['formula_id'] ?? 0) ;
    $formulaIds = array_column($formulas,'id') ;

    if (!in_array($formulaId, $formulaIds, true)) {
        $errors['formula_id'] = 'Choisissez une formule.' ;
    }

    var_dump($errors) ;
}
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
            <legend>Vous</legend>

            <div class="booking-field booking-field-full booking-choice">
            <label>
                <input type="radio" name="client_type" value="particulier" required>
                Particulier
            </label>
            <label>
                <input type="radio" name="client_type" value="professionnel" required>
                Professionnel
            </label>
            </div>

            <div class="booking-field">
            <label for="first-name">Votre prénom</label>
            <input id="first-name" name="first_name" maxlength="50" autocomplete="given-name" placeholder="Ex : Jeanne" required>
            </div>

            <div class="booking-field">
            <label for="last-name">Votre nom</label>
            <input id="last-name" name="last_name" maxlength="50" autocomplete="family-name" placeholder="Ex : Dupont" required>
            </div>

            <div class="booking-field">
            <label for="email">Votre adresse mail</label>
            <input id="email" name="email" maxlength="100" autocomplete="email" type="email" placeholder="Ex : email@elno.fr" required>
            </div>

            <div class="booking-field">
            <label for="phone-number">Votre n° de téléphone</label>
            <input id="phone-number" name="phone_number" type="tel" maxlength="20" autocomplete="tel" placeholder="Ex : 012345678" required>
            </div>

            <div class="booking-field booking-field-full">
            <label for="address">Votre adresse de facturation</label>
            <input id="address" name="address" maxlength="300" autocomplete="street-address" placeholder="Ex : 1 place de la bourse, 33000, Bordeaux" required>
            </div>
        </fieldset>
        <fieldset>
            <legend>Votre événement</legend>

            <div class="booking-field">
            <label for="formula">Formule</label>
            <select id="formula" name="formula_id" required>
                <option value="">Choisissez votre formule</option>
                <?php
                foreach ($formulas as $formula): ?>
                <option value="<?= htmlspecialchars($formula['id']) ?>"><?= htmlspecialchars($formula['name']) ?></option>
                <?php endforeach; ?>
            </select>
            </div>

            <div class="booking-field">
            <label for="duration">Durée de la prestation</label>
            <select id="duration" name="prestation_duration" required>
                <option value="">Choisissez une durée</option>
                <option value="moins_1h">Moins d'1 heure</option>
                <option value="1h_2h">Entre 1 et 2 heures</option>
                <option value="2h_3h">Entre 2 et 3 heures</option>
                <option value="plus_3h">Plus de 3 heures</option>
            </select>
            </div>

            <div class="booking-field">
            <label for="event-date">Date de l'événement</label>
            <input type="date" id="event-date" name="event_date" min="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="booking-field">
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
            </div>

            <div class="booking-field booking-field-full">
            <label for="event-location">Adresse exacte du lieu</label>
            <input type="text" id="event-location" name="event_location" maxlength="300" placeholder="Ex : 3 rue Sainte Catherine, 33000, Bordeaux" required>
            <p class="booking-hint">Max. 150 km de Bordeaux. Elno a besoin de l'adresse pour calculer les frais de déplacement.</p>
            </div>

            <div class="booking-field booking-field-full">
            <label for="event-description">Décrivez votre événement</label>
            <textarea id="event-description" name="event_description" rows="6" placeholder="Ex : je souhaite faire une surprise à ma femme pour notre anniversaire de mariage, ..." required></textarea>
            <p class="booking-hint">Ce que vous recherchez, l'ambiance souhaitée, le nombre d'invités ... Si vous réservez pour une entreprise, présentez-la ici.</p>
            </div>
        </fieldset>

        <button type="submit" class="btn booking-submit">Envoyer votre demande</button>
    </form>




</main>
<?php require __DIR__ . "/../templates/footer.php" ; ?>
</body>
</html>
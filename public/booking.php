<?php
require __DIR__ . '/../src/database.php' ; 
require __DIR__ . '/../src/mailer.php' ;
$pdo = getPdo() ;
$formulas = $pdo->query('SELECT id, name FROM formulas ORDER BY id')->fetchAll() ;
$errors = [] ;

$acceptRules = $_GET['accept_rules'] ?? $_POST['accept_rules'] ?? '' ;

if ($acceptRules !== 'on' && !isset($_GET['success'])) {
    header('Location: rules.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstName = trim($_POST['first_name'] ?? '') ;

    if ($firstName === '') {
        $errors['first_name'] = 'Indiquez votre prénom.' ;
    } elseif (mb_strlen($firstName) > 50) {
        $errors['first_name'] = 'Votre prénom ne doit pas dépasser 50 caractères.' ;
    }

    $lastName = trim($_POST['last_name'] ?? '') ;

    if ($lastName === '') {
        $errors['last_name'] = 'Indiquez votre nom.' ;
    } elseif (mb_strlen($lastName) > 50) {
        $errors['last_name'] = 'Votre nom ne doit pas dépasser 50 caractères.' ;
    }

    $email = trim($_POST['email'] ?? '') ;

    if ($email === '') {
        $errors['email'] = 'Indiquez votre adresse mail.' ;
    } elseif (mb_strlen($email) > 100) {
        $errors['email'] = 'Votre adresse mail ne doit pas dépasser 100 caractères.' ;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Cette adresse mail n\'est pas valide.' ;
    } 

    $phoneNumber = trim($_POST['phone_number'] ?? '') ;

    if ($phoneNumber === '') {
        $errors['phone_number'] = 'Indiquez votre numéro de téléphone.' ;
    } elseif (mb_strlen($phoneNumber) > 20) {
        $errors['phone_number'] = 'Votre numéro de téléphone ne doit pas dépasser 20 caractères.' ;
    }

    $address = trim($_POST['address'] ?? '') ;

    if ($address === '') {
        $errors['address'] = 'Indiquez votre adresse de facturation.' ;
    } elseif (mb_strlen($address) > 300) {
        $errors['address'] = 'Votre adresse de facturation ne doit pas dépasser 300 caractères.' ;
    }

    $eventLocation = trim($_POST['event_location'] ?? '') ;

    if ($eventLocation === '') {
        $errors['event_location'] = 'Indiquez l\'adresse du lieu.' ;
    } elseif (mb_strlen($eventLocation) > 300) {
        $errors['event_location'] = 'L\'adresse du lieu ne doit pas dépasser 300 caractères.' ;
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

    $eventDate = $_POST['event_date'] ?? '';
    $date = DateTime::createFromFormat('Y-m-d', $eventDate) ;

    if (!$date || $date->format('Y-m-d') !== $eventDate) {
        $errors['event_date'] = 'Indiquez une date valide.' ;
    } elseif ($eventDate < date('Y-m-d')) {
        $errors['event_date'] = 'La date ne peut pas être passée.' ;
    }
    if (empty($errors)) {

    $existing = $pdo->prepare('
    SELECT reservation_number FROM reservations
    WHERE email = :email AND event_date = :event_date AND status = :status
    ') ;
    $existing->execute([
        'email' => $email,
        'event_date' => $eventDate,
        'status' => 'en_attente',
    ]);
    $existingNumber = $existing->fetchColumn();
    if ($existingNumber) {
        header('Location: booking.php?success=1&duplicate=1&number=' . urlencode($existingNumber)) ;
        exit;
    }

        do {
            $reservationNumber = 'ELNO-' . date('Y') . '-' . str_pad(random_int(0,9999), 4, '0', STR_PAD_LEFT) ;

            $check = $pdo->prepare('SELECT COUNT(*) FROM reservations WHERE reservation_number = :number');
            $check->execute(['number' => $reservationNumber]);
        } while ($check->fetchColumn() > 0);
    
        $insert = $pdo->prepare('
        INSERT INTO reservations
            (reservation_number, client_type, first_name, last_name, email, phone_number, address, formula_id, prestation_duration, event_date, event_type, event_location, event_description, rules_accepted_at)
        VALUES
            (:reservation_number, :client_type, :first_name, :last_name, :email, :phone_number, :address, :formula_id, :prestation_duration, :event_date, :event_type, :event_location, :event_description, NOW())
        ');

        $insert->execute([
            'reservation_number' => $reservationNumber,
            'client_type' => $clientType,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone_number' => $phoneNumber,
            'address' => $address,
            'formula_id' => $formulaId,
            'prestation_duration' => $prestationDuration,
            'event_date' => $eventDate,
            'event_type' => $eventType,
            'event_location' => $eventLocation,
            'event_description' => $eventDescription,
        ]);
        
        sendMail(
            $email,
            'Votre demande de réservation ' . $reservationNumber,
            'Bonjour ' . $firstName . ', votre demande a bien été reçue. Votre numéro : ' . $reservationNumber
        ) ;
        header('Location: booking.php?success=1&number=' . urlencode($reservationNumber)) ;
        exit;
    }
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

    <?php if (isset($_GET['success'])): ?>
        <div class="booking-success">
        <h2 class="h2-title">Merci !</h2>
        <?php if (isset($_GET['duplicate'])): ?>
            <p>Vous avez déjà envoyé une demande pour cette date. Elno vous recontactera sous 72 h.</p>
        <?php else: ?>
        <p>Merci, votre demande a bien été envoyée. Vous recevrez un mail de confirmation sous peu. Elno vous recontactera sous 72h. </p>
        <?php endif; ?>
        <p>Votre numéro de demande : <strong><?= htmlspecialchars($_GET['number'] ?? '') ?></strong></p>
        </div>
    <?php else: ?>
    <form action="booking.php" method="post" class="booking-form">
        <input type="hidden" name="accept_rules" value="on">
        <fieldset>
            <legend>Vous</legend>

            <div class="booking-field booking-field-full booking-choice">
            <label>
                <input type="radio" name="client_type" value="particulier" <?= ($clientType ?? '')=== 'particulier' ? 'checked' : ''  ?> required>
                Particulier
            </label>
            <label>
                <input type="radio" name="client_type" value="professionnel" <?= ($clientType ?? '')=== 'professionnel' ? 'checked' : ''  ?> required>
                Professionnel
            </label>

            <?php if (isset($errors['client_type'])) : ?>
                <p class="booking-error"><?= htmlspecialchars($errors['client_type']) ?></p>
            <?php endif; ?>
            </div>

            <div class="booking-field">
            <label for="first-name">Votre prénom</label>
            <input id="first-name" name="first_name" maxlength="50" autocomplete="given-name" placeholder="Ex : Jeanne" value="<?= htmlspecialchars($firstName ?? '') ?>" required>

            <?php if (isset($errors['first_name'])) : ?>
                <p class="booking-error"><?= htmlspecialchars($errors['first_name']) ?></p>
            <?php endif; ?>
            </div>
        

            <div class="booking-field">
            <label for="last-name">Votre nom</label>
            <input id="last-name" name="last_name" maxlength="50" autocomplete="family-name" placeholder="Ex : Dupont" value="<?= htmlspecialchars($lastName ?? '') ?>" required>
            
            <?php if (isset($errors['last_name'])) : ?>
                <p class="booking-error"><?= htmlspecialchars($errors['last_name']) ?></p>
            <?php endif; ?>
            </div>

            <div class="booking-field">
            <label for="email">Votre adresse mail</label>
            <input id="email" name="email" maxlength="100" autocomplete="email" type="email" placeholder="Ex : jeanne.dupont@mail.fr" value="<?= htmlspecialchars($email ?? '') ?>" required>
            
            <?php if (isset($errors['email'])) : ?>
                <p class="booking-error"><?= htmlspecialchars($errors['email']) ?></p>
            <?php endif; ?>
            </div>

            <div class="booking-field">
            <label for="phone-number">Votre n° de téléphone</label>
            <input id="phone-number" name="phone_number" type="tel" maxlength="20" autocomplete="tel" placeholder="Ex : 0123456789" value="<?= htmlspecialchars($phoneNumber ?? '') ?>" required>
            
            <?php if (isset($errors['phone_number'])) : ?>
                <p class="booking-error"><?= htmlspecialchars($errors['phone_number']) ?></p>
            <?php endif; ?>
            </div>

            <div class="booking-field booking-field-full">
            <label for="address">Votre adresse de facturation</label>
            <input id="address" name="address" maxlength="300" autocomplete="street-address" placeholder="Ex : 1 place de la bourse, 33000, Bordeaux" value="<?= htmlspecialchars($address ?? '') ?>" required>
            
            <?php if (isset($errors['address'])) : ?>
                <p class="booking-error"><?= htmlspecialchars($errors['address']) ?></p>
            <?php endif; ?>
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
                <option value="<?= htmlspecialchars($formula['id']) ?>" <?= ($formulaId ?? 0) === $formula['id'] ? 'selected' : '' ?>><?= htmlspecialchars($formula['name']) ?></option>
                <?php endforeach; ?>
            </select>
            
            <?php if (isset($errors['formula_id'])) : ?>
                <p class="booking-error"><?= htmlspecialchars($errors['formula_id']) ?></p>
            <?php endif; ?>
            </div>

            <div class="booking-field">
            <label for="duration">Durée de la prestation</label>
            <select id="duration" name="prestation_duration" required>
                <option value="">Choisissez une durée</option>
                <option value="moins_1h" <?= ($prestationDuration ?? '') === 'moins_1h' ? 'selected' : '' ?>>Moins d'1 heure</option>
                <option value="1h_2h" <?= ($prestationDuration ?? '') === '1h_2h' ? 'selected' : '' ?>>Entre 1 et 2 heures</option>
                <option value="2h_3h" <?= ($prestationDuration ?? '') === '2h_3h' ? 'selected' : '' ?>>Entre 2 et 3 heures</option>
                <option value="plus_3h" <?= ($prestationDuration ?? '') === 'plus_3h' ? 'selected' : '' ?>>Plus de 3 heures</option>
            </select>
            
            <?php if (isset($errors['prestation_duration'])) : ?>
                <p class="booking-error"><?= htmlspecialchars($errors['prestation_duration']) ?></p>
            <?php endif; ?>
            </div>

            <div class="booking-field">
            <label for="event-date">Date de l'événement</label>
            <input type="date" id="event-date" name="event_date" min="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($eventDate ?? '') ?>" required>
            
            <?php if (isset($errors['event_date'])) : ?>
                <p class="booking-error"><?= htmlspecialchars($errors['event_date']) ?></p>
            <?php endif; ?>
            </div>

            <div class="booking-field">
            <label for="event-type">Type d'événement</label>
            <select id="event-type" name="event_type" required>
                <option value="">Choisissez votre type d'événement</option>
                <option value="mariage" <?= ($eventType ?? '') === 'mariage' ? 'selected' : '' ?>>Mariage</option>
                <option value="repas_entreprise" <?= ($eventType ?? '') === 'repas_entreprise' ? 'selected' : '' ?>>Repas d'entreprise</option>
                <option value="soiree_privee" <?= ($eventType ?? '') === 'soiree_privee' ? 'selected' : '' ?>>Soirée privée</option>
                <option value="bar_guinguette" <?= ($eventType ?? '') === 'bar_guinguette' ? 'selected' : '' ?>>Bar ou guinguette</option>
                <option value="restaurant" <?= ($eventType ?? '') === 'restaurant' ? 'selected' : '' ?>>Restaurant</option>
                <option value="association" <?= ($eventType ?? '') === 'association' ? 'selected' : '' ?>>Association</option>
                <option value="autre" <?= ($eventType ?? '') === 'autre' ? 'selected' : '' ?>>Autre (précisez dans la description)</option>
            </select>
            
            <?php if (isset($errors['event_type'])) : ?>
                <p class="booking-error"><?= htmlspecialchars($errors['event_type']) ?></p>
            <?php endif; ?>
            </div>

            <div class="booking-field booking-field-full">
            <label for="event-location">Adresse exacte du lieu</label>
            <input type="text" id="event-location" name="event_location" maxlength="300" placeholder="Ex : 3 rue Sainte Catherine, 33000, Bordeaux" value="<?= htmlspecialchars($eventLocation ?? '') ?>" required>
            <p class="booking-hint">Max. 150 km de Bordeaux. Elno a besoin de l'adresse pour calculer les frais de déplacement.</p>
            
            <?php if (isset($errors['event_location'])) : ?>
                <p class="booking-error"><?= htmlspecialchars($errors['event_location']) ?></p>
            <?php endif; ?>
            </div>

            <div class="booking-field booking-field-full">
            <label for="event-description">Décrivez votre événement</label>
            <textarea id="event-description" name="event_description" rows="6" placeholder="Ex : je souhaite faire une surprise à ma femme pour notre anniversaire de mariage, ..." required><?= htmlspecialchars($eventDescription ?? '') ?></textarea>
            <p class="booking-hint">Ce que vous recherchez, l'ambiance souhaitée, le nombre d'invités ... Si vous réservez pour une entreprise, présentez-la ici.</p>
            
            <?php if (isset($errors['event_description'])) : ?>
                <p class="booking-error"><?= htmlspecialchars($errors['event_description']) ?></p>
            <?php endif; ?>
            </div>
        </fieldset>

        <button type="submit" class="btn booking-submit">Envoyer votre demande</button>
    </form>
    <?php endif; ?>




</main>
<?php require __DIR__ . "/../templates/footer.php" ; ?>
</body>
</html>
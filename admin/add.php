<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}

require('ENV.php');
require('includes/db.inc.php');

$errors = array();

if (isset($_POST['title'])) {
    if (strlen(trim($_POST['title'])) == 0) {
        $errors['title'] = 'Titel is verplicht';
    }

    if (count($errors) == 0) {
        addProduct([
            'name' => $_POST['title'],
            'image' => 'test'
        ]);
        header("Location: index.php");
        exit;
    }
}

print '<pre>';
print_r($_POST);
print_r($errors);
print '</pre>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>private admin webpage</title>
    <?php include("includes/cs.inc.php"); ?>
</head>

<body>


    <div class="container">

        <h1>Nieuw Product toevoegen</h1>

        <form method="post" action="add.php">
            <div class="mb-3">
                <label for="title" class="form-label">Titel</label>
                <input type="text" class="form-control<?= isset($errors['title']) ? ' is-invalid' : '' ?>" name="title"
                    id="title" placeholder="Titel van product">
                <div class="invalid-feedback">
                    <?= @$errors['title']; ?>
                </div>
            </div>

            <button type="submit">Opslaan</button>
        </form>

    </div>

</body>

</html>
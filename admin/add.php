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

    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // we weten zeker dat de upload naar een tijdelijke map op de server gelukt is.

        $fileNameCmps = explode(".", $_FILES['image']['name']);
        $fileExtension = strtolower(end($fileNameCmps));


        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileExtension, $allowedfileExtensions)) {

            $uploadFileDir = 'uploads/';

            $newFileName = md5(time() . $_FILES['image']['name']) . '_' . time() . '.' . $fileExtension;
            // print $_FILES['image']['tmp_name'];
            // print '<br />';
            print $dest_path = $uploadFileDir . $newFileName;
            // exit;

            if (move_uploaded_file($_FILES['image']['tmp_name'], '../' . $dest_path)) {
                $image = $dest_path;
            } else {
                $errors['image'] = 'There was some error moving the file to upload directory. upl make sure the upload directory is writable by web server.';
            }

        } else {
            $errors['image'] = 'Je kan enkel afbeeldingen uploaden!';
        }

    } else {
        $errors['image'] = 'Er liep iets fout bij het uploaden van de afbeelding.';
    }

    if (count($errors) == 0) {
        addProduct([
            'name' => $_POST['title'],
            'image' => $image
        ]);
        header("Location: index.php");
        exit;
    }
}

print '<pre>';
print_r($_POST);
print_r($errors);
print_r($_FILES);

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

        <form method="post" action="add.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Titel</label>
                <input type="text" class="form-control<?= isset($errors['title']) ? ' is-invalid' : '' ?>" name="title"
                    id="title" placeholder="Titel van product">
                <div class="invalid-feedback">
                    <?= @$errors['title']; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input class="form-control" type="file" name="image" id="image">
            </div>

            <button type="submit">Opslaan</button>
        </form>

    </div>

</body>

</html>
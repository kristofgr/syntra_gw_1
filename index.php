<?php
$manifestJson = file_get_contents("./dist/manifest.json");
$manifestObj = json_decode($manifestJson, true);
$cssPath = $manifestObj["js/index.js"]["css"][0];
$jsPath = $manifestObj["js/index.js"]["file"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>document</title>
    <link rel="stylesheet" href="./dist/<?= $cssPath ?>" />
    <script type="module" src="./dist/<?= $jsPath ?>"></script>
</head>

<body>
    <h1>
        <?= "php works..." ?>
    </h1>
</body>

</html>
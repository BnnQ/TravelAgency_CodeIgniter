<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $title ?? "Title not specified" ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<header>
    <?php
    helper('nav_menu');
    echo nav_menu();
    ?>
</header>
<?php
$errors = session()->get('errors');
if (isset($errors)) {
    foreach ($errors as $errorMessage) {
        echo view('errorToast', ['errorMessage' => $errorMessage]);
    }
}
?>

<?= $this->renderSection('content') ?>

</body>
</html>
<?php

$action = $this->getAction();

$url = ASSETS;

?>

<!DOCTYPE html>
<html>
    <head>
        <title><?= (isset($this->page_title) ? $this->page_title : 'Welcome'); ?></title>
        <meta charset="UTF-8">
    </head>

    <!-- Bootstrap -->
	<link rel="stylesheet" href="<?= $url; ?>/css/bootstrap/bootstrap.min.css">

    <link rel="stylesheet" href="<?= $url; ?>/css/custom.css">

    <!-- Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js"></script>

    <body>
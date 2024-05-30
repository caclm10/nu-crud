<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($title) && $title ? $title . " - " : "") . "NU-CRUD" ?></title>

    <link rel="stylesheet" href="/assets/css/app.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="header__main">
                <a href="/" class="main-title">NU-CRUD</a>
            </div>
        </div>

        <div class="container">
            <nav class="header__nav">
                <a href="/index.php" class="<?= $request->getPath() == "/home" ? 'header__link--active' : '' ?>">Home</a>
                <a href="/index.php/barang" class="<?= $request->getPath() == "/barang" ? 'header__link--active' : '' ?>">Barang</a>
            </nav>
        </div>
    </header>

    <div class="main__wrapper">
        <div class="container">
            <main class="main">
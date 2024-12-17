<?php include 'config/app.php'; ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PR-APP | <?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/css/all.css">
    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="assets/img/logo.png" alt="" width="60" height="48" class="d-inline-block align-text-center">
                <span class="mt-2 fw-bold">Project APP</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="dashboard.php">Halaman Utama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="" href="project.php">Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="" href="tenaga_ahli.php">Tenaga Ahli</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <a href="user.php" class="text-dark"><i class="fas fa-user fs-4"></i></a>
            </div>
        </div>
    </nav>
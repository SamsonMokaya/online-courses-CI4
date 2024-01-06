<!doctype html>
<html lang="en">
<head>
   <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Online Courses Website</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Online Courses Website</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/">Courses</a>
                </li>
            </ul>
            <div class="d-flex align-items-center"> 
                <?php if (session()->get('isLoggedIn')): ?>
                    <!-- Display user-specific content or actions here when logged in -->
                    <?php $user = session()->get('user'); ?>
                    <p class="navbar-text me-3">Welcome, <?= esc($user['name']) ?>!</p> 
                    <a class="btn btn-outline-primary" href="/logout">Logout</a>
                <?php else: ?>
                    <!-- Display login button or other content for users not logged in -->
                    <a class="btn btn-outline-success me-2" href="/signin">Login</a>
                    <a class="btn btn-outline-secondary" href="/register">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5">

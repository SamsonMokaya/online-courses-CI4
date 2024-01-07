<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        /* Custom styles for the header */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-nav {
            margin-left: auto;
        }

        .navbar-text {
            margin-right: auto;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler-icon {
            background-color: #333; /* Change the color of the toggler icon */
        }

        /* Add additional styles based on your preferences */
    </style>

    <title>Online Courses Website</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Online Courses Website</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex align-items-center mx-auto"> 
                <?php if (session()->get('isLoggedIn')): ?>
                    <!-- Display user-specific content or actions here when logged in -->
                    <?php $user = session()->get('user'); ?>
                    <p class="navbar-text mx-3">Welcome, <?= esc($user['name']) ?>!</p> 
                    <a class="btn btn-outline-primary" href="/logout">Logout</a>
                <?php else: ?>
                    <!-- Display login button or other content for users not logged in -->
                    <a class="btn btn-outline-success me-2" href="/signin">Login</a>
                    <a class="btn btn-outline-secondary" href="/signup">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5">
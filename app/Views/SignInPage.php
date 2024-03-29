<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In page</title>
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Sign In</h3>
                </div>
                <div class="card-body">
                    <!-- Display error if any from the controller -->
                    <?php if(session()->has('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= esc(session('error')) ?>
                        </div>
                    <?php endif ?>

                    <!-- Display validation errors if any -->
                    <?php if(session()->has('errors')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach (session('errors') as $error): ?>
                                <?= esc($error) ?><br>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>

                    <!-- SignIn Form -->
                    <form action="/signIn" method="post">
                        <?= csrf_field() ?>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </form>
                    <!-- End SignIn Form -->

                    <p class="mt-3">
                        <a href="/signup">Sign up here.</a>
                    </p>

                    <p class="mt-3">
                        <a href="/token">Forgot your password?</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

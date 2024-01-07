<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Page</title>
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Password Reset</h3>
                </div>
                <div class="card-body">
                    <!-- Display validation errors if any -->
                    <?php if(session()->has('errors')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach (session('errors') as $error): ?>
                                <?= esc($error) ?><br>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>

                    <!-- Password Reset Form -->
                    <form id="passwordResetForm">
                        <!-- Token -->
                        <div class="mb-3">
                            <label for="token" class="form-label">Token</label>
                            <input type="text" id="token" class="form-control" required>
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" id="newPassword" class="form-control" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="button" class="btn btn-primary" onclick="resetPassword()">Reset Password</button>
                    </form>
                    <!-- End Password Reset Form -->
                    <p class="mt-3">
                        <a href="/signin">Back to sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function resetPassword() {
        var token = $('#token').val();
        var password = $('#newPassword').val();

        $.ajax({
            type: "POST",
            url: "https://password-icp0.onrender.com/reset",
            data: { token: token, password: password },
            success: function (response, textStatus, xhr) {
                console.log(response);
                
                // Check if the status code is 200
                if (xhr.status === 200) {
                    alert("Password reset successfully.");
                    // Redirect to SignInPage or handle as needed
                    window.location.href = "/signin";
                } else {
                    // Handle other status codes if needed
                    alert("An error occurred while resetting the password.");
                }
            },
            error: function () {
                // Handle the case where an error occurred
                alert("An error occurred while resetting the password.");
            }
        });
    }
</script>


</body>
</html>

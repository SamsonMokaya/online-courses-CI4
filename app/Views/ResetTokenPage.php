<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Token Page</title>
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Reset Token</h3>
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

                    <!-- Reset Token Form -->
                    <form id="resetTokenForm">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="button" class="btn btn-primary" onclick="sendResetToken()">Send Reset Token</button>
                    </form>
                    <!-- End Reset Token Form -->
                    <p class="mt-3">
                        <a href="/token">Back to sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function sendResetToken() {
        var email = $('#email').val();

        $.ajax({
            type: "POST",
            url: "https://password-icp0.onrender.com/sendresettoken",
            data: { email: email },
            success: function (response) {
                if (response.code === 200) {
                    alert("A token has been sent to your email. it expires in an hour");
                    // Redirect to PasswordResetPage with the message
                    window.location.href = "/reset";
                } else {
                    // Handle the case where the response status is not 200
                    alert("Failed to send reset token. Please try again.");
                }
            },
            error: function () {
                // Handle the case where an error occurred
                alert("An error occurred while sending the reset token.");
            }
        });
    }
</script>

</body>
</html>

<?php
include "../components/header.php"
    ?>

<style>
    .login-form {
        max-width: 400px;
        margin: 0 auto;
    }

    .login-form input[type="email"]{
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

</style>
<section>
    <div class="container">
        <h2 class="text-center">Forgot password</h2>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form class="login-form" method="post" action="<?php echo base_url . "/verify-otp"; ?>">
                    <div class="form-group my-4">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-outline-danger w-100">Reset Password</button>

                </form>
            </div>
        </div>
    </div>
</section>
<?php
include "../components/footer.php"
    ?>
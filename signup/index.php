<?php
include "../components/header.php"
    ?>

<style>
    .login-form {
        max-width: 400px;
        margin: 0 auto;
    }

    .login-form input[type="email"],
    .login-form input[name="fullName"],
    .login-form input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .login-form button {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .login-form button:hover {
        background-color: #0056b3;
    }

    .login-form .form-group {
        margin-bottom: 20px;
    }
</style>
<section>
    <div class="container">
        <h2 class="text-center">Register</h2>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form class="login-form" method="post" action="<?php echo base_url . "/verify-otp"; ?>">
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>


                    <div class="mt-2">
                        Already have an
                        account, <a class="d-inline" href="<?php echo base_url . "/login"; ?>">Login here</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
<?php
include "../components/footer.php"
    ?>
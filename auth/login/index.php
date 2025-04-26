<?php
include "../../components/header.php";

?>

<style>
    .login-form {
        max-width: 400px;
        margin: 0 auto;
    }

    .login-form input[type="email"],
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


    .forgot-password a {
        color: #007bff;
        text-decoration: none;
        font-size: 14px;
    }

    .forgot-password a:hover {
        text-decoration: underline;
    }
</style>
<section>
    <div class="container">
        <h2 class="text-center">Login</h2>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form class="login-form" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group forgot-password">
                        <a href="<?php echo "/auth/forgot-password"; ?>">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Login</button>


                    <div class="my-4">
                        Don't have an
                        account, <a class="d-inline" href="<?php echo "/auth/signup"; ?>">Register here</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
<?php
include "../../components/footer.php"
    ?>
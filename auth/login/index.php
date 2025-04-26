<?php
include "../../components/header.php";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['full_name'];
            $_SESSION['phone'] = $row['phone'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['is_logged_in'] = true;

            header("Location: /dashboard");
            exit;
        } else {
            $_SESSION['error'] = "Invalid email or password";
            header("Location: /auth/login");
            exit;
        }

    } catch (Exception $e) {
        $_SESSION['error'] = "Something went wrong";
        header("Location: /auth/login");
        exit;
    }
}
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
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group forgot-password">
                        <a href="<?php echo "/auth/forgot-password"; ?>">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>


                    <div class="my-4">
                        Don't have an
                        account, <a class="d-inline" href="<?php echo "/auth/signup"; ?>">Register here.</a>
                    </div>
                    <div class="my-4">
                        Login as a Admin <a class="d-inline" href="<?php echo "/admin/login"; ?>">Click here.</a>
                    </div>

                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php
include "../../components/footer.php"
    ?>
<?php
include "../../components/header.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
function deleteUnverifiedUsersAfter10Minutes($conn)
{
    $now = date("Y-m-d H:i:s");

    $query = "DELETE FROM users 
              WHERE is_verified = 0 
              AND otp_expiry < '$now'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $affected = mysqli_affected_rows($conn);
        echo "$affected unverified user(s) deleted.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


if (isset($_POST["create_account"])) {
    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $role = $_POST['role'];
    $otp = rand(100000, 999999);
    $otp_expiry = date("Y-m-d H:i:s", time() + 600);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($password == $cpassword) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $isUserExist = mysqli_query($conn, $sql);
        if (mysqli_num_rows($isUserExist) > 0) {
            // echo "<script>alert('Username already exists.');</script>";
            header("Location: /auth/login");
            return [
                "status" => "error",
                "message" => "Username already exists"
            ];
        }
        $sql = "INSERT INTO users (full_name, email, phone, password, role,otp,otp_expiry) VALUES ('$fullName', '$email', '$phone', '$hashedPassword','$role', '$otp', '$otp_expiry')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            deleteUnverifiedUsersAfter10Minutes($conn);
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'business.pawanjoshi@gmail.com';
                $mail->Password = $_ENV['GMAIL_APP_PASS'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // ssl
                $mail->Port = 465;

                // Recipients

                $mail->setFrom($email, 'TutorXZ');
                $mail->addAddress($email); // Recipient email

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP for Registration - TutorXZ';
                $mail->Body = "Hi,<br><br>Your OTP is: <strong>$otp</strong><br><br>Valid for 10 minutes.<br><br>Regards,<br>TutorXZ";

                $mail->send();
                echo "<script>alert('OTP sent successfully!');</script>";
                header("Location: /auth/verify-otp.php?email=$email");
                return [
                    "status" => "success",
                    "message" => "OTP sent successfully"
                ];

            } catch (Exception $e) {
                echo "<script>alert('Message could not be sent. Error: {$mail->ErrorInfo}');</script>";
                return [
                    "status" => "error",
                    "message" => "Message could not be sent. Error: {$mail->ErrorInfo}"
                ];
            }


        } else {
            return [
                "status" => "error",
                "message" => "Something went wrong during registration. Please try again."
            ];
        }

    }
}
?>

<style>
    .login-form {
        max-width: 400px;
        margin: 0 auto;
    }

    .login-form input {
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
    <div class="container mb-3">
        <h2 class="text-center">Register</h2>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form class="login-form" method="post">
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" required maxlength="10">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="">
                            <option value="admin">Admin</option>
                            <option value="teacher">Teacher</option>
                            <option value="student">Student</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" id="cpassword" name="cpassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="create_account">Create
                        Account</button>


                    <div class="mt-2">
                        Already have an
                        account, <a class="d-inline" href="<?php echo "/auth/login"; ?>">Login here</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
<?php
include "../../components/footer.php"
    ?>
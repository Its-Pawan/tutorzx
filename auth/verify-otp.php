<?php
include "../components/header.php";


if (isset($_POST['verify'])) {
    $email = $_GET['email'];
    $otp = $_POST['digit1'] . $_POST['digit2'] . $_POST['digit3'] . $_POST['digit4'] . $_POST['digit5'] . $_POST['digit6'];

    if (strlen($otp) == 6) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $user = mysqli_query($conn, $sql);
        if (mysqli_num_rows($user) == 0) {
            echo "<script>alert('Email not exists.');</script>";
            return [
                "status" => "error",
                "message" => "Username already exists"
            ];
        }
        $user = mysqli_fetch_assoc($user);
        $validateOtp = $user['otp'] == $otp;
        $isOtpExpire = strtotime($user['otp_expiry']) < time();
        $updated_at = date("Y-m-d H:i:s");
        if ($validateOtp) {
            if (!$isOtpExpire) {
                // Mark user as verified
                $userId = $user['id'];
                $updateQuery = "UPDATE users SET is_verified = 1, otp = '',otp_expiry='', updated_at = '$updated_at' WHERE id = $userId  AND email = '$email'";
                mysqli_query($conn, $updateQuery);
                // Redirect to login page
                header("Location: ./login");
                // echo "OTP verified successfully. Your account is now active.";
                return [
                    "status" => "success",
                    "message" => "OTP verified successfully. Your account is now active."
                ];

            } else {
                // echo "OTP expired. Please request a new one.";
                return [
                    "status" => "error",
                    "message" => "OTP expired. Please request a new one."
                ];
            }
        } else {
            // echo "Invalid OTP. Please try again.";
            return [
                "status" => "error",
                "message" => "Invalid OTP. Please try again."
            ];
        }
    }

}
?>
<style>
    /* body {
        background: #000;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    } */

    nav {
        display: none !important;
    }

    footer {
        display: none !important;
    }

    .card {
        width: 400px;
        border: none;
        height: 300px;
        box-shadow: 0px 5px 20px 0px #d2dae3;
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: black;
    }

    .card h6 {
        color: red;
        font-size: 20px
    }

    .inputs input {
        width: 40px;
        height: 40px
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0
    }

    .card-2 {
        background-color: #fff;
        padding: 10px;
        width: 350px;
        height: 100px;
        bottom: -50px;
        left: 20px;
        position: absolute;
        border-radius: 5px
    }

    .card-2 .content {
        margin-top: 50px
    }

    .card-2 .content a {
        color: red
    }

    .form-control:focus {
        box-shadow: none;
        border: 2px solid red
    }

    .validate {
        border-radius: 20px;
        height: 40px;
        background-color: red;
        border: 1px solid red;
        width: 140px
    }
</style>
<section class="h-full d-flex justify-content-center align-items-center ">
    <div class="container  d-flex justify-content-center align-items-center">
        <div class="position-relative">
            <div class="text-end my-4">

                <a class="btn btn-danger" href="<?php echo "/"; ?>">
                    <i class="bi bi-arrow-left"></i> Go Home
                </a>
            </div>

            <div class="card p-2 text-center">
                <h6>Please enter the OTP <br> to verify your account</h6>
                <form method="post">
                    <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                        <input class="m-2 text-center form-control rounded" name="digit1" type="text" id="first"
                            maxlength="1" />
                        <input class="m-2 text-center form-control rounded" name="digit2" type="text" id="second"
                            maxlength="1" />
                        <input class="m-2 text-center form-control rounded" name="digit3" type="text" id="third"
                            maxlength="1" />
                        <input class="m-2 text-center form-control rounded" name="digit4" type="text" id="fourth"
                            maxlength="1" />
                        <input class="m-2 text-center form-control rounded" name="digit5" type="text" id="fifth"
                            maxlength="1" />
                        <input class="m-2 text-center form-control rounded" name="digit6" type="text" id="sixth"
                            maxlength="1" />
                    </div>

                    <div class="mt-4"> <button name="verify" type="submit"
                            class="btn btn-danger px-4 validate">Validate</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function (event) {

        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > *[id]');
            for (let i = 0; i < inputs.length; i++) { inputs[i].addEventListener('keydown', function (event) { if (event.key === "Backspace") { inputs[i].value = ''; if (i !== 0) inputs[i - 1].focus(); } else { if (i === inputs.length - 1 && inputs[i].value !== '') { return true; } else if (event.keyCode > 47 && event.keyCode < 58) { inputs[i].value = event.key; if (i !== inputs.length - 1) inputs[i + 1].focus(); event.preventDefault(); } else if (event.keyCode > 64 && event.keyCode < 91) { inputs[i].value = String.fromCharCode(event.keyCode); if (i !== inputs.length - 1) inputs[i + 1].focus(); event.preventDefault(); } } }); }
        } OTPInput();


    });
</script>
<?php
include "../components/footer.php"
    ?>
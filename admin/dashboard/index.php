<?php
require "../../db.php";
include "../components/header.php";
session_start();


if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);  // Clear the error message after it is displayed
}
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: ../../auth/login');
    exit;
}
// if ($_SESSION['role'] !== 'admin') {
//     header('Location: /dashboard');
//     exit;
// }
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$phone = $_SESSION['phone'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if (isset($_POST['update_account'])) {
    $user_id = $_SESSION['user_id'];
    $full_name = $_POST['fullName'];
    $phone = $_POST['phone'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newpassword'];
    $confirmPassword = $_POST['cpassword'];

    if (empty($currentPassword) && empty($newPassword) && empty($confirmPassword)) {
        // User did not want to change password, only update name and phone
        $sql = "UPDATE users SET full_name = ?, phone = ? WHERE id = ? AND email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $full_name, $phone, $user_id, $email);
        if ($stmt->execute()) {
            $_SESSION['username'] = $full_name;
            $_SESSION['phone'] = $phone;
            $_SESSION['success'] = "Account updated successfully.";
            header('Location: /admin/dashboard');
            exit;
        } else {
            $_SESSION['error'] = "Error updating account.";
            header('Location: /dashboard');
            exit;
        }
    } else {
        // User wants to change password too
        // Fetch the current hashed password from database
        $sql = "SELECT password FROM users WHERE id = ? AND email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($currentPassword, $hashedPassword)) {
            if ($newPassword === $confirmPassword) {
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET full_name = ?, phone = ?, password = ? WHERE id = ? AND email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssis", $full_name, $phone, $newHashedPassword, $user_id, $email);
                if ($stmt->execute()) {
                    $_SESSION['username'] = $full_name;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['success'] = "Account and password updated successfully.";
                    header('Location: /dashboard');
                    exit;
                } else {
                    $_SESSION['error'] = "Error updating account.";
                    exit;
                }
            } else {
                $_SESSION['error'] = "New passwords do not match.";
                exit;
            }
        } else {
            $_SESSION['error'] = "Current password is incorrect.";
            exit;
        }
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>

    <style>
        .main-nav {
            display: none;
        }

        footer {
            display: none;
        }

        body {
            background-color: #f8f9fa;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            transition: all 0.3s;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid #4b545c;
        }

        .sidebar-header h3 {
            color: #fff;
            margin-bottom: 0;
        }

        .sidebar-header p {
            color: #adb5bd;
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .nav-link {
            color: #adb5bd;
            padding: 10px 20px;
            margin: 5px 0;
            border-radius: 0;
            transition: all 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff;
            background-color: #495057;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .welcome-card {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .nav-link.active {
            color: #fff;
            background-color: #495057;
        }

        /* /////// form form   */
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

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .sidebar.active {
                margin-left: 0;
            }

            .main-content {
                width: 100%;
                margin-left: 0;
            }

            .main-content.active {
                margin-left: 250px;
                width: calc(100% - 250px);
            }
        }
    </style>
    <div class="dashboard-wrapper">
        <!-- Sidebar Navigation -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-graduation-cap"></i> TutorXZ</h3>
                <p>Welcome back, Admin!</p>
            </div>
            <div class=" d-flex flex-column">

                <ul class="nav flex-column flex-grow-1">
                    <li class="nav-item">
                        <button class="nav-link active w-100 text-start" data-target="overview">
                            <i class="fas fa-tachometer-alt"></i> Overview
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link w-100 text-start" data-target="my-courses">
                            <i class="fas fa-book-open"></i> All Courses
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link w-100 text-start" data-target="add-course">
                            <i class="fas fa-book-open"></i> Add Course
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link w-100 text-start" data-target="edit-profile">
                            <i class="fas fa-user-edit"></i> Edit Profile
                        </button>
                    </li>

                </ul>
                <hr>
                <ul class="nav flex-column ">
                    <li class="nav-item ">
                        <a class="nav-link w-100 text-start" href="/auth/logout" data-target="logut">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><span id="header_title">Overview</span></h2>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-calendar me-2"></i>This Week
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Week</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                    </ul>
                </div>
            </div>
            <div class="content-section active" id="overview">

                <!-- Mobile Toggle Button -->
                <button class="btn btn-dark d-md-none mb-3" type="button" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>



                <!-- Welcome Card -->
                <div class="card welcome-card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="card-title">Welcome back, <?php echo $username ?></h4>
                                <p class="card-text">You have 3 upcoming sessions this week. Your next session is Math
                                    with
                                    Dr.
                                    Smith tomorrow at 10:00 AM.</p>
                                <a href="#" class="btn btn-light">View Schedule</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <img src="https://img.freepik.com/free-photo/young-bearded-man-with-striped-shirt_273609-5677.jpg?t=st=1745646775~exp=1745650375~hmac=777cf9d425205b240fb185caa821f658eb721698567ec1318ae982fb3fe59f8f&w=1060"
                                    alt="Welcome" class="img-fluid w-50 rounded-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-section" id="my-courses">
                <?php
                include "../components/all-courses.php"
                    ?>
            </div>
            <div class="content-section" id="add-course">
                <?php
                include "../components/add-course.php"
                    ?>
            </div>

            <div class="content-section" id="edit-profile">
                <div class="d-flex justify-content-center align-items-center mb-4">
                    <h2>Edit Your Profile</h2>
                </div>
                <form class="login-form" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="fullName" required value="<?php echo $username; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" disabled value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" required maxlength="10" value="<?php echo $phone; ?>">
                    </div>
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" id="currentPassword" name="currentPassword">
                    </div>
                    <div class="form-group">
                        <label for="newpassword">New Password</label>
                        <input type="password" id="newpassword" name="newpassword">
                    </div>
                    <div class="form-group">
                        <label for="cpassword">Confirm New Password</label>
                        <input type="password" id="cpassword" name="cpassword">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="update_account">Update
                        Account</button>
                </form>
            </div>
        </div>
    </div>
    <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
            <div class="toast align-items-center text-white bg-<?php echo isset($_SESSION['success']) ? 'success' : 'danger'; ?> border-0 show"
                role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php
                        echo $_SESSION['success'] ?? $_SESSION['error'];
                        unset($_SESSION['success'], $_SESSION['error']);
                        ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('main-content').classList.toggle('active');
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Get all navigation links
            const navLinks = document.querySelectorAll('.nav-link[data-target]');

            // Add click event listeners to each link
            navLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Get the target section ID
                    const targetId = this.getAttribute('data-target');

                    // Hide all content sections
                    document.querySelectorAll('.content-section').forEach(section => {
                        section.classList.remove('active');
                    });

                    // Show the target section
                    document.getElementById(targetId).classList.add('active');
                    document.getElementById('header_title').innerHTML = this.innerHTML;

                    // Update active state in navigation
                    document.querySelectorAll('.nav-link').forEach(navLink => {
                        navLink.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });

            // Handle logout link separately (no data-target)
            document.querySelector('.nav-link[href="/auth/logout"]').addEventListener('click', function (e) {
                // This would normally redirect to logout, but we'll just show an alert
                e.preventDefault();
                window.location.href = '/auth/logout';
            });


        });
    </script>
    <script src="https://kit.fontawesome.com/01510179d9.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>
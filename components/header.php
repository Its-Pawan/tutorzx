<?php
require __DIR__ . "/../constants.php";
$menuItems = [
    ["name" => "Home", "link" => base_url],
    ["name" => "About", "link" => base_url . "/about"],
    ["name" => "Contact", "link" => base_url . "/contact"],
    ["name" => "Courses", "link" => base_url . "/courses"],
];

$current_page = $_SERVER['REQUEST_URI'];



?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Tuition Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="<?php echo base_url . "/style.css"; ?>">
</head>

<body>
    <!-- <div class="alert alert-dismissible fade show text-white text-center py-3" id="notice-alert" role="alert"
        style="background: linear-gradient(to right, #ff512f, #dd2476); border-radius: 0;">
        <strong>🚀 Big News!</strong> Get 50% off on all courses this week.
        <a href="#" class="text-white fw-bold text-decoration-underline">Enroll Now</a>
        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="alert"
            aria-label="Close"></button>
    </div> 
     <script>
        setTimeout(() => {
            const alert = document.getElementById("notice-alert");
            alert.classList.add("d-none");
        }, 10000);


    </script> -->

    <nav class="navbar navbar-expand-lg bg-white py-3">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center fw-bold text-dark" href="#">
                <span class="fs-4">Tutor<span class="text-danger">XZ.</span></span>
            </a>

            <!-- Navbar Toggle for Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav gap-3">
                    <?php
                    foreach ($menuItems as $item) {
                        $isActive = ($current_page == $item['link']) ? 'active' : '';
                        echo "<li class='nav-item'>
                            <a class='nav-link fw-medium $isActive' href='{$item['link']}'>{$item['name']}</a>
                          </li>";
                    }
                    ?>
                </ul>
            </div>

            <!-- Search, Login, and Signup -->
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-search fs-5 text-dark"></i>
                <span class="border-end pe-3"></span>
                <a href="<?php echo base_url . "/login"; ?>" class="text-dark text-decoration-none fw-medium">Login</a>
                <a href="<?php echo base_url . "/signup"; ?>" class="btn btn-danger fw-bold px-4">GET STARTED</a>
            </div>
        </div>
    </nav>
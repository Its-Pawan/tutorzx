<?php
include "../components/header.php"
    ?>

<?php
$path = basename($_SERVER['REQUEST_URI']);
echo $path;
include "../components/footer.php"
    ?>
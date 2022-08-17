<?php
    require './app/loader.php';

    Base::HTTPS();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        // Load in metadata and plugin CSS
        Part::Head();
    ?>
</head>
<body>
    

    <?php
        // Load in plugin JS
        Part::Footer();
    ?>
</body>
</html>
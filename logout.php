<?php
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
    echo '<p><a href="index.php">Index</a></p>';
    header("Location: index.php");
    exit();
?>

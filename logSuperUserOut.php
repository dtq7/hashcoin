<?php

  session_start();

  unset($_SESSION['loggedInAsSuperUser']);

  session_destroy();

  header('Location: ./adminPanel.php');
  exit();

 ?>
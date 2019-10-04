<?php
spl_autoload_register(function ($class_name) {
  require URL_SYSTEM.'classes/'.$class_name . '.class.php';
});
?>
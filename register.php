<?php
spl_autoload_register(function ($class_name) {

  $dir_classes = URL_SYSTEM . 'classes/';
  $diretorios = array('');

  //procurando diretorios
  $diretorio = dir($dir_classes);
  while ($arquivo = $diretorio->read()) {
    if ($arquivo == '.' || $arquivo == '..')
      continue;
    if (is_dir($dir_classes . $arquivo)) {
      $diretorios[] = $arquivo . '/';
    }
  }
  $diretorio->close();

  foreach ($diretorios as $dir) {
    $file =  $dir_classes . $dir . $class_name . '.class.php';
    if (file_exists($file)) {
      require $file;
    }
  }
});

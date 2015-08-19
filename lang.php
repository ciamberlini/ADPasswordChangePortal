<?php
$messages = null;

function msg($s) {
  global $LANG;
  global $messages;

  if ($messages==null) {
    $messages=array();
    foreach (glob('lang/lang-*.dat') as $file_name) {
      $data = json_decode(file_get_contents($file_name),true);
      foreach ($data as $l => $items) {
        $messages[$l] = $items;
      }
    }
  }

  if ($s == '') { return ''; }
  if (isset($messages[$LANG][$s])) {
    return $messages[$LANG][$s];
  } else {
    error_log("l10n error:LANG:" ."$LANG,message:'$s'");
    return $s;
  }
}

function show_file($file) {
  $file_name = msg($file."_file");
  include $file_name;
}

?>

<?php global $config; ?>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo $LANG;?>">
<head profile="http://gmpg.org/xfn/11">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php printf(msg('title'),$config['enterprise_name']);?></title>
  <link rel="stylesheet" type="text/css" media="all" href="style.css"/>
  <link rel="stylesheet" type="text/css" media="all" href="form.css"/>
</head>
<body>
<div id='container'>
  <div id='header'>
    <h1><?php printf(msg('title'),$config['enterprise_name']);?></h1>
  </div>
  <div id='navigation'>
    <ul>
      <li><a href="index.php"><?php echo msg('index_link');?></a></li>
      <li><a href="help.php"><?php echo msg('help_link');?></a></li>
    </ul>
  </div>
  <div id='content'>

<?php
/*
 * This file is part of ad-change-pass.
 * 
 * ad-change-pass is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * ad-change-pass is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with ad-change-pass.  If not, see <http://www.gnu.org/licenses/>.
 */

  require_once '\htmlpurifier-4.6.0\library\HTMLPurifier.auto.php';

  include 'config.php';
  include 'functions.php';
  include 'lang.php';
  include 'header.php';

  $purifyConfig = HTMLPurifier_Config::createDefault();
  $purifyConfig->set('Core', 'Encoding', 'UTF-8');
  $purifyConfig->set('HTML', 'TidyLevel', 'heavy' );
  $purifyConfig->set('Core.DefinitionCache', null);
  $purifier = new HTMLPurifier($purifyConfig);

  $username='';
  $password='';
  if (isset($_POST['username'])) {
    $username=ldapspecialchars($_POST['username']);
    $username=$purifier->purify($username);
  }
  if (isset($_POST['password'])) {
    $password=$_POST['password'];
  }
  if (isset($_POST['np1'])) {
    $np1=$_POST['np1'];
  }
  if (isset($_POST['np2'])) {
    $np2=$_POST['np2'];
  }
  if ($username!='') {
    $is_auth = check_pass($username,$password);
    if ($is_auth!=null) {
      if ($np1 == $np2) {
        $result = change_pass($username,$np1);
	if ($result=="") {
	  notice(msg('password_changed'));
	} else {
	  notice($result);
	  notice(msg('password_change_failed'));
	}
      } else {
        notice(msg('wrong_new_pass'));
        include 'form-chpass.php';
      }
    } else {
      notice(msg('wrong_pass'));
      include 'form-chpass.php';
    }
  } else {
    include 'form-chpass.php';
  }
?>
<?php
  include 'footer.php';
?>

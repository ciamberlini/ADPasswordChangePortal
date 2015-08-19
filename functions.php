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

  $ldap_connection = null;

  function ldapspecialchars($string) {
    $sanitized=array('\\' => '\5c',
                       '*' => '\2a',
		       '(' => '\28',
		       ')' => '\29',
		       "\x00" => '\00');
    return str_replace(array_keys($sanitized),array_values($sanitized),$string);
  }

  function notice($msg) {
    ?><div style='color:#FF0000'><?php echo $msg;?></div><?php
  }

  function get_ldap_connection($user,$pass) {
    global $config;
    global $ldap_connection;

    $ldap_connection = ldap_connect($config['ldapServers']);
    ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0);
    if ($ldap_connection) {
      $bind = ldap_bind($ldap_connection, $user.'@'.$config['domain'], $pass);
      if (!$bind) {
        close_ldap_connection();
      }
    }
  }

  function close_ldap_connection() {
    global $ldap_connection;

    @ldap_close($ldap_connection);
    $ldap_connection = null;
  }

  function check_pass($user,$pass) {
    global $ldap_connection;

    close_ldap_connection();
    get_ldap_connection($user,$pass);
    $result = $ldap_connection;
    close_ldap_connection();
    return $result;
  }

  function change_pass($user,$new_pass) {
    global $config;
    global $ldap_connection;

    get_ldap_connection($config['user'],$config['pass']);
    if ($ldap_connection) {
      $filter="(sAMAccountName=$user)";
      $result = ldap_search($ldap_connection,$config['domain_dn'],$filter);
      ldap_sort($ldap_connection,$result,"sn");
      $info = ldap_get_entries($ldap_connection, $result);
      $isLocked = $info[0]["lockoutTime"];
      if ($isLocked > 0 ) {
        return msg('account_locked');
      }
      $userDn = $info[0]["distinguishedname"][0];
      $userdata["unicodePwd"] = iconv("UTF-8", "UTF-16LE", '"' . $new_pass . '"');
      $result = ldap_mod_replace($ldap_connection, $userDn , $userdata);
      if (!$result) {
        return msg(ldap_error($ldap_connection));
      }
    } else {
      return msg("wrong_admin");
    }
    close_ldap_connection();
    return "";
  }

?>

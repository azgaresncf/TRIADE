<?php
/*******************************************************
 **                  IntraMessenger - server          **
 **                                                   **
 **  Copyright:      (C) 2006 - 2015 THeUDS           **
 **  Web:            http://www.theuds.com            **
 **                  http://www.intramessenger.net    **
 **  Licence :       GPL (GNU Public License)         **
 **  http://opensource.org/licenses/gpl-license.php   **
 *******************************************************/

/*******************************************************
 **       This file is part of IntraMessenger-server  **
 **                                                   **
 **  IntraMessenger is a free software.               **
 **  IntraMessenger is distributed in the hope that   **
 **  it will be useful, but WITHOUT ANY WARRANTY.     **
 *******************************************************/

define("_EXTERNAL_AUTHENTICATION_NAME", "Group-Office");

function f_external_authentication($t_user, $t_pass)
{
  GLOBAL $id_connect;
  //
  $t_verif_pass = "Ko";
  $passcr = md5($t_pass);
  //
  require("../common/config/extern.config.inc.php");
  if ( ($extern_dbhost != '') and ($extern_database != '') and ($extern_dbuname != '') )
  {
    // Si Group-Office n'est pas sur le m�me serveur ou la m�me base de donn�e.
    mysqli_close($id_connect);
    require("extern.sql.inc.php");
    $id_connect = $id_connect_extern;
  }
  //
  $requete  = " select LOWER(username), password, auth_md5_pass FROM " . $extern_prefix . "users ";
  $requete .= " WHERE LOWER(username) = '" . $t_user . "' ";
  $requete .= " and enabled = 1 ";
  $result = mysqli_query($id_connect, $requete);
  if (!$result) error_sql_log("[ERR-T40a]", $requete);
  if ( mysqli_num_rows($result) == 1 )
  {
    list ($login_extern, $pass_extern, $auth_pass) = mysqli_fetch_row ($result);
    if ( ($login_extern == $t_user) and ($pass_extern == $passcr) )
    {
      if (md5($t_user . ":" . $passcr) == $auth_pass)
        $t_verif_pass = "OK";
    }
    //
  }
  if ( ($extern_dbhost != '') and ($extern_database != '') and ($extern_dbuname != '') )
  {
    mysqli_close($id_connect_extern);
    require("sql.2.inc.php");
  }
  //
  return $t_verif_pass;
}


function f_extern_name_of_user($t_user)
{
  GLOBAL $id_connect;
  //
  $family_and_first_name = "";
  //
  require("../common/config/extern.config.inc.php");
  if ( ($extern_dbhost != '') and ($extern_database != '') and ($extern_dbuname != '') )
  {
    // Si groupoffice n'est pas sur le m�me serveur ou la m�me base de donn�e.
    mysqli_close($id_connect);
    require("extern.sql.inc.php");
    $id_connect = $id_connect_extern;
  }
  //
  $requete  = " select LOWER(username), last_name, first_name FROM users ";
  $requete .= " WHERE LOWER(username) = '" . $t_user . "' ";
  $result = mysqli_query($id_connect, $requete);
  if (!$result) error_sql_log("[ERR-T40b]", $requete);
  if ( mysqli_num_rows($result) == 1 )
  {
    list ($login_extern, $extern_familyname, $extern_firstname) = mysqli_fetch_row ($result);
    if ($login_extern == $t_user)
      $family_and_first_name = ucfirst(trim($extern_firstname)) . " " . strtoupper(trim($extern_familyname));
      //$family_and_first_name = trim($extern_firstname) . " " . trim($extern_familyname);
    //
  }
  if ( ($extern_dbhost != '') and ($extern_database != '') and ($extern_dbuname != '') )
  {
    mysqli_close($id_connect_extern);
    require("sql.2.inc.php");
  }
  //
  return $family_and_first_name;
}

?>
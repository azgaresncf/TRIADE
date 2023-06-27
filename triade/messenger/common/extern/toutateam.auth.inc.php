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

define("_EXTERNAL_AUTHENTICATION_NAME", "Toutateam");

function f_external_authentication($t_user, $t_pass)
{
  GLOBAL $id_connect;
  //
  $t_verif_pass = "Ko";
  $passcr = crypt($t_pass, $t_user);
  //
  require("../common/config/extern.config.inc.php");
  if ( ($extern_dbhost != '') and ($extern_database != '') and ($extern_dbuname != '') )
  {
    // Si Toutateam n'est pas sur le m�me serveur ou la m�me base de donn�e.
    mysqli_close($id_connect);
    require("extern.sql.inc.php");
    $id_connect = $id_connect_extern;
  }
  //
  $requete  = " select LOWER(loginname), pw FROM " . $extern_prefix . "users ";
  $requete .= " WHERE LOWER(loginname) = '" . $t_user . "' ";
  //$requete .= " and status = 'Active' ";
  $result = mysqli_query($id_connect, $requete);
  if (!$result) error_sql_log("[ERR-T30a]", $requete);
  if ( mysqli_num_rows($result) == 1 )
  {
    list ($login_extern, $pass_extern) = mysqli_fetch_row ($result);
    if ( ($login_extern == $t_user) and ($pass_extern == $passcr) )
      $t_verif_pass = "OK";
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
    // Si toutateam n'est pas sur le m�me serveur ou la m�me base de donn�e.
    mysqli_close($id_connect);
    require("extern.sql.inc.php");
    $id_connect = $id_connect_extern;
  }
  //
  $requete  = " select LOWER(loginname), nachname, vorname FROM users ";
  $requete .= " WHERE LOWER(loginname) = '" . $t_user . "' ";
  $result = mysqli_query($id_connect, $requete);
  if (!$result) error_sql_log("[ERR-T30b]", $requete);
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
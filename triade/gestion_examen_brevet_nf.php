<?php
session_start();
/***************************************************************************
 *                              T.R.I.A.D.E
 *                            ---------------
 *
 *   begin                : Janvier 2000
 *   copyright            : (C) 2000 E. TAESCH - T. TRACHET - 
 *   Site                 : http://www.triade-educ.com
 *
 *
 ***************************************************************************/
/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
?>
<HTML>
<HEAD>
<META http-equiv="CacheControl" content = "no-cache">
<META http-equiv="pragma" content = "no-cache">
<META http-equiv="expires" content = -1>
<meta name="Copyright" content="Triade©, 2001">
<LINK TITLE="style" TYPE="text/CSS" rel="stylesheet" HREF="./librairie_css/css.css">
<script language="JavaScript" src="./librairie_js/verif_creat.js"></script>
<script language="JavaScript" src="./librairie_js/lib_defil.js"></script>
<script language="JavaScript" src="./librairie_js/clickdroit.js"></script>
<script language="JavaScript" src="./librairie_js/function.js"></script>
<script language="JavaScript" src="./librairie_js/lib_css.js"></script>
<title>Triade - Compte de <?php print $_SESSION["nom"]." ".$_SESSION["prenom"] ?></title>
</head>
<body id='bodyfond' marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" onload="Init();" >
<?php 
include_once("./librairie_php/lib_licence.php");
include_once('librairie_php/db_triade.php');
validerequete("menuadmin");
$cnx=cnx();
?>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre].".js'>" ?></SCRIPT>
<?php include("./librairie_php/lib_defilement.php"); ?>
</TD><td width="472" valign="middle" rowspan="3" align="center">
<div align='center'><?php top_h(); ?>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre]."1.js'>" ?></SCRIPT>
<table border="0" cellpadding="3" cellspacing="1" width="100%" bgcolor="#0B3A0C" height="85">
<tr id='coulBar0' ><td height="2"><b><font   id='menumodule1' >
<?php print "Fiche Brevet série collège"?></font></b></td>
</tr>
<tr id='cadreCentral0'>
<td >
<br><br>

<table align="center">
<form method="post" action="gestion_examen_brevet_config_classe2.php" target="_blank" onsubmit="return valide_consul_classe()" name="formulaire" >
<tr>
<td align=right><font class="T2"><?php print "Config. matières en " ?>
<select id="saisie_classe" name="saisie_classe">
<option id='select0' ><?php print LANGCHOIX?></option>
<?php
select_classe(); // creation des options
?>
</select>:</font> </td>
<td align=left><script language=JavaScript> buttonMagicSubmit("<?php print LANGBREVET1 ?>","create"); //text,nomInput</script></td>
</tr>
</form>

<tr><td height=10></td></tr>
<!-- 
<tr>
<td align=right><font class="T2"><?php print "Affectation des coefficients " ?> :</font></td>
<td align=left><script language=JavaScript>buttonMagic("<?php print LANGBREVET1 ?>","gestion_examen_brevet_config_classe3.php",'_parent','','');</script></td>
</tr>

<tr><td height=10></td></tr>

<tr>
<td align=right><font class="T2"><?php print "Imprimer Brevet " ?> :</font></td>
<td align=left><script language=JavaScript>buttonMagic("<?php print LANGBREVET1 ?>","gestion_examen_impr_brevet_college.php",'_parent','','');</script></td>
</tr>
 -->
<tr><td height=10></td></tr>
<tr>
<td align=right><font class="T2"><?php print "Imprimer Brevet" ?> :</font></td>
<td align=left><script language=JavaScript>buttonMagic("<?php print LANGBREVET1 ?>","gestion_examen_impr_brevet_college_2011.php",'_parent','','');</script></td>
</tr>
<tr><td height=10></td></tr>
<tr>
<td align=right><font class="T2"><?php print "Saisie commentaire Brevet" ?> :</font></td>
<td align=left><script language=JavaScript>buttonMagic("<?php print LANGBREVET1 ?>","brevet_commentaire_admin.php",'_parent','','');</script></td>
</tr>

</table>
<br><br>


<!-- // fin form -->
</td></tr></table>
</ul>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre]."2.js'>" ?></SCRIPT>
<?php Pgclose(); ?>
</BODY>
</HTML>

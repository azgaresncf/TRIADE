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
<?php include_once("./common/config5.inc.php"); header('Content-type: text/html; charset='.CHARSET); ?>
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
<title>Triade - Compte de <?php print "$_SESSION[nom] $_SESSION[prenom] "?></title>
</head>
<body id='bodyfond' marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" onload="Init();" >
<?php 
include("./librairie_php/lib_licence.php"); 
// connexion (après include_once lib_licence.php obligatoirement)
include_once("librairie_php/db_triade.php");
if ($_SESSION["membre"] == "menupersonnel") {
	$cnx=cnx();
	if (!verifDroit($_SESSION["id_pers"],"cahiertextes")) {
		accesNonReserveFen();
		exit();
	}
	Pgclose();
}else{
	validerequete("2");	
}
$cnx=cnx();
?>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre].".js'>" ?></SCRIPT>
<?php include("./librairie_php/lib_defilement.php"); ?>
</TD><td width="472" valign="middle" rowspan="3" align="center">
<div align='center'><?php top_h(); ?>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre]."1.js'>" ?></SCRIPT>
<table border="0" cellpadding="3" cellspacing="1" width="100%" bgcolor="#0B3A0C" height="85">
<tr id='coulBar0' ><td height="2"><b><font   id='menumodule1' ><?php print LANGPROF37 ?></font></b></td></tr>
<tr id='cadreCentral0'>
<td >
<!-- // debut form  -->
<blockquote>
<form method=post onsubmit="return valide_consul_classe()" name="formulaire" action="cahiertext_visu_global.php" target="devoir" >
<BR>
<font class="T2"><?php print LANGCARNET2 ?> : </font><select id="saisie_classe" name="saisie_classe">
<option STYLE='color:#000066;background-color:#FCE4BA'><?php print LANGCHOIX ?></option>
<?php
select_classe(); // creation des options
?>
                               </select> <BR><br>
<UL><UL><UL>
<script language=JavaScript>buttonMagicSubmit("<?php print LANGBT28 ?>","consult"); //text,nomInput</script>
<br><br>
</UL></UL></UL>
</form>
<?php
if ($_SESSION["membre"] != "menuscolaire") { ?>
<br><br>
<form method=post action="cahiertext.php" name="formulaire1" onsubmit="return valide_choix_pers('<?php print " un enseignant" ?>')" >
<font class="T2"><?php print LANGBULL3 ?> :</font>
                 <select name='anneeScolaire' >
                 <?php
		 $anneeScolaire=$_COOKIE["anneeScolaire"];
                 filtreAnneeScolaireSelectNote($anneeScolaire,8);
                 ?>
                 </select><br><br>

<font class="T2"><?php print "Nom de l'enseignant " ?>  :</font> <select name="saisie_pers">
             <option   STYLE='color:#000066;background-color:#FCE4BA'><?php print LANGCHOIX?></option>
<?php
select_personne_2('ENS','25'); // creation des options
?>
</select>

 <BR><br>
<UL><UL><UL>
<script language=JavaScript>buttonMagicSubmit("<?php print LANGBT28 ?>","consult"); //text,nomInput</script>
<br><br>
</UL></UL></UL>
<?php } ?>

 </blockquote>
 </form>
<br>


<hr><br>

<ul>
<form name=formulaire_55 method="post" action='cahiertexteexport.php'>
<font class="T2"><?php print LANGBULL3 ?> :</font>
                 <select name='anneeScolaire' >
                 <?php
		 $anneeScolaire=$_COOKIE["anneeScolaire"];
                 filtreAnneeScolaireSelectNote($anneeScolaire,8);
                 ?>
                 </select><br><br>
<table><tr><td><font class='T2'> <?php print "Exportation au format Word :" ?> </font></td><td><script language=JavaScript>buttonMagicSubmit("<?php print LANGMESS240 ?>","export");</script></td></tr></table>
</form>
</ul>
<br><br>
<!-- // fin form -->
 </td></tr></table>

<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre]."2.js'>" ?></SCRIPT>
<?php
// deconnexion en fin de fichier
Pgclose();
?>
</BODY>
</HTML>

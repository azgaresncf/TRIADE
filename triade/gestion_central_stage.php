<?php
session_start();
/***************************************************************************
 *                              T.R.I.A.D.E
 *                            ---------------
 *
 *   begin                : Janvier 2000
 *   copyright            : (C) 2000 E. TAESCH - T. TRACHET 
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
<script language="JavaScript" src="./librairie_js/lib_defil.js"></script>
<script language="JavaScript" src="./librairie_js/clickdroit.js"></script>
<script language="JavaScript" src="./librairie_js/function.js"></script>
<script language="JavaScript" src="./librairie_js/lib_css.js"></script>
<title>Triade - Compte de <?php print "$_SESSION[nom] $_SESSION[prenom] "?></title>
</head>
<body id='bodyfond' marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" onload="Init();" >
<?php include("./librairie_php/lib_licence.php"); ?>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre].".js'>" ?></SCRIPT>
<?php include("./librairie_php/lib_defilement.php"); ?>
</TD><td width="472" valign="middle" rowspan="3" align="center">
<div align='center'><?php top_h(); ?>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre]."1.js'>" ?></SCRIPT>

<table border="0" cellpadding="3" cellspacing="1" width="100%" bgcolor="#0B3A0C" height="185">
<tr id='coulBar0' ><td height="2"><b><font   id='menumodule1' ><?php print "Gestion des demandes de stage via la centrale des stages"?></font></b></td></tr>
<tr id='cadreCentral0'>
<td valign=top>
<!-- // fin  -->
<iframe width='468' height='100%' src="gestionsouhaitcentral.php" name='centralstage' MARGINWIDTH=0 MARGINHEIGHT=0 HSPACE=0 VSPACE=0 FRAMEBORDER=0 SCROLLING=no ></iframe>
</td></tr></table>
<br><br><br>

<table border="0" cellpadding="3" cellspacing="1" width="100%" bgcolor="#0B3A0C" height="85">
<tr id='coulBar0' ><td height="2"><b><font   id='menumodule1' ><?php print "Gestion de la centrale des stages"?></font></b></td></tr>
<tr id='cadreCentral0'>
<td valign=top>
<!-- // fin  -->
<br><br>
<table border=0 align=center >
<?php  if (!file_exists("./common/config.centralStageClient.php")) { ?>

	<tr> 
	<form action='gestion_central_stage_actif.php' method='post'>
	<td align=right><font class="T2"><?php print "Activer/Désactiver votre centrale de stage" ?> :</font></td>
	<td align=left><script language=JavaScript>buttonMagicSubmit("<?php print "Accès" ?>","rien");</script></td>
	</form>
	</tr>
	<tr><td height='10'></td></tr>

<?php } ?>

<?php  if (file_exists("./common/config.centralStage.php")) { ?>
	<tr>
	<form action='gestion_central_stage_demande.php' method='post'>
	<td align=right><font class="T2"><?php print "Gestion des demandes d'affiliation " ?> :</font></td>
	<td align=left><script language=JavaScript>buttonMagicSubmit("<?php print LANGBT28 ?>","rien"); </script></td>
	</form>
	</tr>
	<tr><td height='10'></td></tr>
	<tr>
	<form action='gestion_central_stage_planification.php' method='post'>
	<td align=right><font class="T2"><?php print "Gestion des planifications des périodes de stage " ?> :</font></td>
	<td align=left><script language=JavaScript>buttonMagicSubmit("<?php print "Accès" ?>","rien"); //text,nomInput</script></td>
	</form>
	</tr>
	<tr><td height='10'></td></tr>
<?php  } ?>

<?php if (!file_exists("./common/config.centralStage.php")) { ?>
	<tr>
	<form action='gestion_central_stage_consulter.php' method='post'>
	<td align=right><font class="T2"><?php print "S'affilier à une centrale de stage" ?> :</font></td>
	<td align=left><script language=JavaScript>buttonMagicSubmit("<?php print LANGBT19 ?>","rien"); //text,nomInput</script></td>
	</form>
	</tr>
	<tr><td height='10'></td></tr>
	<tr>
	<tr>
	<form action='gestion_central_stage_client.php' method='post'>
	<td align=right><font class="T2"><?php print "Valider votre accréditation à une centrale de stage" ?> :</font></td>
	<td align=left><script language=JavaScript>buttonMagicSubmit("<?php print LANGBT19 ?>","rien"); //text,nomInput</script></td>
	</form>
	</tr>
	<tr><td height='10'></td></tr>
	<tr>
<?php  } ?>
<?php  if (file_exists("./common/config.centralStageClient.php")) { ?>
	<form action='gestion_central_stage_export.php' method='post'>
	<td align=right><font class="T2"><?php print "Transmettre les entreprises à la centrale" ?> :</font></td>
	<td align=left><script language=JavaScript>buttonMagicSubmit("<?php print LANGBT19 ?>","rien"); //text,nomInput</script></td>
	</form>
	</tr>
	<tr><td height='10'></td></tr>
<?php  } ?>
</table>
<br><br>

<!-- // fin  -->
</td></tr></table>


<?php
       // Test du membre pour savoir quel fichier JS je dois executer
       if (($_SESSION["membre"] == "menuadmin") || ($_SESSION["membre"] == "menuscolaire")):
            print "<SCRIPT language='JavaScript' ";
            print "src='./librairie_js/".$_SESSION[membre]."2.js'>";
            print "</SCRIPT>";
       else :
            print "<SCRIPT language='JavaScript' ";
            print "src='./librairie_js/".$_SESSION[membre]."22.js'>";
            print "</SCRIPT>";

            top_d();

            print "<SCRIPT language='JavaScript' ";
            print "src='./librairie_js/".$_SESSION[membre]."33.js'>";
            print "</SCRIPT>";

       endif ;
?>
</BODY></HTML>

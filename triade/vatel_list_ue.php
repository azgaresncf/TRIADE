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
<LINK TITLE="style" TYPE="text/CSS" rel="stylesheet" HREF="librairie_css/css.css">
<script language="JavaScript" src="librairie_js/verif_creat.js"></script>
<script language="JavaScript" src="librairie_js/lib_defil.js"></script>
<script language="JavaScript" src="librairie_js/clickdroit.js"></script>
<script language="JavaScript" src="librairie_js/function.js"></script>
<script language="JavaScript" src="librairie_js/lib_css.js"></script>
<title>Triade - Compte de <?php print "$_SESSION[nom] $_SESSION[prenom] "?></title>
</head>
<body id='bodyfond' marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" onLoad="Init();" >
<?php include("librairie_php/lib_licence.php"); ?>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre].".js'>" ?></SCRIPT>
<?php include("librairie_php/lib_defilement.php"); ?>
</TD><td width="472" valign="middle" rowspan="3" align="center">
<div align='center'><?php top_h(); ?>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre]."1.js'>" ?></SCRIPT>
<form  method="post" name="formulaire">
<table border="0" cellpadding="3" cellspacing="1" width="100%" bgcolor="#0B3A0C" height="85">
<tr id='coulBar0' ><td height="2"><b><font   id='menumodule1' ><?php print LANGMESS346 ?></font></b></td>
</tr>
<tr id='cadreCentral0'>
<td >
<br>
<?php
include_once('librairie_php/db_triade.php');
include("librairie_php/fonctions_vatel.php"); 
$cnx=cnx();
?>
<form method="post" >
&nbsp;&nbsp;&nbsp;<font class="T2"><?php print LANGBULL3?> :</font> <select name='annee_scolaire' onChange="this.form.submit()"  >
<?php
$anneeScolaire=$_COOKIE["anneeScolaire"];
if (isset($_POST["annee_scolaire"])) $anneeScolaire=$_POST["annee_scolaire"];
filtreAnneeScolaireSelectNote($anneeScolaire,3);
?>
</select>
&nbsp;&nbsp;<font class='T2'><?php print LANGMESS347 ?> </font>
<select name='idclasse' onChange="this.form.submit()" >
<option   STYLE='color:#000066;background-color:#FCE4BA'><?php print LANGCHOIX ?></option>
<?php
select_classe($_POST["idclasse"]); // creation des options
?>
</select>

		    </form>
<!-- // fin  -->
<BR>
<?php 
if (isset($_POST["idclasse"])) {  ?>
<br><br>
<table width='100%' style="border-collapse: collapse;" >
<tr><td>

	<table border=1 width='100%' >
	<tr>
	<td bgcolor="yellow"><b><?php print LANGELE4 ?></b></td>
	<td bgcolor="yellow"><b><?php print LANGMESS351 ?></b></td>
	<td bgcolor="yellow"><b><?php print LANGMESS350 ?></b></td>
	<td bgcolor="yellow" align='center' width='1%' ><b><?php print LANGMESS348 ?></b></td>
	<td bgcolor="yellow" align='center' width='1%' ><b><?php print LANGMESS349 ?></b></td>
	</tr>
<?php

$data = vatel_liste_ueViaIdClasse($_POST["idclasse"],$_POST["annee_scolaire"]);
//print_r ($data);
for($i=0;$i<count($data);$i++)  {
	if ($data[$i][1] != "") {
		$classe= Vatel_affUneClasse($data[$i][1]);
		$sem=($data[$i][2] == 0) ? "1&nbsp;et&nbsp;2" : $data[$i][2];
		print "<tr class=\"tabnormal2\" onmouseover=\"this.className='tabover'\" onmouseout=\"this.className='tabnormal2'\" >";
		print "<td>&nbsp;".$classe[0][0]."&nbsp;</td>";
		print "<td>&nbsp;".$sem."&nbsp;</td>";
	        print "<td>&nbsp;".$data[$i][4]."&nbsp;</td>";
		print "<td align=center><input type=button class='bouton2' value=\"Modifier\" onclick=\"open('vatel_modif_ue.php?id=".$data[$i][0]."','_parent','');\" ></td>";
		print "<td align=center><input type=button class='bouton2' value=\"Supprimer\" onclick=\"open('vatel_supp_ue.php?id=".$data[$i][0]."','_parent','');\" ></td>";
		print "</tr>";
        }
}
?></table>
</td></tr>
<tr><td>
<br>
</td></tr></table><br><script language=JavaScript>buttonMagic("<?php print LANGMESS352 ?>","vatel_creat_ue.php","_parent","","");</script><br><br>
<?php brmozilla($_SESSION["navigateur"]); ?>
<?php } ?>
<!-- // fin  -->
</td></tr></table>
</form>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre]."2.js'>" ?></SCRIPT>
<?php
if(isset($_POST["create"])):
	validerequete("menuadmin");
        $cnx=cnx();
	$cr=vatel_create($_POST,'ue');
	$retour= vatel_create_due($_POST['code_matiere'],$cr,'ue_detail');
        Pgclose();
endif;
?>
   </BODY></HTML>

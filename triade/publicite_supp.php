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
<script language="JavaScript" src="./librairie_js/lib_defil.js"></script>
<script language="JavaScript" src="./librairie_js/clickdroit.js"></script>
<script language="JavaScript" src="./librairie_js/function.js"></script>
<script language="JavaScript" src="./librairie_js/info-bulle.js"></script>
<title>Triade - Compte de <?php print "$_SESSION[nom] $_SESSION[prenom] "?></title>
</head>
<body bgcolor="#FAEBD7" marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" onload="Init();" >
<?php include("./librairie_php/lib_licence.php"); ?>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre].".js'>" ?></SCRIPT>

<!-- // texte du menu qui defile   -->
<?php include("./librairie_php/lib_defilement.php"); ?>
<!-- // fin du texte   -->

             </TD><td width="472" valign="middle" rowspan="3" align="center">

             <!--   -->
             <div align='center'><?php top_h(); ?>
             <!--  -->

<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre]."1.js'>" ?></SCRIPT>
<table border="0" cellpadding="3" cellspacing="1" width="100%" bgcolor="#0B3A0C" height="85">
<tr bgcolor="#666666">
<td height="2"> <b><font  color="red"><font  color="#FFFFFF">Suppréssion  bannière de publicité</font></b></td>
</tr>
<tr bgcolor="#CCCCCC">
<td valign=top>
     <!-- // fin  -->
<table border=1 width=100% bgcolor="#FFFFFF" bordercolor="#000000">
<tr>
<td align=center><b>Bannière</b></td>
<td align=center><b>Nom</b></td>
<td align=center width=30%><b>Date d'apparution</b></td>
<td align=center width=10%><b>Supprimer</b></td>
</tr>
<?php
include_once("librairie_php/db_triade.php");
$cnx=cnx();
error($cnx);

if(isset($_POST[create])) {
     $id_supp=$_POST[saisie_id];
     $cr=suppression_publicite($id_supp) ;
     if($cr):
	$today= date ("j M, Y");
        $fichier=fopen("./".REPADMIN."/data/publicite_demande.txt","a+");
	fwrite($fichier,"<font color=red>Le $today : </font> Supprimer une publicité <br><br>");
	fwrite($fichier,"<u>Ecole:</u> ".REPECOLE." <br><br>");
	fwrite($fichier,"<u>Contact:</u> $_SESSION[nom] $_SESSION[prenom]<br><br>");
	fwrite($fichier,"<u>Description:</u> Une publicité est à supprimer (code_banniere=$_POST[saisie_nom]) <br><br>");
	fwrite($fichier,"<u>Ne pas oublier</u> Supprimer l'image du serveur <br><br>");
	fwrite($fichier,"------------------------------------------------------<br><br>");
	fclose($fichier);
					
 //     alertJs("Message(s) supprimé(s) --  Service Triade");
 //     reload_page('messagerie_suppression.php');
     else:
        error(0);
     endif;
}

// enregistrement dans la table
$data=visu_banniere();
// $data :
$j=count($data);
for($i=0;$i<count($data);$i++)
{
?>
<tr  class="tabnormal" onmouseover="this.className='tabover'" onmouseout="this.className='tabnormal'">
<td align=center valign=center>
<A href='#' onMouseOver="AffBulle('<img src=\'../image/publicite/<?php print $data[$i][5]?>\'> '); window.status=''; return true;" onMouseOut='HideBulle()'>Image</A>
</td>
<td align=center valign=top><?php print $data[$i][0]?></td>
<td align=center valign=top><?php print dateForm($data[$i][1])?><br>au<br><?php print dateForm($data[$i][2])?></td>
<td align=center valign=center>
<form method=POST>
<input type=hidden name="saisie_id" value="<?php print $data[$i][6]?>">
<input type=hidden name="saisie_nom" value="<?php print $data[$i][0]?>">
<input type=submit value="Supprimer"  name="create" STYLE="font-family: Arial;font-size:10px;color:#CC0000;background-color:#CCCCFF;font-weight:bold;">
</form>
</td>
</tr>
<tr><td colspan=4>&nbsp;&nbsp;&nbsp;&nbsp;<b>lien :</b> 
<a href="<?php print $data[$i][3]?>" target="_blank"><?php print $data[$i][3]?></a></td></tr>

<?php
}
Pgclose();
?>
</table>
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
<script language="JavaScript">InitBulle("#000000","#FCE4BA","red",1);</script>
</BODY></HTML>
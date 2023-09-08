<?php
session_start();
error_reporting(0);
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
include_once("./librairie_php/lib_licence.php");
include_once("./common/config.inc.php");
include_once("./librairie_php/lib_get_init.php");
$id=php_ini_get("safe_mode");
if ($id != 1) {
	set_time_limit(900);
}
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
<title>Triade - Compte de <?php print "$_SESSION[nom] $_SESSION[prenom] "?></title>
</head>
<body id='bodyfond' marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" onload="Init();" >
<?php include("./librairie_php/lib_attente.php"); ?>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre].".js'>" ?></SCRIPT>
<?php include("./librairie_php/lib_defilement.php"); ?>
</TD><td width="472" valign="middle" rowspan="3" align="center">
<div align='center'><?php top_h(); ?>
<SCRIPT language="JavaScript" <?php print "src='./librairie_js/".$_SESSION[membre]."1.js'>" ?></SCRIPT>
<table border="0" cellpadding="3" cellspacing="1" width="100%" bgcolor="#0B3A0C" height="85">
<tr id='coulBar0' ><td height="2"><b><font   id='menumodule1' ><?php print LANGBULL5?></font></b></td></tr>
<tr id='cadreCentral0'>
<td >
<!-- // fin  --><br> <br>
<?php
include_once('librairie_php/db_triade.php');
$cnx=cnx();
if ($_SESSION["membre"] == "menuprof") {
	$data=aff_enr_parametrage("autorisebulletinprof"); 
	if ($data[0][1] == "oui") {
		validerequete("3");
	}else{
		verif_profp_class($_SESSION["id_pers"],$_POST["saisie_classe"]);
	}
}else{
	validerequete("2");
}
$debut=deb_prog();
$valeur=visu_affectation_detail($_POST["saisie_classe"]);
if (count($valeur)) {

if ($_POST["typetrisem"] == "trimestre") {
	if ($_POST["saisie_trimestre"] == "trimestre1" ) { $textTrimestre="1er TRIMESTRE"; $Trimestre = "1er  TRIMESTRE"; }
	if ($_POST["saisie_trimestre"] == "trimestre2" ) { $textTrimestre="2ieme TRIMESTRE"; $Trimestre = "2ieme TRIMESTRE"; }
	if ($_POST["saisie_trimestre"] == "trimestre3" ) { $textTrimestre="3ieme TRIMESTRE"; $Trimestre = "3ieme TRIMESTRE"; }
}

if ($_POST["typetrisem"] == "semestre") {
	if ($_POST["saisie_trimestre"] == "trimestre1" ) { $textTrimestre="1er SEMESTRE";$Trimestre = "1er  SEMESTRE"; }
	if ($_POST["saisie_trimestre"] == "trimestre2" ) { $textTrimestre="2ieme SEMESTRE";$Trimestre = "2ieme SEMESTRE"; }
}

// recupe du nom de la classe
$data=chercheClasse($_POST["saisie_classe"]);
$classe_nom=$data[0][1];
// recup année scolaire
$anneeScolaire=$_POST["annee_scolaire"];
?>
<ul>
<font class="T2">
      <?php print LANGBULL27?> : <?php print ucwords($textTrimestre)?><br> <br>
      <?php print LANGBULL28?> : <?php print $classe_nom?><br> <br>
      <?php print LANGBULL29?> : <?php print $anneeScolaire?><br /><br />
</font>
</ul>

<?php

if ($_POST["type_pdf"] == "mail"){
	$texte_email="<ul><form method='post' action='envoi_bulletin_mail.php'><table >";
}

include_once('librairie_php/recupnoteperiode.php');

// recuperation des coordonnées
// de l etablissement
$data=visu_param();
for($i=0;$i<count($data);$i++) {
       $nom_etablissement=trim($data[$i][0]);
       $adresse=strtolower(trim($data[$i][1]));
       $postal=trim($data[$i][2]);
       $ville=strtolower(trim($data[$i][3]));
       $tel=trim($data[$i][4]);
       $mail=trim($data[$i][5]);
       $directeur=trim($data[$i][6]);
       $urlsite=trim($data[$i][7]);
}
// fin de la recup


// recherche des dates de debut et fin
//$dateRecup=recupDateTrim($_POST["saisie_trimestre"]);
$dateRecup=recupDateTrimByIdclasse($_POST["saisie_trimestre"],$_POST["saisie_classe"]);
for($j=0;$j<count($dateRecup);$j++) {
	$dateDebut=$dateRecup[$j][0];
	$dateFin=$dateRecup[$j][1];
}
$dateDebut=dateForm($dateDebut);
$dateFin=dateForm($dateFin);

$idClasse=$_POST["saisie_classe"];
$ordre=ordre_matiere_visubull($_POST["saisie_classe"]); // recup ordre matiere
// creation PDF
//
define('FPDF_FONTPATH','./librairie_pdf/fpdf/font/');
include_once('./librairie_pdf/fpdf/fpdf.php');
include_once('./librairie_pdf/html2pdf.php');



$noteMoyEleG=0; // pour la moyenne de l'eleve general
$coefEleG=0; // pour la moyenne de l'eleve general
$eleveT=recupEleve($_POST["saisie_classe"]); // recup liste eleve


$nbeleve=0;

$idprofp=rechercheprofp($_POST["saisie_classe"]);
$profp=recherche_personne2($idprofp);


$pdf=new PDF();  // declaration du constructeur

include_once('./librairie_pdf/fpdf_merge.php');
$merge=new FPDF_Merge();


for($j=0;$j<count($eleveT);$j++) {  // premiere ligne de la creation PDF
	// variable eleve
	$nomEleve=strtoupper($eleveT[$j][0]);
	$prenomEleve=ucwords($eleveT[$j][1]);
	$lv1Eleve=$eleveT[$j][2];
	$lv2Eleve=$eleveT[$j][3];
	$idEleve=$eleveT[$j][4];

	$pdf->AddPage();
	$pdf->SetTitle("Bulletin - $nomEleve $prenomEleve");
	$pdf->SetCreator("T.R.I.A.D.E.");
	$pdf->SetSubject("Bulletin de notes $textTrimestre "); 
	$pdf->SetAuthor("T.R.I.A.D.E. - www.triade-educ.com"); 

	// declaration variable
	$coordonne3="Maternelle - Primaire - Secondaire / Nursery - Primary - Secondary";
	$coordonne0=$adresse;
	$coordonne0.=" - ".$postal." - ".ucwords($ville)." - France";
	$coordonne1="Tel : ".$tel;
	$coordonne2="$urlsite";



	$nomEleve=strtoupper(trim($nomEleve));
	$prenomEleve=trim($prenomEleve);
	$nomprenom="<b>$nomEleve</b> $prenomEleve";
	$nomprenom=trunchaine($nomprenom,30);

	$infoeleve=LANGBULL31." : $nomprenom";
	$infoeleve2=LANGELE4." : ";
	$infoeleveclasse=$classe_nom;

	// FIN variables



	// mise en place du logo
	$photo=recup_photo_bulletin_idsite(chercheIdSite($_POST["saisie_classe"]));
        if (count($photo) > 0) {
                $logo="./data/image_pers/".$photo[0][0];
		if (file_exists($logo)) {
                        $xlogo=25;
                        $ylogo=25;
                        $xcoor0=30;
                        $ycoor0=3;
                        $pdf->Image($logo,3,3,$xlogo,$ylogo);
                }

	}else{
		$logo="./image/banniere/banniere-montessori.jpg";
		if (file_exists($logo)) {
			$xlogo=70;
			$ylogo=32;
			$xcoor0=30;
			$ycoor0=-1;
			$pdf->Image($logo,5,5,$xlogo,$ylogo);
		}
	}
	// fin du logo
	//

	// Debut création PDF
	// mise en place des coordonnées
	$Y=10;
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(80,$Y);
	$pdf->MultiCell(90,3,$coordonne3,0,'C',0);
	$pdf->SetXY(80,$Y+=3);
	$pdf->MultiCell(90,3,$coordonne0,0,'C',0);
	$pdf->SetXY(80,$Y+=3);
	$pdf->MultiCell(90,3,$coordonne1,0,'C',0);
	$pdf->SetXY(80,$Y+=3);
	$pdf->MultiCell(90,3,$coordonne2,0,'C',0);

	$pdf->SetFont('Arial','B',12);
	$pdf->SetXY(2,$Y+=19);
	$pdf->MultiCell(206,18,"",1,'C',0);
	$pdf->SetXY(3,$Y+=1);
	$pdf->MultiCell(204,16,"",1,'C',0);
	$pdf->SetXY(2,$Y+=1);
	if ($_POST["typetitre"] == "primaire") {
		$pdf->MultiCell(206,5,"Classe Primaire / Primary Class",0,'C',0);
	}else{
		$pdf->MultiCell(206,5,"Classe Maternelle / Kindergarten Class",0,'C',0);
	}
	$pdf->SetFont('Arial','',12);
	$pdf->SetXY(2,$Y+=5);
	$pdf->MultiCell(206,5,"Année Scolaire - School Year $anneeScolaire",0,'C',0);
	$pdf->SetXY(2,$Y+=5);
	$pdf->MultiCell(206,5,"Bulletin $textTrimestre / Report $textTrimestre",0,'C',0);
	$pdf->SetXY(2,$Y+=5);

	
	


	// adresse de l'élève
	// elev_id, nomtuteur, prenomtuteur, adr1, code_post_adr1, commune_adr1, adr2, code_post_adr2, commune_adr2, numeroEleve, class_ant, date_naissance, regime, civ_1, civ_2,nomEleve,prenomEleve
	$dataadresse=chercheadresse($idEleve);
	for($ik=0;$ik<count($dataadresse);$ik++) {
		$nomtuteur=$dataadresse[$ik][1];
		$prenomtuteur=$dataadresse[$ik][2];
		$adr1=$dataadresse[$ik][3];
		$code_post_adr1=$dataadresse[$ik][4];
		$commune_adr1=$dataadresse[$ik][5];
		$numero_eleve=$dataadresse[$ik][9];
		$datenaissance=$dataadresse[$ik][11];
		if ($datenaissance != "") {  $datenaissance=dateForm($datenaissance); }
		$regime=$dataadresse[$ik][12];
		$class_ant=trim(trunchaine($dataadresse[$ik][10],20));
		$age=age($datenaissance);
	 }
		$Xv1=2;
		$Yv1=$Y+=5;
		$pdf->SetFont('Arial','',12);
		$pdf->SetXY($Xv1,$Yv1); 
		$pdf->WriteHTML("<b>NOM </b> : $nomEleve $prenomEleve");
		$pdf->SetXY($Xv1+140,$Yv1);			
		$pdf->WriteHTML("Age : $age ans <i>($datenaissance)</i>");
		$pdf->SetXY($Xv1,$Yv1+=8);
		$pdf->WriteHTML("<b>Classe</b> : $classe_nom ");
		$pdf->SetXY($Xv1+100,$Yv1);			
	//	$pdf->WriteHTML("Professeur : $profp");
 
	

	// Mise en place des matieres
	$Xmat=2;
	$Ymat=$Y+15;
	$ii=0;

	$largeurMat=206;
	$hauteurMatiere=40;

	for($i=0;$i<count($ordre);$i++) {
		$matiere=chercheMatiereNom($ordre[$i][0]);
		$idMatiere=$ordre[$i][0];
		$idprof=recherche_prof($idMatiere,$idClasse,$ordre[$i][2]);
		$profAff=recherche_personne2($idprof);
		$verifGroupe=verifMatiereAvecGroupe($ordre[$i][0],$idEleve,$idClasse,$ordre[$i][2]);

		if ($verifGroupe) {  continue; } // verif pour l'eleve de l'affichage de la matiere

   		// recupe de l'id du groupe //idMatiere,$idEleve,$idClasse
    		$idgroupe=verifMatierAvecGroupeRecupId($idMatiere,$idEleve,$idClasse,$ordre[$i][2]);
	
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY($Xmat,$Ymat);
		$pdf->SetFillColor(240);  // couleur du cadre de l'eleve
		$pdf->MultiCell($largeurMat,$hauteurMatiere,'',1,'L',0);
		$pdf->SetXY($Xmat+1,$Ymat);
		$pdf->WriteHTML('<u>'.trunchaine(strtoupper(sansaccent(strtolower($matiere))),80).'</u> : '.$profAff.'');
	
		// mise en place des commentaires
		$commentaireeleve=cherche_com_eleve($idEleve,$idMatiere,$idClasse,$_POST["saisie_trimestre"],$idprof,$idgroupe);
		$commentaireeleve=preg_replace('/\n/'," ",$commentaireeleve);
		$confPolice=confPolice($commentaireeleve);  // $confPolice[0] -> poli ; $confPolice[1] -> cad
		$pdf->SetFont('Arial','',10);
		$pdf->SetXY($Xmat+1,$Ymat+5);
		$pdf->MultiCell(200,3.5,$commentaireeleve,'','','L',1);

		$Xmat=2;
		$Ymat=$Ymat+$hauteurMatiere;

		if ($Ymat >= 250) {
			$pdf->AddPage();
			$Xmat=2;
			$Ymat=10;
		}
	
}
// fin de la mise en place des matiere


// fin notes
// --------


// cadre appréciation
$Ycom=$Ymat;
$Xcom=$Xmat;
$hauteurcom=20;
$Yappreciation=$Ycom+1;
$pdf->SetXY($Xcom,$Ycom);
$pdf->MultiCell($largeurMat,$hauteurcom,'',1,'',0);
$pdf->SetXY($Xcom+2,$Ycom+1);
$pdf->SetFont('Arial','',8);
$datedujour=dateDMY();
$pdf->WriteHTML("Date :  $datedujour <br><br>                                                             Signature du Professeur                                                                        Signature de la Directrice");


// ----------------------------------------------------------------------------------------------------------------------
$classe_nom=TextNoAccent($classe_nom);
$classe_nom=TextNoCarac($classe_nom);
$nomEleve=TextNoCarac($nomEleve);
$nomEleve=TextNoAccent($nomEleve);
$prenomEleve=TextNoCarac($prenomEleve);
$prenomEleve=TextNoAccent($prenomEleve);
$classe_nom=preg_replace('/\//',"_",$classe_nom);
$nomEleve=preg_replace('/\//',"_",$nomEleve);
$prenomEleve=preg_replace('/\//',"_",$prenomEleve);
if (!is_dir("./data/pdf_bull/$classe_nom")) { mkdir("./data/pdf_bull/$classe_nom"); }
$fichier=urlencode($fichier);
$fichier="./data/pdf_bull/$classe_nom/bulletin_".$nomEleve."_".$prenomEleve."_".$_POST["saisie_trimestre"].".pdf";
@unlink($fichier); // destruction avant creation
$pdf->output('F',$fichier);
$pdf->close();
bulletin_archivage($_POST["saisie_trimestre"],$anneeScolaire,$fichier,$idEleve,$classe_nom,$nomEleve,$prenomEleve);
if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') { $merge->add("$fichier"); }
$listing.="$fichier ";
$pdf=new PDF();
} // fin du for on passe à l'eleve suivant
$merge->output("./data/pdf_bull/$classe_nom/liste_complete.pdf");
if (strtoupper(substr(PHP_OS, 0, 3)) != 'WIN') {
	$cmd="gs -q -dNOPAUSE -sDEVICE=pdfwrite -sOUTPUTFILE=./data/pdf_bull/$classe_nom/liste_complete.pdf -dBATCH $listing";
	$null=system("$cmd",$retval);
}
include_once('./librairie_php/pclzip.lib.php');
@unlink('./data/pdf_bull/'.$classe_nom.'.zip');
$archive = new PclZip('./data/pdf_bull/'.$classe_nom.'.zip');
$archive->create('./data/pdf_bull/'.$classe_nom,PCLZIP_OPT_REMOVE_PATH, 'data/pdf_bull/');
$fichier='./data/pdf_bull/'.$classe_nom.'.zip';
$bttexte="Récupérer le fichier ZIP des bulletins";
@nettoyage_repertoire('./data/pdf_bull/'.$classe_nom);
@rmdir('./data/pdf_bull/'.$classe_nom);
// --------------------------------------------------------------------------------------------------------------------------
?>
<br><ul><ul>
<input type=button onclick="open('visu_pdf_bulletin.php?id=<?php print $fichier?>&idclasse=<?php print $_POST["saisie_classe"] ?>','_blank','');" value="<?php print $bttexte ?>"  STYLE="font-family: Arial;font-size:10px;color:#CC0000;background-color:#CCCCFF;font-weight:bold;">
</ul></ul>
<?php // ----------------------------------------------------------------------------------------------------------------------------   ?>


<br /><br />
<?php
// gestion d'historie
@destruction_bulletin($fichier,$classe_nom,$_POST["saisie_trimestre"],$dateDebut,$dateFin);
$cr=historyBulletin($fichier,$classe_nom,$_POST["saisie_trimestre"],$dateDebut,$dateFin);
if($cr == 1){
	history_cmd($_SESSION["nom"],"CREATION BULLETIN","Classe : $classe_nom");
}else{
	error(0);
}
Pgclose();
?>

<?php
}else {
?>
<br />
<center>
<?php print LANGMESS14?> <br>
<br><br>
<font size=3><?php print LANGMESS15?><br>
<br>
<?php print LANGMESS16?><br>
</center>
<br /><br /><br />
<?php
        }
?>
<!-- // fin  -->
</td></tr></table>
<script language=JavaScript>attente_close();</script>
<?php
// Test du membre pour savoir quel fichier JS je dois executer
if ($_SESSION["membre"] == "menuadmin") :
print "<SCRIPT language='JavaScript' ";
print "src='./librairie_js/".$_SESSION["membre"]."2.js'>";
print "</SCRIPT>";
else :
print "<SCRIPT language='JavaScript' ";
print "src='./librairie_js/".$_SESSION["membre"]."22.js'>";
print "</SCRIPT>";
top_d();
print "<SCRIPT language='JavaScript' ";
print "src='./librairie_js/".$_SESSION["membre"]."33.js'>";
print "</SCRIPT>";
endif ;
?>
</BODY></HTML>
<?php
$cnx=cnx();
fin_prog($debut);
Pgclose();
?>

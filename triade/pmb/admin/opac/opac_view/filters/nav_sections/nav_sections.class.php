<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: nav_sections.class.php,v 1.6 2017-10-27 13:39:50 ngantier Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

global $class_path,$base_path,$include_path;

class nav_sections {    
    public function __construct($id_vue,$local_msg) {
    	$this->id_vue=$id_vue;
    	$this->path="nav_sections";
    	$this->msg=$local_msg;
    	$this->fetch_data();    	   	
    }
    
    public function fetch_data() {
		global $dbh;
			
		$this->selected_list=array();
		$req="SELECT * FROM opac_filters where opac_filter_view_num=".$this->id_vue." and  opac_filter_path='".$this->path."' ";
		$myQuery = pmb_mysql_query($req, $dbh);
		if(pmb_mysql_num_rows($myQuery)){
			$r=pmb_mysql_fetch_object($myQuery);
			$param=unserialize($r->opac_filter_param);
			$this->selected_list=$param["selected"];
		}				
		$myQuery = pmb_mysql_query("SELECT * FROM docs_location order by location_libelle ", $dbh);
		$this->liste_item=array();
		$link="";
		$i=0;
		if(pmb_mysql_num_rows($myQuery)){
			while(($r=pmb_mysql_fetch_object($myQuery))) {
				$this->liste_item[$i]=new stdClass();
				$this->liste_item[$i]->id=$r->idlocation;
				$this->liste_item[$i]->name=$r->location_libelle ;
				if(in_array($r->idlocation,$this->selected_list))	$this->liste_item[$i]->selected=1;
				else $this->liste_item[$i]->selected=0;				
				$i++;			
			}	
		}
		return true;
 	}
       
	public function get_all_elements(){	
		return $this->ids;
	}
    	
	public function get_elements(){		
		return $this->all_ids;
	}		
	
	public function get_form(){
		global $msg;
		global $tpl_liste_item_tableau,$tpl_liste_item_tableau_ligne;
		
		global $class_path,$base_path,$include_path;

		require_once($base_path."/admin/opac/opac_view/filters/nav_sections/nav_sections.tpl.php");
		
		// liste des lien de recherche directe
		$liste="";
		// pour toute les recherche de l'utilisateur
		$liste_id = array();
		
		for($i=0;$i<count($this->liste_item);$i++) {
			$liste_id[] = 'nav_sections_selected_'.$this->liste_item[$i]->id;
			if ($i % 2) $pair_impair = "even"; else $pair_impair = "odd";			
	        $td_javascript=" ";
	        $tr_surbrillance = "onmouseover=\"this.className='surbrillance'\" onmouseout=\"this.className='".$pair_impair."'\" ";
	
	        $line = str_replace('!!td_javascript!!',$td_javascript , $tpl_liste_item_tableau_ligne);
	        $line = str_replace('!!tr_surbrillance!!',$tr_surbrillance , $line);
	        $line = str_replace('!!pair_impair!!',$pair_impair , $line);
	
			$line =str_replace('!!id!!', $this->liste_item[$i]->id, $line);
			if($this->liste_item[$i]->selected) $checked="checked";else $checked="";			
			$line =str_replace('!!selected!!', $checked, $line);
			$line = str_replace('!!name!!', $this->liste_item[$i]->name, $line);
			
			$liste.=$line;
		}
		$tpl_liste_item_tableau = str_replace('!!lignes_tableau!!',$liste , $tpl_liste_item_tableau);
		
		if (count($liste_id)) {
			$tpl_liste_item_tableau .= "<input type='button' class='bouton_small align_middle' value='".$msg['tout_cocher_checkbox']."' onclick='check_checkbox(\"".implode("|",$liste_id)."\",1);'>";
			$tpl_liste_item_tableau .= "<input type='button' class='bouton_small align_middle' value='".$msg['tout_decocher_checkbox']."' onclick='check_checkbox(\"".implode("|",$liste_id)."\",0);'>";
		}
		
		return $tpl_liste_item_tableau;
	}	
	
	public function save_form(){
		global $dbh;

		$req="delete FROM opac_filters where opac_filter_view_num=".$this->id_vue." and  opac_filter_path='".$this->path."' ";
		$myQuery = pmb_mysql_query($req, $dbh);
		
		$param=array();
		$selected_list=array();
		for($i=0;$i<count($this->liste_item);$i++) {
			eval("global \$nav_sections_selected_".$this->liste_item[$i]->id.";
			\$selected= \$nav_sections_selected_".$this->liste_item[$i]->id.";");
			if($selected){
				$selected_list[]=$this->liste_item[$i]->id;
			}
		}
		$param["selected"]=$selected_list;
		$param=addslashes(serialize($param));		
		$req="insert into opac_filters set opac_filter_view_num=".$this->id_vue." ,  opac_filter_path='".$this->path."', opac_filter_param='$param' ";
		$myQuery = pmb_mysql_query($req, $dbh);
	}	
	
}
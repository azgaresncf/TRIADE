<?php
// +-------------------------------------------------+
// | 2002-2007 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: authority_page_collection.class.php,v 1.2 2018-07-26 15:25:52 tsamson Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");


require_once($class_path."/authorities/page/authority_page.class.php");

/**
 * class authority_page_collection
 * Controler d'une page d'une autorité collection
 */
class authority_page_collection extends authority_page {
	/**
	 * Constructeur
	 * @param int $id Identifiant de la collection
	 */
	public function __construct($id) {
	$this->id = $id*1;
		$query = "select collection_id from collections where collection_id = ".$this->id;
		$result = pmb_mysql_query($query);
		if($result && pmb_mysql_num_rows($result)){
			//$this->authority = new authority(0, $this->id, AUT_TABLE_COLLECTIONS);
			$this->authority = authorities_collection::get_authority('authority', 0, ['num_object' => $this->id, 'type_object' => AUT_TABLE_COLLECTIONS]);
		}
	}
	
	protected function get_title_recordslist() {
		global $msg, $charset;
		return htmlentities($msg['available_docs_in_coll'], ENT_QUOTES, $charset);
	}
	
	protected function get_clause_authority_id_recordslist() {
		return "coll_id=".$this->id;
	}
	
	protected function get_mode_recordslist() {
		return "coll_see";	
	}
	
}

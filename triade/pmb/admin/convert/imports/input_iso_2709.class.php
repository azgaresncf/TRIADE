<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: input_iso_2709.class.php,v 1.1 2018-07-25 06:19:18 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once ($base_path."/admin/convert/convert_input.class.php");

class input_iso_2709 extends convert_input {

	public function _get_n_notices_($fi,$file_in,$input_params,$origine="") {
		//pmb_mysql_query("delete from import_marc");
		global $charset;
		global $output_params;
		$index=array();
		$n=1;
		eval("\$car=chr(".$input_params['ENDCHAR'].");");
		$i=false;
		$notice="";
		$notices="";
		while (!feof($fi)) {
			$notices.=fread($fi,4096);
			$i=strpos($notices,$car);
			while ($i!==false) {
				$notice=substr($notices,0,$i+1);
				$t=array();
				$t['POS']=$n_;
				$t['LENGHT']=$i+1;
				$requete="insert into import_marc (no_notice, notice, origine) values($n,'".addslashes($notice)."','$origine')";
				pmb_mysql_query($requete);
				$index[]=$t;
				if($n==1){
					$iso=new iso2709_record($notice);
					$output_params["CHARSET"]=$iso->is_utf8?"utf-8":$charset;
				}
				$n++;
				$notices=substr($notices,$i+1);
				$i=strpos($notices,$car);
			}
		}
		if ($notices!="") {
			$notice=$notices;
			$t=array();
			$t['POS']=$n_;
			$t['LENGHT']=$i+1;
			$requete="insert into import_marc (no_notice, notice, origine) values($n,'".addslashes($notice)."','$origine')";
			pmb_mysql_query($requete);
			$index[]=$t;
			$n++;
		}
		return $index;
	}
}
<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: word.class.php,v 1.1 2018-07-25 06:19:18 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once($base_path."/admin/convert/convert.class.php");

class word extends convert {
	
	public static function convert_data($notice, $s, $islast, $isfirst, $param_path) {
		global $rtf_pattern;
	
		if ($rtf_pattern == "") {
			$f_rtf = fopen("admin/convert/imports/$param_path/".$s['RTFTEMPLATE'][0]['value'], "rt");
			if (!$f_rtf) die( "pb d'ouverture: "."admin/convert/imports/$param_path/".$s['RTFTEMPLATE'][0]['value'] ) ;
			
			while (!feof($f_rtf)) {
				$line = fgets($f_rtf, 4096);
				if ($line === false) die( "pb de lecture: "."admin/convert/imports/$param_path/".$s['RTFTEMPLATE'][0]['value'] ) ;
				if (strpos($line, "!!START!!") !== false) {
					break;
				}
			}
			//Lecture du pattern
			while (!feof($f_rtf)) {
				$line = fgets($f_rtf, 4096);
				if (strpos($line, "!!STOP!!") === false) {
					$rtf_pattern.= $line;
				} else
					break;
			}
			fclose($f_rtf);
		}
		$t_notice = explode(";", $notice);
		$r_ = str_replace("!!TITLE!!", $t_notice[0], $rtf_pattern);
		$r_ = str_replace("!!AUTHOR!!", $t_notice[1], $r_);
		$r['VALID'] = true;
		$r['ERROR'] = "";
		$r['DATA'] = $r_;
		return $r;
	}
}

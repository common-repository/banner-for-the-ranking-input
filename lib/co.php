<?
function banner_start() {
	require_once($GLOBALS["plugin_root_for_banner"]."lib/banner_calss.php");
	$banner_calssObj=new banner_calss();
	$mode=$_POST['banner_mode'];
	if($mode==NULL || $mode==""){
		$mode="default";
	}
	
	switch($mode){
		case "default":
			$csvLines=$banner_calssObj->banner_getData($GLOBALS["banner_path"]);
			require_once($GLOBALS["plugin_root_for_banner"]."page/default.php");
		break;
		case "add_data":
			list($error_flg,$error_strings,$addData)=$banner_calssObj->banner_chk_value($_POST);
			if($error_flg){
				list($error_flg,$error_strings)=$banner_calssObj->banner_addData($addData,$GLOBALS["banner_path"]);
			}
			$csvLines=$banner_calssObj->banner_getData($GLOBALS["banner_path"]);
			require_once($GLOBALS["plugin_root_for_banner"]."page/default.php");
		break;
		case "edit_data":
			list($error_flg,$error_strings,$addData)=$banner_calssObj->banner_chk_value($_POST);
			if($error_flg){
				list($error_flg,$error_strings)=$banner_calssObj->banner_editData($addData,$GLOBALS["banner_path"],$_POST["banner_num"]);
			}
			$csvLines=$banner_calssObj->banner_getData($GLOBALS["banner_path"]);
			require_once($GLOBALS["plugin_root_for_banner"]."page/default.php");
		break;
		case "delete_data":
			list($error_flg,$error_strings)=$banner_calssObj->banner_deleteData($GLOBALS["banner_path"],$_POST["banner_num"]);
			$csvLines=$banner_calssObj->banner_getData($GLOBALS["banner_path"]);
			require_once($GLOBALS["plugin_root_for_banner"]."page/default.php");
		break;
	}
}
?>
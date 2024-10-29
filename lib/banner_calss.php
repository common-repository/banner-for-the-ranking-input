<?
class banner_calss{

	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// 	Member
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// 	Constructor
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		function banner_calss() {

		}
	// **********************************************************************************************
	// 	チェック
	// **********************************************************************************************
		function banner_chk_value($tempArray){
			$error_strings="";
			$chk=true;
			$tempArray["banner_name"]=$this->banner_Delspace($tempArray["banner_name"]);
			//$tempArray["banner_url"]=$this->banner_Delspace($tempArray["banner_url"]);
			if($tempArray["banner_name"]==""){
				$error_strings.="バナー名称を入力してください<br>";
				$chk=false;
			}
			if($tempArray["banner_url"]==""){
				$error_strings.="バナーのタグを入力してください<br>";
				$chk=false;
			}
			return array($chk,$error_strings,$tempArray);
		}
	// **********************************************************************************************
	// 	データ格納
	// **********************************************************************************************
		function banner_addData($tempArray,$path){
			foreach($tempArray as $k=>$v){
				$tempArray[$k]=str_replace(",","++replace_text++",$v);
			}
			$exist=true;
			if(!file_exists($path)){
				$exist=false;
			}else{
				$size=filesize($path);
			}
			if($size>4 && $exist){
				if( $handle = fopen($path, 'a')){
						fputs( $handle,"\r\n".$tempArray["banner_name"].",".htmlspecialchars($tempArray["banner_url"]));
				}
			}else{
				if( $handle = fopen($path, 'w')){
						fputs( $handle,$tempArray["banner_name"].",".htmlspecialchars($tempArray["banner_url"]));
				}
			}
			return array(true,"データを追加しました。");
		}
	// **********************************************************************************************
	// 	データ変更
	// **********************************************************************************************
		function banner_editData($tempArray,$path,$num){
			$dataArray=$this->banner_getData($path);
			$fileinput="";
			$count=count($dataArray);
			foreach($dataArray as $k=>$v){
				if($k!=0){
					$fileinput.="\r\n";
				}
				if($k!=$num){
					foreach($v as $kk=>$vv){
						if($kk==0){
							$fileinput.=$vv.",";
						}else{
							$fileinput.=$vv;
						}
					}
				}else{
					$fileinput.=$tempArray["banner_name"].",".htmlspecialchars($tempArray["banner_url"]);
				}
			}
			if( $handle = fopen($path, 'w')){
				fputs( $handle,$fileinput);
			}
			return array(true,"データを変更しました。");
		}
	// **********************************************************************************************
	// 	データ削除
	// **********************************************************************************************
		function banner_deleteData($path,$num){
			$dataArray=$this->banner_getData($path);
			$fileinput="";
			$count=count($dataArray);
			foreach($dataArray as $k=>$v){
				if($k!=$num){
					if($k!=0){
						$fileinput.="\r\n";
					}
					foreach($v as $kk=>$vv){
						if($kk==0){
							$fileinput.=$vv.",";
						}else{
							$fileinput.=$vv;
						}
					}
				}else{
					//$fileinput.=$tempArray["banner_name"].",".$tempArray["banner_url"];
				}
			}
			if( $handle = fopen($path, 'w')){
				fputs( $handle,$fileinput);
			}
			return array(true,"データを変更しました。");
		}
	// **********************************************************************************************
	// フォーム作成
	// **********************************************************************************************
		function makeForm($path){
			$formData="";
			$tempData=$this->banner_getData($path);
			if(is_array($tempData) && count($tempData)>0){
				$formData.='<SELECT name="bannerpull" id="bannerpull">';
				foreach($tempData as $k=>$v){
					$v[1]=str_replace("\\","",$v[1]);
					$formData.='<OPTION value="'.$v[1].'">'.$v[0].'</OPTION>';
				}
				$formData.='</SELECT>';
				$formData.='<input type="button" value="タグを表示する" onClick="document.getElementById(\'banner_url_out\').value=document.getElementById(\'bannerpull\').options[document.getElementById(\'bannerpull\').selectedIndex].value;">';
				$formData.='<textarea cols="70" rows="5" name="banner_url" id="banner_url_out"></textarea>';
			}else{
				$formData.="ランキングバナーの登録がありません。";
			}
			return $formData;
		}
	// **********************************************************************************************
	// 	データ取得
	// **********************************************************************************************
		function banner_getData($path){
			$csvLines=array();
			if(file_exists($path)){
				$handle = fopen($path, "r");
				$row = 0;
				while (($data = $this->banner_fgetcsv_reg($handle)) !== false) {
					$_enc_to=mb_internal_encoding();
					$_enc_from=mb_detect_order();
					mb_convert_variables($_enc_to,$_enc_from,$data);
					$num = count($data);
					for ($c=0; $c < $num; $c++) {
						$csvLines[$row][]=$data[$c];
					}
			        $row++;
			    }
			    fclose($handle);
			}
			return $csvLines;
		}
	// **********************************************************************************************
	// fgetcsv_reg
	// **********************************************************************************************		
		function banner_fgetcsv_reg (&$handle, $length = null, $d = ',', $e = '"') {
			$d = preg_quote($d);
			$e = preg_quote($e);
			$_line = "";
			while ($eof != true) {
				$_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
				$itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy);
				if ($itemcnt % 2 == 0) $eof = true;
			}
			$_csv_line = preg_replace('/(?:\r\n|[\r\n])?$/', $d, trim($_line));
			$_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
			preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
			$_csv_data = $_csv_matches[1];
			for($_csv_i=0;$_csv_i<count($_csv_data);$_csv_i++){
				$_csv_data[$_csv_i]=preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
				$_csv_data[$_csv_i]=str_replace($e.$e, $e, $_csv_data[$_csv_i]);
			}
			return empty($_line) ? false : $_csv_data;
		}
	// **********************************************************************************************
	// 	スペースの削除
	// **********************************************************************************************
		function banner_Delspace($temp){
				$temp=trim($temp);
				$temp=mb_ereg_replace("　","",$temp);
				$temp=mb_ereg_replace(" ","",$temp);
				return $temp;
		}
	// **********************************************************************************************
	// 	URL判定
	// **********************************************************************************************
		function banner_url_check($url){
			if (preg_match('/^(http|HTTP|ftp)(s|S)?:\/\/+[A-Za-z0-9]+\.[A-Za-z0-9]/',$url)){
				return true;
			}
			else{
				return false;
			}
		}
}
?>
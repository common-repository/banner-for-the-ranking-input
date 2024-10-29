<?
require_once($GLOBALS["plugin_root_for_banner"]."lib/default.js");
?>
<div class=wrap>
	<h2>ランキングバナー設定</h2> 
	<?
	if(isset($error_strings) && $error_strings!=""){
	?>
	<em style="color:red;"><?=$error_strings;?></em>
	<?
	}
	?>
	<form method="post" action="options-general.php?page=banner_ranking_input" name="banner_ranking_input_form">
	<input type="hidden" name="banner_mode" value="add_data">
	<input type="hidden" name="banner_num" value="">
	<table class="widefat" style="text-align:center"> 
		<thead> 
			<tr> 
				<th scope="col" style="text-align:left">Num</th> 
				<th scope="col" style="text-align:center">バーナー名称</th> 
				<th scope="col" style="text-align:center">バナーのタグ</th> 
				<th scope="col" style="text-align:center"登録・削除</th> 
			</tr> 
		</thead> 
		<tbody>
			<tr class="alternate"> 
				<td style="text-align:left" id="input_space">
				入力・編集
				</td> 
				<td>
				<input type="text" name="banner_name" value="" size="30">
				</td> 
				<td> 
				<textarea cols="70" rows="5" name="banner_url"></textarea>
				</td> 
				<td> 
				<input type="button" value="登録" id="editbutton" onClick="if(window.confirm('データを送信しますか？')){document.banner_ranking_input_form.submit();}">
				</td> 	
			</tr>
		<?
		if(is_array($csvLines) && count($csvLines)>0){
			foreach($csvLines as $k=>$v){
				?>
				<tr class="alternate"> 
					<td style="text-align:left">
					<?=($k+1);?>
					</td> 
					<td>
					<?=str_replace("++replace_text++",",",htmlspecialchars($v[0]));?>
					</td> 
					<td> 
					<?=str_replace("++replace_text++",",",str_replace("\\","",htmlspecialchars_decode($v[1])));?>
					</td> 
					<td> 
					<input type="button" value="削除" onClick="if(window.confirm('データを削除しますか？')){banner_delete(<?=$k;?>);}">
					</td> 
				</tr>
				<?
			}
		}else{
			?>
			<tr class="alternate"> 
				<td style="text-align:left" colspan="5">
				登録はありません。
				</td> 
			</tr>
			<?
		}
		?>
		</tbody>
	</table>
	</form>
</div>
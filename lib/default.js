<script type="text/javascript"> 
// <![CDATA[
	function banner_edit(name,url,num){
		document.banner_ranking_input_form.banner_name.value=name;
		document.banner_ranking_input_form.banner_url.value=url;
		document.banner_ranking_input_form.banner_num.value=num;
		document.getElementById('editbutton').value='データを更新';
		document.banner_ranking_input_form.banner_mode.value='edit_data';	
	}
	function banner_delete(num){
		document.banner_ranking_input_form.banner_num.value=num;
		document.banner_ranking_input_form.banner_mode.value='delete_data';
		document.banner_ranking_input_form.submit();
	}
// ]]>
</script> 
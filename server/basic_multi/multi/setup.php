<?php
include_once('./_common.php');
include_once('./_function.php');

if(!$is_member)
{
	die();
}

//print_r2($_POST);

if($_POST['mode']=='save' && $_POST['bo_table']) {

	$bo_upload_count= $_POST['bo_upload_count'];
	$bo_upload_size	= ($_POST['bo_upload_size']*1024*1024);
	$bo_1			= $_POST['bo_1'];
	$bo_2			= $_POST['bo_2'];
	$bo_table		= $_POST['bo_table'];

	$sql = "update
				{$g5['board_table']}
			set
				bo_upload_count	= '{$bo_upload_count}',
				bo_upload_size	= '{$bo_upload_size}',
				bo_1			= '{$bo_1}',
				bo_2			= '{$bo_2}'
			where
				bo_table = '{$bo_table}' ";
	sql_query($sql, true);
	$msg->msg = "OK";
	echo json_encode($msg);
	exit;
}
$bo_table = $_GET['bo_table'];;
//print_r2($board);
?>
<link rel="stylesheet" href="<?php echo $board_skin_url; ?>/multi/style.css">
<div id="board_table">
	<form id="frmData">
	<input type="hidden" name="mode" id="mode" value="save" />
	<input type="hidden" name="bo_table" id="bo_table" value="<?php echo $bo_table; ?>" />
	<table>
		<colgroup>
			<col width="*" />
			<col width="15%" />
			<col width="15%" />
		</colgroup>
		<thead>
			<tr>
				<th>구분</th>
				<th>관리자설정값</th>
				<th>서버설정값</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="td_right">1회 업로드 가능한 파일 개수를 입력하세요. (단위 : 개)</td>
				<td><input type="text" name="bo_upload_count" id="bo_upload_count" value="<?php echo $board['bo_upload_count'];?>" /></td>
				<td><?php echo number_format(ini_get("max_file_uploads")); ?><input type="hidden" name="" class="max_file_uploads" value="<?php echo ini_get("max_file_uploads"); ?>" /></td>
			</tr>
			<tr>
				<td class="td_right">1회 업로드 가능한 파일들의 총 사이즈를 입력하세요. (단위 : M)</td>
				<td><input type="text" name="bo_upload_size" id="bo_upload_size" value="<?php echo number_format($board['bo_upload_size']/1024/1024);?>" /></td>
				<td><?php echo ini_get("upload_max_filesize"); ?><input type="hidden" name="upload_max_filesize" class="upload_max_filesize" value="<?php echo ini_get("upload_max_filesize"); ?>" /></td>
			</tr>
			<tr>
				<td class="td_right">업로드 가능한 파일 1개의 사이즈를 입력하세요. (단위 : M)</td>
				<td><input type="text" name="bo_1" id="bo_1" value="<?php echo $board['bo_1'];?>" /></td>
				<td><?php echo ini_get("post_max_size"); ?><input type="hidden" name="post_max_size" class="post_max_size" value="<?php echo ini_get("post_max_size"); ?>" /></td>
			</tr>
			<tr>
				<td class="td_right">게시물별 업로드 가능한 파일의 개수를 입력하세요. (단위 : 개)</td>
				<td><input type="text" name="bo_2" id="bo_2"  value="<?php echo $board['bo_2'];?>" /></td>
				<td>-</td>
			</tr>
		</tbody>
	</table>
	</form>
	<div class="bottom_btn">
		<button type="button" name="save" id="save" class="save">변경 사항 저장</button>
	</div>
</div>
<script>
$(document).ready(function() {

	$("#save").click(function() {

		var bo_upload_count = ($("#bo_upload_count").val()).replace(",","");
		var max_file_uploads =  ($(".max_file_uploads").val()).replace(",","");
		var bo_upload_size = ($("#bo_upload_size").val()).replace(",","");
		var upload_max_filesize = ($(".upload_max_filesize").val()).replace("M","");
		var bo_1 = ($("#bo_1").val()).replace(",","");
		var post_max_size = ($(".post_max_size").val()).replace("M","");

		var msg = chk(1, bo_upload_count, max_file_uploads);
		if(msg) { alert(msg); return $("#bo_upload_count").focus(); }
		var msg = chk(2, bo_upload_size, upload_max_filesize);
		if(msg) { alert(msg); return $("#bo_upload_size").focus(); }
		var msg = chk(3, bo_1, post_max_size);
		if(msg) { alert(msg); return $("#bo_1").focus(); }

		var string = $("#frmData").serializeArray();
		//console.log(string);
		var data = new FormData();
		for(i=0; i < string.length; i++) {
			data.append(string[i]['name'], string[i]['value']);
		}
		var bsu = "<?php echo $board_skin_url; ?>";
		var xhr = new XMLHttpRequest();
		xhr.open("POST", bsu+"/multi/setup.php");
		xhr.responseType = 'txt';
		xhr.onload = function(e) {
			if(xhr.readyState === 4 && xhr.status == 200) {
				var rumi = JSON.parse(xhr.responseText);

				if(rumi.msg=="OK"){
					alert("저장되었습니다.");
				}

			}

		}
		xhr.send(data);
	});

});

</script>

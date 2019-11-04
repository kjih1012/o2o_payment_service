<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once($board_skin_path."/multi/_function.php");

//== 관리자 페이지 게시판 설정 값으로 제한.
$max_files = $board['bo_upload_count']; // 게시판 설정 값 - 1회 최대 전송 가능한 파일 수.
$max_size = $board['bo_upload_size']; // 게시판 설정 값 - 1회 최대 전송 가능한 파일 용량.
$post_max_size = $board['bo_1'];  // 단일 파일 최대 크기.
$upload_total_files  = $board['bo_2']; // 업로드된 파일 및 업로드 하려고 하는 파일들의 총 갯수 제한.

//== 서버 설정값으로 제한. - 서버 설정값으로 사용하려면 게시판 설정값을 주석처리
//$post_max_size = ini_get("post_max_size"); // 단일 파일 업로드 크기
//$max_files = ini_get("max_file_uploads"); // 서버 설정 값 - 1회 최대 전송 가능한 파일 수.
//$max_size = (ini_get("upload_max_filesize")*1204*1024); // 서버 설정 값 - 1회 최대 전송 가능한 파일 용량.
?>
<script type="text/javascript">
var sel_files		= []; // 이미지 정보들을 담을 배열
var total_files		= '<?php echo $upload_total_files;?>'; // 게시물당 총 업로드 가능한 이미지 개수
var max_files		= '<?php echo $max_files; ?>'; // 한번에 등록될 파일 수.
var max_size		= '<?php echo $max_size; ?>'; // 한번에 등록될 용량(1048576byte = 1mb or 1024kb)
var post_max_size	= '<?php echo $post_max_size; ?>'; // 단일 파일 업로드 사이즈 제한.
var wr_id	= '<?php echo $wr_id;?>';
var g5_data_url = '<?php echo G5_DATA_URL; ?>/file';
var board_skin_url = "<?php echo $board_skin_url; ?>";
var board_skin_path = "<?php echo $board_skin_path; ?>";
var g5_path = "<?php echo G5_PATH; ?>";
</script>

<link rel="stylesheet" href="<?php echo $board_skin_url; ?>/multi/style.css">

<!-- jquery -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Lightbox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css" rel="stylesheet" />


<script type="text/ecmascript" src="<?php echo $board_skin_url; ?>/multi/_script.js"></script>
<script type="text/ecmascript" src="<?php echo $board_skin_url; ?>/multi/_function.js"></script>

<div id="multi_upload">

	<div class="input_wrap">
		<input type="hidden" name="t_img" class="t_img" id="t_img" value="" itemname=""/>
		<?php if($wr_id && $w!=="r") { ?>
			<div class="input_wrap">
				<button type="button" class="pic_list all_del">모든 사진 삭제</button>
				<button type="button" class="pic_list img_total">전체 00개의 사진이 있습니다.</button>
			</div>
			<ul class="image_view"><i class='fa fa-volume-down' aria-hidden='true'></i> 등록된 이미지가 없습니다.</ul><!-- 등록된 이미지 출력 -->
			<!-- 첨부파일 시작 { -->
			<section id="bo_v_file">
		        <h2>첨부파일</h2>
		        <ul class="file_list"></ul>
			</section>
		    <!-- } 첨부파일 끝 -->


		<?php } ?>

		<button type="button" class="my_button img_add">파일 찾기</button>
		<button type="button" class="my_button img_empty">파일 비우기</button>
		<!-- <button type="button" class="my_button img_chk" >배열체크</button> -->
		<input type="file" accept="image/*,media_type" id="input_imgs" _capture="image" multiple="multiple" />

	</div>

	<div class="image_info">
		<i class='fa fa-upload' aria-hidden='true'></i> 1회 최대 전송 파일 수 : <span class="max_cnt"><?php echo number_format($max_files); ?></span> 개  ( 현재 <span class="cur_cnt">0</span> 개 선택 )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<i class='fa fa-save' aria-hidden='true'></i> 1회 최대 전송 용량 : <span class="max_size"><?php echo number_format($max_size); ?></span> byte ( 현재 <span class="cur_size">0</span> byte ) (단일 파일 <span class='txt_red'><?php echo $post_max_size; ?></span>M 이하)
	</div>

	<div id="status_progress">
		<progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
		<div class="send_info">
			<span id="status"></span>
			<span id="loaded_n_total"></span>
		</div>
	</div>

	<ul id="sortable" class="imgs_wrap">
		<i class='fa fa-volume-down' aria-hidden='true'></i> 1회 최대 전송 파일수와 1회 최대 전송 용량은 서버 설정에 따라 달라집니다.<br/>
		<i class='fa fa-volume-down' aria-hidden='true'></i> 파일을 선택후 업로드 하기 전에 출력 순서를 변경 할 수 있습니다. (마우스로 파일을 드래그하여 순서를 변경하세요.)<br/>
		<i class='fa fa-volume-down' aria-hidden='true'></i> 이미지 파일 및 워드파일, 엑셀파일, PDF파일등 일반 파일도 함께 선택하여 업로드할 수 있습니다.<br/>
		<i class='fa fa-volume-down' aria-hidden='true'></i> 멀티업로드 게시판은 현재 작업중이므로 오류가 발생할 수 있습니다.<br/>
		<i class='fa fa-volume-down' aria-hidden='true'></i> 업로드 완료된 파일 포함하여 총 <span class='txt_red'><?php echo $board['bo_2']; ?></span>개의 파일을 업로드할 수 있습니다.
	</ul>
</div>
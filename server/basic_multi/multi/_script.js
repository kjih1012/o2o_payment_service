$(document).ready(function() {
		
	var wr_id = $("input[name=wr_id]").val();
	
	// wr_id 값이 있을때만 업로드된 이미지 불러오기
	if(wr_id > 0) {
		setTimeout(function() {
			carPictures("on");
			file_list();
		},100);
	}

	
	// 이미지 업로드 대기열
	$( "#sortable" ).sortable({
			change: function( event, ui ) {
			// console.log(event.srcElement.dataset.file);
			//var new_pic = $(".selProductFile").map(function() {
			//		return $(this).attr("data-file");
			//	}).get();
			//console.log(new_pic);
		}
	});
    $( "#sortable" ).disableSelection();

	
	// 이미지 선택
	$("#input_imgs").on("change", handleImgFileSelect);

	
	// 배열체크
	$(".img_chk").click(function() {
		arr_chk();
	});

	// 파일선택
	$(".img_add").click(function() {
		fileUploadAction();
	});

	// 이미지 비우기
	$(".img_empty").click(function() {
		$(".imgs_wrap").empty();
		sel_files = [];
		$("span.cur_cnt").text(number_format(sel_files.length));
		$("span.cur_size").text(number_format(array_sum(sel_files)));
	});


	// 전체삭제
	$("button.all_del").click(function() {
		var id = $("#wr_id").val();
		pic_Del(id, 0, 2);
	});

	$("button.img_total").click(function() {
		//$("ul.image_view").empty(); // 기존 사진을 모두 제거 (제거후 새로 불러온 사진을 보여줌)
		//setTimeout(function() {
		//	carPictures();
		//},500);

	});

});


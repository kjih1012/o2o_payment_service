
// fond() 함수를 사용할 수 없는 브라우저에서 사용할 수 있도록 해줌.
if (!Array.prototype.find) {
  Object.defineProperty(Array.prototype, 'find', {
    value: function(predicate) {
     // 1. Let O be ? ToObject(this value).
      if (this == null) {
        throw new TypeError('"this" is null or not defined');
      }

      var o = Object(this);

      // 2. Let len be ? ToLength(? Get(O, "length")).
      var len = o.length >>> 0;

      // 3. If IsCallable(predicate) is false, throw a TypeError exception.
      if (typeof predicate !== 'function') {
        throw new TypeError('predicate must be a function');
      }

      // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.
      var thisArg = arguments[1];

      // 5. Let k be 0.
      var k = 0;

      // 6. Repeat, while k < len
      while (k < len) {
        // a. Let Pk be ! ToString(k).
        // b. Let kValue be ? Get(O, Pk).
        // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
        // d. If testResult is true, return kValue.
        var kValue = o[k];
        if (predicate.call(thisArg, kValue, k, o)) {
          return kValue;
        }
        // e. Increase k by 1.
        k++;
      }

      // 7. Return undefined.
      return undefined;
    },
    configurable: true,
    writable: true
  });
}

function chk(x,a,b) {
	console.log(x+' / '+a+' / '+b);
	var msg = "";
	switch(x) {
		case 1:
			msg = "1회 업로드 가능한 파일의 개수가 서버 설정값보다 크면 안됩니다.";
		break;
		case 2:
			msg = "1회 업로드 가능한 파일들의 총 사이즈가 서버 설정값보다 크면 안됩니다.";
		break;
		case 3:
			msg = "업로드 가능한 파일 1개의 사이즈가 서버 설정값보다 크면 안됩니다.";
		break;
	}

	if(parseInt(a) > parseInt(b)) {
		console.log(a+' / '+b);
		return msg;
	}
}


function supports_canvas() {
	return !!document.createElement('canvas').getContext;
}

function layer_popup (width,height) {
    var layer = $('.m_layer');
	var margin_left = (parseInt(width/2)*-1);
	var margin_top = (parseInt(height/2)*-1);
	$(".pop_layer").css({
		"width" : width,
		"height" : height,
		"margin-left" : margin_left,
		"margin-top" : margin_top
	});
    layer.removeClass('hidden');
}

function handleImgFileSelect(e) {
	//console.log("이미 등록된 이미지 갯수: "+sel_files.length);
	


	var sel_files_cnt = sel_files.length; //이미 등록된 이미지가 있는지 확인.

	// 등록된 이미지가 없다면 초기화 진행.
	if(sel_files_cnt == 0) {
		sel_files = []; // 이미지 정보들을 초기화
		$(".imgs_wrap").empty();
		var index = 0;
	} else {
		var index = sel_files_cnt;
	}

	if(index==0) {
		var width = $(".imgs_wrap").width();
		var img_width = '160';// 간격 여백 포함.
		var col = width/img_width;
		var img_t = (width - (img_width * parseInt(col)))/2;
		$(".imgs_wrap").css({"padding-left":(img_t + 15)});
		//console.log(width+'/'+img_width);
		//console.log(col);
		//console.log(img_t);
	}


	// 배열에 들어 있는 파일의 총 용량(byte)
	var arr_sum = array_sum(sel_files);
	var danil_size = (post_max_size * 1024 * 1024); //단일파일크기( M을 byte로 변환)
	var files = e.target.files;
	var filesArr = Array.prototype.slice.call(files);

	// 이미 등록되어 있는 파일과 새로 등록될 파일 수의 합계
	var total_cnt = sel_files_cnt + filesArr.length;
	//console.log('전체 파일 수 : '+total_cnt+' = (선택된 파일 수 : '+sel_files_cnt+') + (추가 선택된 파일 수 : '+filesArr.length+')');

	var cur_cnt = 1;
	var cur_size = 0; // 배열의 합계 
	var over_file = 0; // 등록 가능 파일 수 초과 카운트
	var of = 0; // 중복된 파일 리스트 카운트
	//var ds = 0; // 단일파일사이즈 카운트
	
	var file_check_names = new Array(); // 파일 수 초과된 파일 리스트 배열
	var overlap_files = new Array();
	//var danil_size = new Array(); // 단일 파일 업로드 사이즈 초과한 파일 리스트 배열.
	filesArr.forEach(function(f) {

		// 확장자 체크 - 모든 파일 등록 가능하게 변경.
		//if(!f.type.match("image.*")) {
		//	alert("이미지 파일만 등록 할 수 있습니다.");
		//	return;
		//}

		// 중복선택파일체크 : 선택된 파일중에 이미 선택이 되어 있는지 체크 (이미 업로드된 파일에 대해서는 체크하지 않음)
		var ss = sel_files.find(function(c) {
			return c.name === f.name;
		});
		if(ss!=undefined) {
			//console.log('이미 등록된 파일입니다. [ 파일명 : '+f.name+' ]');
			overlap_files[of] = f.name; // 배열에 담아서 한번에 알려줌.
			of++;
			return;
		}

		// 단일파일 업로드 허용사이즈 초과인지 체크
		if(f.size > danil_size) {
			alert("단일 파일의 업로드 최대 크기는 "+number_format(danil_size)+" byte 입니다.\n [ 파일명 : "+f.name+" ( "+number_format(f.size)+" byte ) ]");
			return;
		}


		// 등록 가능한 최대 파일 수 체크
		if((sel_files_cnt + cur_cnt) > max_files) {
			//console.log((sel_files_cnt+cur_cnt) + ' / ' + max_files);
			//console.log("최대 파일수 초과로 등록 불가");
			//alert("최대 파일수 초과로 등록 불가합니다.\n[ 최대 파일 수 : "+ max_cnt +'개 ]');
			file_check_names[over_file] = f.name;
			//console.log("["+over_file+"] console : "+f.name);
			over_file++
			return;
		}

		// 총 업로드 개수를 초과 하는지 체크. (이미 업로드된 이미지 + 선택된 이미지 + 선택하려고 하는이미지 = 총이미지)
		var t_img = $("#t_img").val();
		var img_cnt = sel_files_cnt + cur_cnt + parseInt(t_img);
		if(img_cnt > total_files) {
			//console.log(img_cnt + ' / ' + total_files);
			//console.log("게시물당 등록 가능한 파일 수를 초과 하였습니다.");
			//alert("게시물당 등록 가능한 최대 파일 수를 초과하였습니다.\n[ 등록 가능 파일 수 : "+total_files+" 개 ]\n[ 등록 불가 파일명 : "+f.name+" ]\n ");
			file_check_names[over_file] = f.name;
			//console.log("["+over_file+"] console : "+f.name);
			over_file++
			return;
		}		
		
		// 용량체크 : 허용가능한 최대 용량 체크
		cur_size = cur_size + f.size; // 용량
		if((arr_sum + cur_size) > max_size) {
			//console.log((arr_sum+f.size) + ' / ' + max_size);
			//console.log("최대 허용 용량 초과로 등록 불가");
			alert("최대 허용 용량이 초과 되었습니다. [ 최대 전송 용량 : "+ parseInt(max_size/1048576) +'MB ]');
			return false;
		}

		//console.log(f);
		// 이미지 리스트 배열에 추가.
		sel_files.push(f);

		var reader = new FileReader();
		reader.onload = function(e) {
			//console.log(e);
			var file_extension = getExtensionOfFilename(f.name);
			// 이미지 파일 과 일반 파일 구분.
			if(f.type.match("image.*")) {
				var html = "<li class='ui-state-default' id=\"img_id_"+index+"\"><div class='del_btn' onclick=\"deleteImageAction("+index+", '"+f.name+"')\" title='이미지 삭제'><i class='fa fa-remove' aria-hidden='true'></i></div><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selProductFile'></li>";
				$(".imgs_wrap").append(html);
			} else {
				var html = "<li class='ui-state-default' id=\"img_id_"+index+"\"><div class='del_btn' onclick=\"deleteImageAction("+index+", '"+f.name+"')\" title='이미지 삭제'><i class='fa fa-remove' aria-hidden='true'></i></div><div data-file='"+f.name+"' class='selProductFile no_image'>"+file_extension+"</div><span class='no_filename'>"+f.name+"</span></li>";
				//var html = "<li class='ui-state-default' id=\"img_id_"+index+"\"><div class='del_btn' onclick=\"deleteImageAction("+index+")\" title='이미지 삭제'><i class='fa fa-remove' aria-hidden='true'></i></div><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selProductFile'></li>";
				$(".imgs_wrap").append(html);
			}
			index++;
		}
		reader.readAsDataURL(f);

		$("span.cur_cnt").text(number_format(sel_files_cnt + cur_cnt));
		$("span.cur_size").text(number_format(arr_sum + cur_size));
		cur_cnt++; // 파일갯수
	});

	//console.log(file_check_names);
	if(file_check_names.length > 0) {
		var f_list = file_check_names.join("\n"); 
		alert("업로드 최대 파일 수가 초과하여 아래의 파일은 제외 되었습니다.\n1회 업로드 : "+max_files+" 개 / 게시물당 업로드 : "+total_files+" 개\n\n"+f_list);
	}

	if(overlap_files.length > 0) {
		var f_list = overlap_files.join("\n"); 
		alert("선택한 파일이 이미 업로드 대기열에 포함되어 있습니다.\n\n"+f_list);
	}
}


function fileUploadAction() {
	//console.log("fileUploadAction");
	$("#input_imgs").trigger('click');
}


// 파일 확장자 추출
function getExtensionOfFilename(filename) {
    var _fileLen = filename.length;
    var _lastDot = filename.lastIndexOf('.'); // 파일이름중에 '.' 존재가능성있기 때문에 마지막을 선택.
    var _fileExt = filename.substring(_lastDot+1, _fileLen).toUpperCase();
   return _fileExt;
}

// 배열의 이미지사이즈(byte) 파일 합계
function array_sum(f) {
	var total = 0;
	for(i=0; i < f.length; i++){
		total += f[i]['size'];
	}
	return total;
}

function deleteImageAction(index, filename) {
	var rst = sel_files.find(function(c) {
		return c.name === filename;
	});
	var idx = sel_files.indexOf(rst);
	sel_files.splice(idx, 1);
	var img_id = "#img_id_"+index;
	$(img_id).remove();
	//console.log(sel_files);
	$("span.cur_cnt").text(number_format(sel_files.length));
	$("span.cur_size").text(number_format(array_sum(sel_files)));
}

function fileUploadAction() {
	//console.log("fileUploadAction");
	$("#input_imgs").trigger('click');
}

function submitAction() {

	//console.log("업로드 파일 갯수 : "+sel_files.length);
	// 이미지 변경 순서 배열 생성.
	var new_pic = $(".selProductFile").map(function() {
						return $(this).attr("data-file");
					}).get();
	//console.log(new_pic);

	if(sel_files.length < 1) {
		alert("등록할 파일을 선택해주세요.");
		return;
	}

	// wr_id 값 체크 - 파일등록시 필수
	var wr_id = $("#wr_id").val();
	if(!wr_id) {
		alert("이미지를 등록할 글번호를 선택해주세요.");
	}


	var data = new FormData(); // 폼데이타배열생성

	for(var i=0, len=sel_files.length; i<len; i++) {

		var name = "image_"+i;

		// 이미지 위치가 변경된 차례대로 data배열에 넣는다.
		var sel =  sel_files.find(function(item) {
			return item.name === new_pic[i];
		});
		//data.append(name, sel_files[i]);
		data.append(name, sel);
	}


	data.append("image_count", sel_files.length); // 파일 갯수 (배열에추가)
	data.append("bo_table", $("#bo_table").val()); // 파일 갯수 (배열에추가)
	data.append("wr_id", wr_id); // 파일 갯수 (배열에추가)

	var xhr = new XMLHttpRequest();

	xhr.upload.addEventListener("progress", progressHandler, false);
	xhr.addEventListener("load", completeHandler, false);
	xhr.addEventListener("error", errorHandler, false);
	xhr.addEventListener("abort", abortHandler, false);

	xhr.responseType = 'json';
	xhr.open("POST", g5_url+"/multi/upload_update.php");
	xhr.onload = function(e) {
		//console.log(e);
		if(this.status == 200) {
			// 전송완료후 처리할 함수 작성.
			
			//console.log('response', this.response);
			//console.log(e.currentTarget.response);
			// 작업이 정상적으로 처리되면 초기화 작업시작.
			$(".imgs_wrap").empty();  // 이미지 업로드 대기열 비우기
			sel_files = []; // 이미지 배열 초기화.
			$("span.cur_cnt").text("0");
			$("span.cur_size").text("0");

			//초기화 완료후 1초지연후에 저장된 사진 불러오기.
			setTimeout(function() {
				carPictures();
			},1000);
		}
	}
	xhr.send(data);
}

function arr_chk() {

	// 이미지 변경 순서 배열 생성.
	var new_pic = $(".selProductFile").map(function() {
						return $(this).attr("data-file");
					}).get();

	console.log(new_pic);
	console.log(sel_files);

	var sss =  sel_files.find(function(item) {
		return item.name === new_pic[0];
	});
	console.log(sss);
}

function progressHandler(event){
	$("#loaded_n_total").html("총 "+number_format(event.total)+" byte 중 "+number_format(event.loaded)+" bytes 보냄");
	var percent = (event.loaded / event.total) * 100;
	$("#progressBar").val(Math.round(percent));
	//_("status").innerHTML = Math.round(percent)+"% 이미지 처리중이니 잠시만 기다리세요.";
	$("span#status").html(Math.round(percent)+"% 이미지 처리중이니 잠시만 기다리세요.").css({"color":"#fff"});
}

function completeHandler(event){
	//$("status").html(event.target.responseText);
	$("span#status").html("모든 작업이 완료되었습니다!").css({"color":"red"});
	$("#progressBar").val(0);
	$("span#status").show();
}

function errorHandler(event){
	$("span#status").html("Upload Failed");
}

function abortHandler(event){
	$("span#status").html("Upload Aborted");
}

// 사진 불러오기 (라이트박스 적용)
function carPictures() {

	$("ul.image_view").empty(); // 기존 사진을 모두 제거 (제거후 새로 불러온 사진을 보여줌)
	var bo_table = $("#bo_table").val();
	$(function(){
		$.ajax({
			url: board_skin_url+"/multi/_car_picture_json.php",
			type:"POST",
			data:{
				"bo_table":bo_table,
				"wr_id":$("#wr_id").val()
			},
			dataType: "json",
			async: false,
            cache: false,
			success: function(data){

				$("#t_img").val(data.total_count);
				$(".img_total").text("전체 "+data.total_count+"개의 사진이 있습니다.");

				// 페이지 선택 select 박스 생성
				$.each(data.arr, function(index, item){
					$(".image_view").append("<li>"+item.sour+"<a href='"+item.filename+"' data-lightbox='carinfo'><img src='"+item.thumb_filename+"'/></a></li>");
					//count ++;
				})

				// 이미지를 중앙으로 자동 정렬 ( text-align 사용시 마지막줄이 보기 싫음)
				if(data.arr.length > 0) {
					var width = $(".image_view").width();
					var img_width = '160';// 간격 여백 포함.
					var col = width/img_width;
					var img_t = (width - (img_width * parseInt(col)))/2;
					$(".image_view").css({"padding-left":(img_t + 15)});
				}

				if(!data.arr) {
					$(".image_view").append("<i class='fa fa-volume-down' aria-hidden='true'></i> 등록된 이미지가 없습니다.");
				}
				
	
				
				// 글번호 선택 select 박스 생성.
				//if(!data.write_id) {
				//	id_creat(data.id, parseInt(data.write_id));
				//}


			}
		})
	})
} // 차량사진 불러오기 끝.

// 사진 불러오기 (라이트박스 적용)
function file_list() {

	//var count = 0;
	$("ul.file_list").empty(); // 기존 사진을 모두 제거 (제거후 새로 불러온 사진을 보여줌)
	var bo_table = $("#bo_table").val();
	var fl = '';
	$(function(){
		$.ajax({
			url: board_skin_url+"/multi/_car_file_json.php",
			type:"POST",
			data:{
				"bo_table":bo_table,
				"wr_id":$("#wr_id").val()
			},
			dataType: "json",
			async: false,
            cache: false,
			success: function(data){
				//console.log("데이타");
				//console.log(data.length);
				$.each(data, function(index, item){
					$("ul.file_list").append("<li><i class=\"fa fa-download\" aria-hidden=\"true\"></i>&nbsp;"+item.source+""+item.content+"&nbsp( "+item.size+" )&nbsp;"+item.dlink+"<span class=\"bo_v_file_cnt\">"+item.download+"회 다운로드 | DATE : "+item.datetime+"</span></li>");
				});

				if(data.length==0) {
					$("#bo_v_file").hide();
				}
			}
		})
	})
} // 차량사진 불러오기 끝.

// 차량사진 삭제 ( mode=1 단일파일삭제, mode=2 파일일괄삭제 )
function pic_Del(wr_id, bf_no, mode) {
	var bo_table = $("#bo_table").val();
	if(confirm("파일 삭제시 복구 불가능합니다. 정말로 삭제 하시겠습니까?")) {
		$(function(){
			$.ajax({
				url: board_skin_url+"/multi/_car_pic_del_json.php?bo_table="+bo_table,
				type:"POST",
				data:{
					"wr_id":wr_id,
					"bf_no":bf_no,
					"mode":mode
				},
				dataType: "json",
				async: false,
			    cache: false,
				success: function(data){
				if(data.error) {
					alert(data.error);
					return false;
				}
				carPictures();
				file_list();

				}
			})
		})
	} // end if
} // 차량사진 삭제 끝

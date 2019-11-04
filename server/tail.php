<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/tail.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/tail.php');
    return;
}
?>

    </div>
</div>

</div>
<!-- } 콘텐츠 끝 -->

<hr>

<!-- 하단 시작 { -->
<div id="ft">
<div id="ft_wr">
		<div id="ft_copy">
		  <p>&copy; KOMA Cambodia.</p>
		  <p>#94, St03 .Borey Piphob Tmey Sakha Chhuk Meas, Phum Kouk Khleang Sangkat Krang Thung, Kan Sensok, Phnonom Penh.</p>
		<p>&#9742; +855-11-50-2244 (Korean) / +855-10-627-968 (Khmer) / 070-4842-1391 (한국전화)</p>
		</div>
	</div>
</div>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_PATH."/tail.sub.php");
?>
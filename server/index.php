<?php
include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/index.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_PATH.'/head.php');
?>


<div class="slideshow-container">
  <div class="Slides">
    <img src="css/img/main.png" style="width:100%">
  </div>

  <div class="Slides">
    <img src="css/img/main.png" style="width:100%">
  </div>

  <div class="Slides">
    <img src="css/img/main.png" style="width:100%">
  </div>

  <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
  <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
</div>
<br>
<br>
<div id="bible">
    <div id="bible_wr">
        <div id="bible_content">
        <img src="css/img/bible.jpg" alt="bible">
            </div>
    </div>
</div>
<br>
<br>
<br>
<script>
var slideIndex = [1,1];
var slideId = ["Slides", "mySlides2"]
showSlides(1, 0);
showSlides(1, 1);

function plusSlides(n, no) {
  showSlides(slideIndex[no] += n, no);
}

function showSlides(n, no) {
  var i;
  var x = document.getElementsByClassName(slideId[no]);
  if (n > x.length) {slideIndex[no] = 1}    
  if (n < 1) {slideIndex[no] = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }
  x[slideIndex[no]-1].style.display = "block";  
}
</script>


<?php
include_once(G5_PATH.'/tail.php');
?>
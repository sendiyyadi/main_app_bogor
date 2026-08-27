<style>
.watermark img {
  width: 100%;
}
.watermark {
  position: relative;
}
.watermark::after {
  content: 'COPYRIGHT, YOU SHALL NOT STEAL!';
  position: absolute;
  bottom: 0;
  right: 0;
  opacity: 0.5;
  font-size: 15px;
 /* left: 10%;   */
  -moz-transform: rotate(-60deg);
margin-left: 50px;

}


</style>
 
<h1>Hello World!</h1>
<div class="watermark">
   
  <img src="<?php echo app_img_header('assets/img/img_header.png')?>"  style="height:68px;">
 
    <div class="control-group">
        <label class="control-label">Tanggal</label> 
    </div>


</div>
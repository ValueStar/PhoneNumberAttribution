

<?php
$str=file_get_contents('http://www.bing.com/HpImageArchive.aspx?format=xml&idx=0&n=1&mkt=zh-CN');
if(preg_match("/<url>(.+?)<\/url>/ies",$str,$matches)){
 $imgurl='http://www.bing.com'.$matches[1];
}
if($imgurl){
 header('Content-Type: image/JPEG');
 @ob_end_clean();
 @readfile($imgurl);
 @flush(); @ob_flush();
 exit();
}else{
 exit('error');
}
?>
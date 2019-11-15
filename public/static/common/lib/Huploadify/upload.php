<?php
$filename = iconv('UTF-8', 'GBK', $_FILES['file']['name']);

 // $uptype = explode(".", $_FILES["uppic"]["name"]); 
// var_dump($uptype);
if ($filename) {
	$dir = 'uploads';
	if(!file_exists($dir)){
		// echo '文件夹'.$dir.'不存在';
		mkdir($dir,0777,true);
		// echo '文件夹'.$dir.'创建成功';
	} 
		$info = move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/" . $filename);
		if($info ==1){
			return '文件上传成功';
		}else{
			return '文件上传失败';
		}
}
?>
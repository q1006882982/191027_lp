<?php 
		 $deleteimg = $_POST['deleteimg'];
		 echo "需要删除的文件：$deleteimg";
		 $deleteimg='uploads/'.$deleteimg;
		 if(file_exists($deleteimg)=='true'){
		 	 if (unlink($deleteimg)==0)
			{
				echo  '删除失败' ;
			}
			else
			{
			echo '删除成功' ;
			}
		 }else{
		 	echo '文件不存在' ;
		 }
 ?>
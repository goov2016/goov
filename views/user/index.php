<?php
$title = '员工管理';
require_once(dirname(dirname(__FILE__))."/site/head.php");

//var_dump($para);

echo <<<END
      <h5>员工管理</h5>
      <!-- Main component for a primary marketing message or call to action -->
      <div class="row row-offcanvas row-offcanvas-right">
		<div class="col-md-10">
        <div class="jumbotron">
		  <div class="table-responsive">
	      <table class="table table-bordered">

			   <thead>
			      <tr>
			         <th>姓           名</th>
			         <th>电话号码</th>
			         <th>电子邮箱</th>
		             <th>身份证号码</th>
			         <th>性别</th>
			         <th>职位</th>
		             <th>学历</th>
			         <th>出生日期</th>
			         <th>入职时间</th>
			      </tr>
			   </thead>
			   <tbody>
END;
	foreach($para as $item)
	{
		echo   '<tr>';
		foreach($item as $fildval)
		{
		   echo   '<td>';
		   echo   $fildval;
		   echo  '</td>';
		}
		echo  '</tr>';
	};
echo '			      
			   </tbody>
			</table>
		</div>
	      </div>
		</div>
		
		
		 <div class="col-md-2 sidebar-offcanvas">
			<div class="list-group">
	            <a href="#" class="list-group-item active">员工管理</a>
	            <a href="index.php?ctr=user&act=creat" class="list-group-item">新建员工</a>
	
           </div>
         </div>
		
		</div>
		
      </div>';

require_once(dirname(dirname(__FILE__))."/site/foot.php");
?>
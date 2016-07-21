<?php
$title = '新建员工';
require_once(dirname(dirname(__FILE__))."/site/head.php");

echo <<<END


      <h5>员工管理->新建员工</h5>
      <!-- Main component for a primary marketing message or call to action -->
      <div class="row row-offcanvas row-offcanvas-right">
		<div class="col-md-12 jumbotron">
        <div class="col-md-4">
	       <form class="form-horizontal" action="index.php?ctr=user&act=creat" method="post">
		      <div class="form-group">
			    <label for="inputName" >姓名</label> <!--class="sr-only"-->
                <input type="text" name="name" class="form-control" id="inputName" placeholder="请输入姓名" required autofocus>
			  </div>
		
		  	 <div class="form-group">
			    <label for="inputPcode" >手机号码</label>
		        <input type="text" name="telphone" id="inputPcode" class="form-control" placeholder="输入手机号码" required>
			  </div>

			  <div class="form-group">
			    <label for="inputEmail" >电子邮件</label>
		        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="输入电子邮件" required>
			  </div>
		
              <div class="form-group">
			    <label for="inputPcode" >身份证号</label>
		        <input type="text" name="pcode" id="inputPcode" class="form-control" placeholder="输入身份证号" required>
			  </div>
		
			  <div class="form-group">  
		  		  <label for="optionsRadios1">性别</label>  
	                <div class="col-sm-offset-2">  
	                    <label class="radio">  
	                        <input type="radio" name="sex" id="optionsRadios1" value="男" checked>男</label>  
	                    <label class="radio">  
	                        <input type="radio" name="sex" id="optionsRadios2" value="女">女</label>  
	                </div>  
			  </div>
	       <div class="form-group">  
	           <label for="inputJob">职位</label>
                <input type="text" name="job" class="form-control" id="inputJob" placeholder="请输入职位" required autofocus>
	       </div>
		  <div class="form-group">  
	           <label for="inputJob">学历</label>
			   <select name="education" class="form-control">
				  <option>大专</option>
				  <option>本科</option>
				  <option>硕士</option>
				  <option>其他</option>
				</select>
		  </div>
			<div class="form-group">
                <label>出生日期</label>
			     <div style="margin-bottom:-25px">
	                <div class="controls input-append date form_date" data-date="" data-date-format="yyyy-MM-dd" data-link-field="dtp_input1" data-link-format="yyyy-mm-dd">
	                    <input size="16" type="text" value="" readonly>
	                    <span class="add-on"><i class="icon-remove"></i></span>
						<span class="add-on"><i class="icon-th"></i></span>
	                </div>
					<input name="birthday" type="hidden" id="dtp_input1" value="" /><br/>
			     </div>
            </div>
	
			<div class="form-group">
                <label>入职时间</label>
			     <div style="margin-bottom:-25px">
	                <div class="controls input-append date form_date" data-date="" data-date-format="yyyy-MM-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
	                    <input size="16" type="text" value="" readonly>
	                    <span class="add-on"><i class="icon-remove"></i></span>
						<span class="add-on"><i class="icon-th"></i></span>
	                </div>
					<input name="joindate" type="hidden" id="dtp_input2" value="" /><br/>
			     </div>
            </div>
		      
			
			
		      
			<!--<div class="form-group">
		        <div class="checkbox">
		          <label>
		            <input type="checkbox" value="remember-me"> Remember me
		          </label>
		        </div>
		    </div>-->
			<div class="form-group">
		        <button class="btn btn-lg btn-primary btn-block" type="submit">提交</button>
			</div>
		   </form>
	      </div><!--col-md-4-->
		</div><!--col-md-12 jumbotron-->
		
		
		
		
		</div>
		
      </div>



END;
require_once(dirname(dirname(__FILE__))."/site/foot.php");

echo <<<END
	<script type="text/javascript" src="/joyhr/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
	<script type="text/javascript" src="/joyhr/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
	<script type="text/javascript">
	
		$('.form_date').datetimepicker({
	        language:  'zh-CN',
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 2,
			forceParse: 0
	    });
	
	</script>
END;
?>
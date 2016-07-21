
    <hr>

      <footer>
        <p>&copy; Company 2014</p>
      </footer>
    </div> <!-- /container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/joyhr/js/jquery-1.11.2.js"></script>
    <script src="/joyhr/bootstrap/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/joyhr/js/ie10-viewport-bug-workaround.js"></script>
    
    
    <script type="text/javascript">
      $(function(){

    	  $('.active').parents('.dropdown').addClass("active");
    	  $("#navbar li").click(function(){
    	      $(this).addClass("active").siblings().removeClass("active");
    	  });

    	    
    	});
    </script>
  </body>
</html>

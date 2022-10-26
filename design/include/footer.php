
<footer class="footer_u">
  <div class="container">
    <div class="row coppy align-items-center">
      <div class="col-sm-8">
        <p>

© Copyright <?php $year = date("Y"); echo $year; ?> Remotex. All Rights Reserved
</p>
      </div>
      <div class="col-sm-4">
      <ul class="ul_set socila_foo">
      <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
      <li><a href="#" target="_blank"><i class="fa fa-instagram"></i></a></li>
      <li><a href="#" target="_blank"><i class="fa fa-pinterest"></i></a></li>
      
    </ul>
      </div>
    </div> 
  </div>
</footer>
    <script src="js/jquery.min.js" ></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js" ></script>    
    <script src="js/owl.carousel.js" ></script>    
    <script src="js/custom.js" ></script>  
    <script src="js/aos.js" ></script>  
    <script>
   AOS.init({
				easing: 'ease-out-back',
				duration: 1000
			});
</script>
<script>
  $(window).on('load',function(){
	setTimeout(function(){ // allowing 3 secs to fade out loader
	$('.page-loader').fadeOut('slow');
	},3500);
});


</script>
  </body>
</html>
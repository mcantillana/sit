<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Inscripción de Talleres [SIT]</title>
	
	<base href="<?php echo base_url(); ?>" />
	
	<!--[if IE]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection" /><![endif]-->
    <link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<link rel="Stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.1.custom.css"  />		
    	
	<!--[if IE]>
		<style type="text/css">
		  .clearfix {
		    zoom: 1;     /* triggers hasLayout */
		    display: block;     /* resets display for IE/Win */
		    }  /* Only IE can see inside the conditional comment
		    and read this CSS rule. Don't ever use a normal HTML
		    comment inside the CC or it will close prematurely. */
		</style>
	<![endif]-->
	<!-- JavaScript -->

    <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>

	 <!--[if IE]><script language="javascript" type="text/javascript" src="excanvas.pack.js"></script><![endif]-->
	 
	</head>
	 

<body>
<div  id="login_container">
    <div  id="header">
   
		
    </div><!-- end header -->
	   
	    <div id="login" class="section">
	    		    	
	    	<?=form_error('user_login','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>'); ?>
	    	<?=form_error('user_pass','<div id="fail" class="info_div"><span class="ico_cancel">','</span></div>')?>
			
	    	
	    	<?=form_open('login')?>
	    	
			<label><strong>E-mail</strong></label>
						
			<?=form_input('user_login', set_value('user_login'),'id="user_login" size="28" class="input"');?>
			
			<br />
			<label><strong>Contraseña</strong></label>
						
			<?=form_password('user_pass','','id="user_pass" size="28" class="input"');?>
			
			<br />
			<!-- <strong>Remember Me</strong><input type="checkbox" id="remember" class="input noborder" /> --> 
			
			<br />
					
			<?php echo form_submit('save','Ingresar','id="save"  class="loginbutton" class="submit"');?>
			
			<?=form_close()?>
			
	    </div>
	
	    
		    


</div><!-- end container -->

</body>
</html>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>CodeIgniter CRUD - Data Management System</title>
<link href="<?php echo base_url(); ?>media/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>media/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

<link href="<?php echo base_url(); ?>media/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>media/css/style.css" rel="stylesheet">

<link href="<?php echo base_url(); ?>media/tagmanager/bootstrap-tagmanager.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>media/select2/select2.css" rel="stylesheet">

<script src="<?php echo base_url(); ?>media/js/jquery-1.8.2.min.js"></script>
<script src="<?php echo base_url(); ?>media/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>media/ckeditor/ckeditor.js"></script>

<script src="<?php echo base_url(); ?>media/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>media/tagmanager/bootstrap-tagmanager.js"></script>
<script src="<?php echo base_url(); ?>media/select2/select2.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>media/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>media/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>media/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<style>
body {
	padding-top: 60px;
	padding-bottom: 60px;
}
</style>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse"
				data-target=".nav-collapse">
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="brand" href="#">CodeIgniter CRUD</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li><a href="<?php echo base_url(); ?>index.php/home">Example 1</a></li>
					<li><a href="<?php echo base_url(); ?>index.php/home/example2">Example 2</a></li>
					<li class="active"><a href="<?php echo base_url(); ?>index.php/home/example3">example 3</a></li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
</div>
	<?php echo  $html;?>
</body>
</html>
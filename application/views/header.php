<html>
<head>
	<link href="<?php echo base_url()?>/css/bootstrap.min.css" rel="stylesheet">
	<script src="<?php echo base_url()?>/js/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url()?>js/jquery.datetimepicker.js"></script>

  <script src="<?php echo base_url()?>js/jquery.datetimepicker.min.js"></script>

  <script src="<?php echo base_url()?>js/jquery.datetimepicker.full.min.js"></script>
  
  <script src="<?php echo base_url()?>js/jquery.datetimepicker.full.js"></script>
  <link rel="stylesheet" href="<?php echo base_url()?>css/jquery.datetimepicker.css">

    <link rel="stylesheet" href="<?php echo base_url()?>css/jquery.datetimepicker.min.css">

    <link rel="stylesheet" href="<?php echo base_url()?>css/fullcalendar.min.css" />
    <script src="<?php echo base_url()?>js/moment.min.js"></script>
    <script src="<?php echo base_url()?>js/fullcalendar.min.js"></script>

</head>
<body>
	<?php 
       if(isset($this->session->userdata["userid"])==true){ 
       if($this->session->userdata["role"]==0){
        ?>
        <a href="<?php echo base_url()?>addevent" class="btn btn-danger"><b>AddEvent</b></a>
        <?php }?>
        <a href="<?php echo base_url()?>/logout"><b>Logout</b></a>
    <?php   } ?>
    	<?php 
       if(isset($this->session->userdata["userid"])==false){ ?>

        <a href="<?php echo base_url()?>/login">Login</a>
    <?php   } ?>
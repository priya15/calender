<div class="container">
		<div class="col-md-12">
	<?php 
	$data    = $this->session->flashdata("success");
    $dataerr = $this->session->flashdata("error");
    if($dataerr != ""){
      echo "<div class='alert alert-warning'>Please Try again Email and Password doesnot exist</div>";
    }
    else if($data!= "")

    {
    	echo "<div class='alert alert-success'>Data added successfully";
    }
	?>
</div>
	<div class="col-md-6">
		<form action="<?php echo base_url()?>logindata" method="post">
		<div class="form-class">
			<label>Email:</label>
			<input type="text" name="email" class="form-control" required>
		</div>

		<div class="form-class">
			<label>Password:</label>
			<input type="password" name="password" class="form-control" required>
		</div>

		<div class="form-class">
			<input type="submit" value="add" class="btn btn-danger">
		</div>
	</div>
</form>
</div>
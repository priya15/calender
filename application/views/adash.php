<div class="container">
	<div class="col-md-6">
		<b style="font-size:30px">UserList</b>
		<table class="table table-bordered">
			<thead><tr><th>Username</th><th>Password</th><th></th><th></th></tr></thead>
			<tbody>
      <?php $data = $this->welcome_database->alluserlist();
           if(!empty($data)){
           	for ($i=0; $i <count($data) ; $i++) { ?>
         <tr><td><?php echo $data[$i]["username"]; ?></td>
         <td><?php echo $data[$i]["email"]; ?></td>
         <td><a href="<?php echo base_url()?>admin/delete/<?php echo base64_encode($data[$i]["id"]);?>">Delete</a></td>
        <td><a href="<?php echo base_url()?>admin/update/<?php echo base64_encode($data[$i]["id"]);?>">Edit</a></td>
     </tr>           		
           <?php
           	} }
      ?>
  </tbody>
</table>

	</div>
</div>

<script type="text/javascript">
	
	$.ajax({
		url:"<?php echo base_url()?>regisdata",
		type:"post",
		data:{"username":"shiy","password":"shiya"},
		success:function(data){
    
		},
		error:function(data){

		}
	})
</script>
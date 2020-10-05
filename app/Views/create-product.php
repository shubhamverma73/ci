<!DOCTYPE html>
<html>
<head>
	<title>Create Product</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>  

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

</head>
<body>
	<div class="container">
		<br>
		<?php //echo $validation = \Config\Services::validation()->listErrors(); ?>
		<?php $validation = \Config\Services::validation(); echo $validation->showError('name'); ?>

		<span class="d-none alert alert-success mb-3" id="res_message"></span>

		<div class="row">
			<div class="col-md-9">
				<form action="<?php echo base_url('test/add');?>" name="post_form" id="post_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
					<?php echo csrf_field(); ?>

					<div class="form-group">
						<label for="name">Name *</label>
						<input type="text" name="name" class="form-control" id="name" placeholder="Please enter name">
					</div> 

					<div class="form-group">
						<label for="email">DP Price *</label>
						<input type="text" name="dp_price" class="form-control" value="<?php echo old('dp_price'); ?>" id="dp_price" placeholder="Please enter dp_price">
					</div> 

					<div class="form-group">
						<label for="email">Price *</label>
						<input type="text" name="price" class="form-control" value="<?php echo old('price'); ?>" id="price" placeholder="Please enter price">
					</div>  

					<div class="form-group">
						<label for="email">Image</label>
						<input type="file" name="image" class="form-control">
					</div>  

					<div class="form-group">
						<button type="submit" id="send_form" class="btn btn-success">Submit</button>
					</div>

				</form>
			</div>

		</div>

	</div>
	<script>
		if ($("#post_form").length > 0) {
			$("#post_form").validate({
				
				rules: {
					/*name: {
						required: true,
					},*/
					dp_price: {
						required: true,       
					},
					price: {
						required: true,       
					},   
				},
				messages: {
					/*name: {
						required: "Please enter name",
					},*/
					dp_price: {
						required: "Please enter dp_price",       
					},
					price: {
						required: "Please enter dp_price",       
					}, 
				},
			})
		}
	</script>
</body>
</html>
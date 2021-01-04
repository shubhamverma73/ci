<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Codeigniter 4 CRUD Tutorial -  posts List Example - Expertphp.in</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

</head>
<body>

	<?php echo get_flashdata('message'); ?>
	<div class="container mt-5">
		<a href="<?php echo base_url('create') ?>" class="btn btn-sm btn-success">Create</a>

		<div class="row mt-12">
			<table class="table table-bordered" id="products">
				<thead>
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>DP Price</th>
						<th>Price</th>
						<th>Image</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if($products): ?>
						<?php foreach($products as $post): ?>
							<tr>
								<td><?php echo $post['id']; ?></td>
								<td><?php echo $post['name']; ?></td>
								<td><?php echo $post['dp_price']; ?></td>
								<td><?php echo $post['price']; ?></td>
								<td><img src="<?php echo base_url('writable/uploads/products/'.$post['image']); ?>" height="40" width="40"></td>
								<td>
									<a href="<?php echo base_url('test/edit/'.$post['id']);?>" class="btn btn-sm btn-success">Edit</a>
									<a href="<?php echo base_url('test/delete/'.$post['id']);?>" onclick="return confirm('Are you sure you want to delete?');" class="btn btn-sm btn-danger">Delete</a>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>

	<script>
		$(document).ready( function () {
			$('#products').DataTable();
		} );
	</script>
</body>
</html>
<?php
session_start();
if (!array_key_exists('token', $_SESSION)) {
	$_SESSION['token'] = md5(uniqid(mt_rand(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
	<?php require_once 'http-checker.php'; ?>
	<div class="row mt-5">
		<div class="col-md-6 mx-auto">
			<div class="card">			
				<h3 class="card-header">HTTP Status Checker</h3>
				<div class="card-body">
					<form method="POST" action="" enctype="multipart/form-data">
						<input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"/>
						<div class="form-group my-2">
							<label class="form-label" for="file">Upload File</label>
							<input type="file" class="form-control" id="file" name="file" required />
							<small class="form-text text-muted">Accept .csv format only.</small>
						</div>
						<button type="submit" class="btn btn-primary" name="generate_http_code">Submit</button>
					</form>
				</div>
			</div>

			<!-- Error Message -->
			<?php if (!empty($errMsg)) : ?>
				<p class="text-danger m-2"><?php echo $errMsg ?></p>
			<?php endif; ?>

			<!-- Table -->
			<?php if (!empty($httpWithCodes)) : ?>
				<table class="table table-striped mt-4">
					<thead>
						<tr>
							<th>Url</th>
							<th>Status code</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($httpWithCodes as $url => $code) : ?>
							<tr>
								<td> <?php echo $url ?> </td>
								<td> <?php echo $code ?> </td>
							</tr>
						<?php endforeach; ?>
					</tbody>					
				</table>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>
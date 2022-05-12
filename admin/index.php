<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="../../Libraries/UCSbootstrap/css/bootstrap.min.css" />
		<title>Apple Sale Pricing import</title>
	</head>

	<body>
		<div class="container">
			<div class="card">
				<div class="card-header bg-primary text-white">Import Apple Sale prices</div>
				<div class="card-body">
					<form method="POST" enctype='multipart/form-data' action="process.php">
						<input name='uploadedFile' type='file' class='formcontrol input'><br><br>
						<input name='password' type='password' class='formcontrol input' placeholder="Password">
						<button type='submit' name='submit' class='btn btn-sm btn-primary'>submit</button>
					</form>
					<div>
						The uploaded file must be a CSV in <a href="example.csv">this format.</a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

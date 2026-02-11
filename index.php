<?php
session_start();

if (isset($_GET['action']) && $_GET['action'] == 'clear') {
	session_unset();
	exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$_SESSION['product_name'] = $_POST['product_name'] ?? '';
	$_SESSION['warehouse_city'] = $_POST['warehouse_city'] ?? '';
	$_SESSION['min_quantity'] = $_POST['min_quantity'] ?? '';
	$_SESSION['max_quantity'] = $_POST['max_quantity'] ?? '';
	$_SESSION['min_price'] = $_POST['min_price'] ?? '';
	$_SESSION['max_price'] = $_POST['max_price'] ?? '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Macie Wholesale Dealers</title>
	<link rel="stylesheet" href="styles.css">
</head>

<body>
	<h1>Macie Wholesale Dealers</h1>
	<h2>Product Search</h2><br>
	<div class="container">
		<form class="search-form" action="product_list.php" method="post">
			<div class="form-grid">
				<div class="row">
					<div class="column">
						<label for="product_name">Product Name (<em>substring</em>)</label>
						<input type="text" id="product_name" name="product_name"
							value="<?php echo htmlspecialchars($_SESSION['product_name'] ?? ''); ?>"><br>
					</div>
				</div>
				<div class="row">
					<div class="column">
						<label for="warehouse_city">Warehouse City (<em>substring</em>)</label>
						<input type="text" id="warehouse_city" name="warehouse_city"
							value="<?php echo htmlspecialchars($_SESSION['warehouse_city'] ?? ''); ?>"><br>
					</div>
				</div>
				<div class="row">
					<div class="column">
						<label for="min_quantity">Minimum Quantity</label>
						<input type="number" id="min_quantity" min="0" name="min_quantity"
							value="<?php echo htmlspecialchars($_SESSION['min_quantity'] ?? ''); ?>"><br>

						<label for="min_price">Minimum Price</label>
						<input type="number" step="0.01" min="0.00" name="min_price"
							value="<?php echo htmlspecialchars($_SESSION['min_price'] ?? ''); ?>"><br><br>

						<button type="button" class="clear-btn" onclick="clearSession()">Clear Form</button>
					</div>
					<div class="column">
						<label for="max_quantity">Maximum Quantity</label>
						<input type="number" id="max_quantity" min="0" name="max_quantity"
							value="<?php echo htmlspecialchars($_SESSION['max_quantity'] ?? '') ?>"><br>

						<label for="max_price">Maximum Price</label>
						<input type="number" step="0.01" min="0.00" name="max_price"
							value="<?php echo htmlspecialchars($_SESSION['max_price'] ?? ''); ?>"><br><br>

						<button type="submit" class="search-btn">Search Products</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<script>
		function clearSession() {
			fetch('index.php?action=clear')
				.then(() => {
					window.location.href = 'index.php';
				});
		}
	</script>
</body>

</html>

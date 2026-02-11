<?php
session_start();
try {
	$pdo = new PDO("mysql:host=localhost;dbname=b568v596", "b568v596", "b568v596");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	die("Database connection failed: " . $e->getMessage());
}

$product = $_POST['product_name'] ?? '';
$city = $_POST['warehouse_city'] ?? '';
$minQuantity = $_POST['min_quantity'] ?? '';
$maxQuantity = $_POST['max_quantity'] ?? '';
$minPrice = $_POST['min_price'] ?? '';
$maxPrice = $_POST['max_price'] ?? '';

$_SESSION['product_name'] = $product;
$_SESSION['warehouse_city'] = $city;
$_SESSION['min_quantity'] = $minQuantity;
$_SESSION['max_quantity'] = $maxQuantity;
$_SESSION['min_price'] = $minPrice;
$_SESSION['max_price'] = $maxPrice;

$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

if (!empty($product)) {
	$sql .= " AND pname LIKE :product";
	$params[':product'] = "%$product%";
}
if (!empty($city)) {
	$sql .= " AND city LIKE :city";
	$params[':city'] = "%$city%";
}
if (!empty($minQuantity)) {
	$sql .= " AND quantity >= :minQuantity";
	$params[':minQuantity'] = $minQuantity;
}
if (!empty($maxQuantity)) {
	$sql .= " AND quantity <= :maxQuantity";
	$params[':maxQuantity'] = $maxQuantity;
}
if (!empty($minPrice)) {
	$sql .= " AND price >= :minPrice";
	$params[':minPrice'] = $minPrice;
}
if (!empty($maxPrice)) {
	$sql .= " AND price <= :maxPrice";
	$params[':maxPrice'] = $maxPrice;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
?>
<!DOCTYPE html>
<html>

<head>
	<title>Macie Wholesale Dealers</title>
	<link rel="stylesheet" href="styles.css">
</head>

<body>
	<h1>Macie Wholesale Dealers</h1>
	<h2>Searched Product List</h2>
	<div class="container">
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>City</th>
					<th>Quantity</th>
					<th>Price</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
					<tr>
						<td><?php echo htmlspecialchars($row['pid']); ?></td>
						<td><?php echo htmlspecialchars($row['pname']); ?></td>
						<td><?php echo htmlspecialchars($row['city']); ?></td>
						<td><?php echo htmlspecialchars($row['quantity']); ?></td>
						<td><?php echo htmlspecialchars($row['price']); ?></td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table><br><br>
		<form action="index.php" method="get">
			<button class="search-again">Perform Another Search</button>
		</form>
	</div>
</body>

</html>
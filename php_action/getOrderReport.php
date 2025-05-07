<?php 
require_once 'core.php';

if ($_POST) {

	$startDate = $_POST['startDate'];
	$date = DateTime::createFromFormat('m/d/Y', $startDate);
	$start_date = $date->format("Y-m-d");

	$endDate = $_POST['endDate'];
	$format = DateTime::createFromFormat('m/d/Y', $endDate);
	$end_date = $format->format("Y-m-d");

	$sql = "
		SELECT 
			o.order_id,
			o.order_date,
			o.client_name,
			o.client_contact,
			o.grand_total,
			c.categories_name
		FROM orders o
		JOIN order_item oi ON o.order_id = oi.order_id
		JOIN product p ON oi.product_id = p.product_id
		JOIN categories c ON p.categories_id = c.categories_id
		WHERE o.order_date >= '$start_date' 
			AND o.order_date <= '$end_date' 
			AND o.order_status = 1
		GROUP BY o.order_id
	";

	$query = $connect->query($sql);

	$table = '<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<th>Id</th>
			<th>Order Date</th>
			<th>Name</th>
			<th>Contact</th>
			<th>Category</th>
			<th>Grand Total</th>
		</tr>';

	$totalAmount = 0;

	while ($result = $query->fetch_assoc()) {
		$table .= '<tr>
			<td><center>' . $result['order_id'] . '</center></td>
			<td><center>' . $result['order_date'] . '</center></td>
			<td><center>' . $result['client_name'] . '</center></td>
			<td><center>' . $result['client_contact'] . '</center></td>
			<td><center>' . $result['categories_name'] . '</center></td>
			<td><center>' . $result['grand_total'] . '</center></td>
		</tr>';

		$totalAmount += $result['grand_total'];
	}

	$table .= '
		<tr>
			<td colspan="5"><center>Total Amount</center></td>
			<td><center>' . $totalAmount . '</center></td>
		</tr>
	</table>';

	echo $table;
}
?>

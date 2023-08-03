<?php
require_once("db_conn.php");

$brand = $_GET['brand'];

// Modify your SQL query based on filter values
$stmt = "SELECT s.s_id, s.shoe_name, s.product_image, s.shoe_sizes, s.gender, s.price, b.b_name as brand_name
         FROM shoe s
         INNER JOIN brands b ON s.b_id = b.b_id";

// Add WHERE conditions based on filter values
if ($brand !== 'all') {
  $stmt .= " WHERE b.b_id = '$brand'";
}
// You can add similar conditions for sorting based on $sort value

$result = mysqli_query($conn, $stmt);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Return the filtered data in JSON format
echo json_encode($products);
?>

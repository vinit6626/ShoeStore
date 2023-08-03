<?php
require_once("db_conn.php");

$brand = $_GET['brand'];
$category = $_GET['category'];
$sortPrice = $_GET['sortPrice'];

// Modify your SQL query based on filter values
$stmt = "SELECT s.s_id, s.shoe_name, s.product_image, s.shoe_sizes, s.gender, s.price, b.b_name as brand_name
         FROM shoe s
         INNER JOIN brands b ON s.b_id = b.b_id";

// Add WHERE conditions based on filter values
if ($brand !== 'all') {
  $stmt .= " WHERE b.b_id = '$brand'";
}

if ($category !== 'all') {
  if ($brand !== 'all') {
    $stmt .= " AND ";
  } else {
    $stmt .= " WHERE ";
  }
  $stmt .= "s.c_id = '$category'";
}

// Add sorting based on price
if ($sortPrice === 'low_to_high') {
  $stmt .= " ORDER BY s.price ASC";
} elseif ($sortPrice === 'high_to_low') {
  $stmt .= " ORDER BY s.price DESC";
}

$result = mysqli_query($conn, $stmt);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Return the filtered data in JSON format
echo json_encode($products);

?>

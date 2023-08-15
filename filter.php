<?php
require_once("db_conn.php");
class Database {
  private $conn;

  public function __construct($conn) {
      $this->conn = $conn;
  }

  public function getFilteredProducts($brand, $category, $sortPrice) {
      $stmt = "SELECT s.s_id, s.shoe_name, s.product_image, s.shoe_sizes, s.gender, s.price, b.b_name as brand_name
               FROM shoe s
               INNER JOIN brands b ON s.b_id = b.b_id";

      $conditions = array();

      if ($brand !== 'all') {
          $conditions[] = "b.b_id = ?";
      }

      if ($category !== 'all') {
          $conditions[] = "s.c_id = ?";
      }

      if (!empty($conditions)) {
          $stmt .= " WHERE " . implode(" AND ", $conditions);
      }

      if ($sortPrice === 'low_to_high') {
          $stmt .= " ORDER BY s.price ASC";
      } elseif ($sortPrice === 'high_to_low') {
          $stmt .= " ORDER BY s.price DESC";
      }

      $products = array();

      $stmt = mysqli_prepare($this->conn, $stmt);

      if ($brand !== 'all') {
          mysqli_stmt_bind_param($stmt, 'i', $brand);
      }

      if ($category !== 'all') {
          mysqli_stmt_bind_param($stmt, 'i', $category);
      }

      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      while ($row = mysqli_fetch_assoc($result)) {
          $products[] = $row;
      }

      mysqli_stmt_close($stmt);

      return $products;
  }
}

$brand = $_GET['brand'];
$category = $_GET['category'];
$sortPrice = $_GET['sortPrice'];

$database = new Database($conn);
$filteredProducts = $database->getFilteredProducts($brand, $category, $sortPrice);

echo json_encode($filteredProducts);

?>

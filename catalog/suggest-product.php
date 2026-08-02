<?php
include('../config/constants.php');

header('Content-Type: application/json');

$term = isset($_GET['q']) ? trim($_GET['q']) : '';

if (strlen($term) < 1) {
    echo json_encode([]);
    exit;
}

$search = mysqli_real_escape_string($conn, $term);

// Only match against product titles for live suggestions to avoid false positives from description text
$sql = "SELECT id, title, price, image_name FROM tbl_product 
        WHERE active='Yes' AND title LIKE '%$search%' 
        ORDER BY 
            CASE 
                WHEN title LIKE '$search%' THEN 1 
                ELSE 2 
            END, 
            title ASC 
        LIMIT 6";

$res = mysqli_query($conn, $sql);
$results = [];

if ($res && mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $image = !empty($row['image_name']) ? SITEURL . 'images/product/' . $row['image_name'] : SITEURL . 'images/logo.png';
        
        $results[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'price' => $row['price'],
            'image' => $image,
            'url' => SITEURL . 'catalog/detail.php?id=' . $row['id']
        ];
    }
}

echo json_encode($results);

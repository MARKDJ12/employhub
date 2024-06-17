<?php 
// Example pseudo-code for search_results.php
include("server.php");
$searchTerm = $_GET['query'] ?? '';

$sql = "SELECT * FROM jobs WHERE job_title LIKE ? OR company_name LIKE ? ORDER BY closing_date DESC";
$stmt = $conn->prepare($sql);
$likeTerm = '%' . $searchTerm . '%';
$stmt->bind_param("ss", $likeTerm, $likeTerm);
$stmt->execute();
$result = $stmt->get_result();

// Rest of the code to display results
 ?>
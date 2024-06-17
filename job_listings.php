<?php
include '../config.php'; 
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: panel.php'); 
    exit();
}

$limit = 10; // Limit of jobs per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Delete job logic
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM jobs WHERE job_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: job_listings.php?page=$page");
    exit;
}

// Publish/unpublish job logic
if (isset($_GET['publish'])) {
    $id = intval($_GET['publish']);
    $status = ($_GET['status'] == '1') ? 0 : 1; 
    $updateQuery = "UPDATE jobs SET published = ? WHERE job_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ii", $status, $id);
    $stmt->execute();
    header("Location: job_listings.php?page=$page");
    exit;
}

$searchTerm = $_GET['search'] ?? '';
$searchParam = '%' . $searchTerm . '%';

// Get total number of jobs
$totalQuery = "SELECT COUNT(*) as total FROM jobs WHERE (job_title LIKE ? OR company_name LIKE ?)";
$totalStmt = $conn->prepare($totalQuery);
$totalStmt->bind_param("ss", $searchParam, $searchParam);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalJobs = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalJobs / $limit);

// Get jobs for current page
$query = "SELECT * FROM jobs WHERE (job_title LIKE ? OR company_name LIKE ? ) ORDER BY job_id LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssii", $searchParam, $searchParam, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Job Listings</title>
    <link rel="icon" type="image/x-icon" href="../img/ourlogo.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f4;
            color: #333;
        }
        .headed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #2C3E50;
            color: #fff;
            padding: 1px;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #34495E;
            color: #fff;
            padding-top: 80px;
            overflow-y: auto;
            z-index: 999;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        .navbar li {
            padding: 15px 20px;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background 0.3s ease;
        }
        .navbar a:hover {
            background-color: #4E5F70;
        }
        .navbar a i {
            margin-right: 10px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            padding-top: 80px;
            min-height: 100vh;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            padding: 5px 6px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: #ffffff;
        }
        .action-btns {
            margin-bottom: 20px;
        }
        .btn {
            padding: 5px 10px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn-danger {
            background-color: #f44336;
        }
        .btn-danger:hover {
            background-color: #e53935;
        }
        .icon-btn {
            background: none;
            border: none;
            color: #333;
            cursor: pointer;
            font-size: 1.2em;
            margin: 0 5px;
        }
        .icon-btn:hover {
            color: #3498db;
        }
        .icon-btn.delete {
            color: #e74c3c;
        }
        .icon-btn.delete:hover {
            color: #c0392b;
        }
        .icon-btn.publish:hover {
            color: #27ae60;
        }
        .search-bar {
            position: absolute;
            right: 20px; 
            top: 125px;
            display: flex;
            align-items: center;
            background-color: #fff;
            border-radius: 5px;
            padding: 5px 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .search-bar input {
            border: none;
            outline: none;
            padding: 5px;
            width: 200px;
        }
        .search-bar button {
            background: none;
            border: none;
            color: #3498db;
            cursor: pointer;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination .btn {
            margin: 0 5px;
            padding: 5px 10px;
            text-decoration: none;
        }
    </style>
    <script>
        function confirmAction(action) {
            return confirm('Are you sure you want to ' + action + ' this job?');
        }
    </script>
</head>
<body>
    <div class="headed">
        <h1>Employhub | Admin Panel</h1>
    </div>
    <div class="navbar">
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="job_listings.php"><i class="fas fa-briefcase"></i> Job Listings</a></li>
            <li><a href="companies.php"><i class="fas fa-building"></i> Companies</a></li>
            <li><a href="reg_users.php"><i class="fas fa-users"></i> Reg Users</a></li>
            <li><a href="applicants.php"><i class="fas fa-user-plus"></i> Applicants</a></li>
            <li><a href="panel.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="search-bar">
            <form action="job_listings.php" method="GET">
                <input type="text" name="search" placeholder="Search jobs..." value="<?= htmlspecialchars($searchTerm) ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <h1>JOB LISTINGS</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Closing Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $counter = $offset + 1; // Adjust counter based on offset
                while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $counter ?></td>
                    <td><?= htmlspecialchars($row['job_title']) ?></td>
                    <td><?= htmlspecialchars($row['company_name']) ?></td>
                    <td><?= htmlspecialchars($row['city'] . ', ' . $row['country']) ?></td>
                    <td><?= htmlspecialchars($row['closing_date']) ?></td>
                    <td><?= $row['published'] ? 'Published' : 'Unpublished' ?></td>
                    <td class="action-btns">
                        <a href="edit_job.php?id=<?= $row['job_id'] ?>" class="icon-btn"><i class="fas fa-edit"></i></a>
                        <a href="?delete=<?= $row['job_id'] ?>&page=<?= $page ?>" class="icon-btn delete" onclick="return confirmAction('delete')"><i class="fas fa-trash"></i></a>
                        <a href="?publish=<?= $row['job_id'] ?>&status=<?= $row['published'] ?>&page=<?= $page ?>" class="icon-btn publish" onclick="return confirmAction('toggle publish status')">
                            <i class="fas fa-toggle-<?= $row['published'] ? 'on' : 'off' ?>"></i>
                        </a>
                    </td>
                </tr>
                <?php $counter++; endwhile; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>&search=<?= htmlspecialchars($searchTerm) ?>" class="btn">&laquo; Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= htmlspecialchars($searchTerm) ?>" class="btn"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($searchTerm) ?>" class="btn">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>

<?php
include("server.php");

// Check if session is not started, then start it
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employhub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$job_id = isset($_GET['id']) ? $_GET['id'] : die('Job ID not specified.');

$sql = "SELECT * FROM jobs WHERE job_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

$job = $result->fetch_assoc();

if (!$job) {
    die('Job not found.');
}

// Extract email and contact number from contact details
$contact_details = $job['contact_details'];
$contact_details_array = preg_split('/\r\n|\r|\n| /', $contact_details);

$email = '';
$contact_number = '';

foreach ($contact_details_array as $detail) {
    if (filter_var($detail, FILTER_VALIDATE_EMAIL)) {
        $email = $detail;
    } elseif (preg_match('/^[0-9]{10,}$/', $detail)) {
        $contact_number = $detail;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Details - <?= htmlspecialchars($job['job_title']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="img/ourlogo.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(img/ils.jpg);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-size: cover;
        }
        .job-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 700px;
        }
        h1 {
            color: #333;
            font-size: 24px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            color: #666;
        }
        a {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a, i {
            margin-right: 10px;
        }
        a:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            background-color: #f8f9fa;
            color: #333;
        }
        .back-link:hover {
            background-color: #e2e6ea;
        }
        .contact-details {
            white-space: pre-wrap;
        }
        .apply-link {
            display: inline-block;
            margin-top: 20px;
            background-color: #28a745;
            color: white;
        }
        .apply-link:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="job-details">
        <h1>Job Title: <?= htmlspecialchars($job['job_title']); ?></h1>
        <p><strong><i class="fas fa-building"></i>Company:</strong> <?= htmlspecialchars($job['company_name']); ?></p>
        <p><strong><i class="fas fa-map-marker-alt"></i>Location:</strong> <?= htmlspecialchars($job['city'] . ', ' . $job['country']); ?></p>
        <p><strong><i class="fas fa-briefcase"></i>Job Type:</strong> <?= htmlspecialchars($job['job_type']); ?></p>
        <p><strong><i class="fas fa-chart-line"></i>Experience Required:</strong> <?= htmlspecialchars($job['experience_required']); ?></p>
        <p><strong><i class="fas fa-align-left"></i>Job Description:</strong> <?= htmlspecialchars($job['job_description']); ?></p>
        <p><strong><i class="fas fa-tasks"></i>Responsibilities:</strong> <?= htmlspecialchars($job['responsibilities']); ?></p>
        <p><strong><i class="fas fa-dollar-sign"></i>Salary: $</strong> <?= htmlspecialchars((float) $job['salary']); ?></p>
        <p><strong><i class="fas fa-calendar-alt"></i>Closing Date:</strong> <?= htmlspecialchars(date('F j, Y', strtotime($job['closing_date']))); ?></p>
        <p><strong><i class="fas fa-address-book"></i> Contact Details:</strong></p>
        <p class="contact-details"><i class="far fa-envelope"></i> <?= htmlspecialchars($email); ?><br><i class="fas fa-phone"></i> <?= htmlspecialchars($contact_number); ?></p>

        <p>Contact us now!</p>
        <a href="alljobs.php" class="back-link">Back to Job Listings</a>
        <a href="apply.php?job_id=<?= $job_id; ?>" class="apply-link" id="applyButton">Apply Now</a>
    </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

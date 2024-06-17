<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "employhub";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if job_id is provided in the URL
if (!isset($_GET['job_id'])) {
    echo "<script>alert('Error: Job ID not specified.'); window.history.back();</script>";
    exit;
}

// Start the session
session_start();

// Redirect user to login page if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Get job_id from the URL
$job_id = $_GET['job_id'];

// Get username from the session
$username = $_SESSION['username'] ?? null;

// Check if username is set
if ($username === null) {
    echo "<script>alert('Error: Username not found in session.'); window.history.back();</script>";
    exit;
}

// Check if the user has already applied for the job
$sql_check = "SELECT COUNT(*) FROM applicants WHERE job_id = ? AND username = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("is", $job_id, $username);
$stmt_check->execute();
$stmt_check->bind_result($num_applications);
$stmt_check->fetch();
$stmt_check->close();

if ($num_applications > 0) {
    echo "<script>alert('You have already applied for this job.'); window.history.back();</script>";
    exit;
}

// Prepare and execute SQL to retrieve user details based on username
$sql_user_details = "SELECT id, full_name, email FROM users WHERE username = ?";
$stmt_user_details = $conn->prepare($sql_user_details);

if (!$stmt_user_details) {
    echo "<script>alert('Failed to prepare SQL statement.'); window.history.back();</script>";
    exit;
}

// Bind parameter and execute the SQL statement
$stmt_user_details->bind_param("s", $username);
$stmt_user_details->execute();

// Bind the result variables
$stmt_user_details->bind_result($users_id, $full_name, $email);

// Fetch the result
$stmt_user_details->fetch();

// Close the statement
$stmt_user_details->close();

// Check if user details are set
if ($users_id === null || $full_name === null || $email === null) {
    echo "<script>alert('User details not found. Please complete your profile.'); window.history.back();</script>";
    exit;
}

// Prepare and execute SQL to retrieve company name based on job_id
$sql_company_name = "SELECT company_name FROM jobs WHERE job_id = ?";
$stmt_company_name = $conn->prepare($sql_company_name);

if (!$stmt_company_name) {
    echo "<script>alert('Failed to prepare SQL statement.'); window.history.back();</script>";
    exit;
}

// Bind parameter and execute the SQL statement
$stmt_company_name->bind_param("i", $job_id);
$stmt_company_name->execute();

// Bind the result variable
$stmt_company_name->bind_result($company_name);

// Fetch the result
$stmt_company_name->fetch();

// Close the statement
$stmt_company_name->close();

// Check if company name is set
if ($company_name === null) {
    echo "<script>alert('Company name not found for the provided job ID.'); window.history.back();</script>";
    exit;
}

// Prepare and execute SQL to insert applicant into applicants table
$sql_insert_applicant = "INSERT INTO applicants (job_id, username, users_id, full_name, email, company_name) VALUES (?, ?, ?, ?, ?, ?)";
$stmt_insert_applicant = $conn->prepare($sql_insert_applicant);

if (!$stmt_insert_applicant) {
    echo "<script>alert('Failed to prepare SQL statement.'); window.history.back();</script>";
    exit;
}

// Bind parameters and execute the SQL statement
$stmt_insert_applicant->bind_param("isisss", $job_id, $username, $users_id, $full_name, $email, $company_name);
$result = $stmt_insert_applicant->execute();

if (!$result) {
    echo "<script>alert('Failed to execute SQL statement.'); window.history.back();</script>";
    exit;
}

// Close the statement
$stmt_insert_applicant->close();

// Display successful message
echo "<script>alert('Application successfully sent to the admin.'); window.history.back();</script>";

// Close the database connection
$conn->close();
?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "employhub";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO jobs (company_name, job_title, city, country, category, closing_date, job_type, experience_required, job_description, responsibilities, requirements, salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("ssssssssssss", $company, $title, $city, $country, $category, $closing_date, $job_type, $experience, $description, $responsibilities, $requirements, $salary);

    // Set parameters
    $company = $_POST['company'];
    $title = $_POST['title'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $category = $_POST['category'];
    $closing_date = $_POST['closing_date'];
    $job_type = $_POST['job_type'];
    $experience = $_POST['experience'];
    $description = $_POST['description'];
    $responsibilities = $_POST['responsibilities'];
    $requirements = $_POST['requirements'];
    $salary = $_POST['salary'];
    // Execute and check for success/error
    if ($stmt->execute()) {
        echo "<p>Job posted successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
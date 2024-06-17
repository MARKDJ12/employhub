<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #212529;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        form {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            width: 200%;
            max-width: 460px;
            box-sizing: border-box;
            border: 1px solid #dee2e6;
        }
        label {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        input[type="text"], input[type="hidden"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 1rem;
            border-radius: 5px;
            border: 1px solid #ced4da;
            font-size: 16px;
            color: #495057;
            background-color: #e9ecef;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        input[type="text"]:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .back-btn {
            position: absolute;
            bottom: 20px;
            left: 20px;
            text-decoration: none;
            font-weight: 500;
            color: #007bff;
        }
        .back-btn:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-bottom: 1rem;
            text-align: center;
        }
        .success-message {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: #28a745;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include '../config.php';

    $job = null;
    $error = '';
    $success_message = '';

    // Fetch job details
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        if ($id > 0) {
            $stmt = $conn->prepare("SELECT * FROM jobs WHERE job_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                $error = "No job found with ID $id.";
            } else {
                $job = $result->fetch_assoc();
            }
        } else {
            $error = "Invalid job ID.";
        }
    }

    // Handling POST request for updating job details
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_id'])) {
        $id = intval($_POST['update_id']);
        $title = $_POST['title'];
        $company = $_POST['company'];
        $closing_date = $_POST['closing_date'];

        if ($id > 0) {
            $updateStmt = $conn->prepare("UPDATE jobs SET job_title = ?, company_name = ?, closing_date = ? WHERE job_id = ?");
            $updateStmt->bind_param("sssi", $title, $company, $closing_date, $id);
            if ($updateStmt->execute()) {
                $success_message = "Job updated successfully!";
            } else {
                $error = "Failed to update job.";
            }
        } else {
            $error = "Invalid job ID for update.";
        }
    }
    ?>
    <?php if ($error): ?>
        <p class="error">Error: <?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($success_message): ?>
        <p class="success-message"><?= htmlspecialchars($success_message) ?></p>
    <?php endif; ?>
    <?php if ($job): ?>
    <form method="POST">
        <input type="hidden" name="update_id" value="<?= htmlspecialchars($id) ?>">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($job['job_title'] ?? '') ?>">
        <label for="company">Company:</label>
        <input type="text" id="company" name="company" value="<?= htmlspecialchars($job['company_name'] ?? '') ?>">
        <label for="closing_date">Closing Date:</label>
        <input type="text" id="closing_date" name="closing_date" value="<?= htmlspecialchars($job['closing_date'] ?? '') ?>">
        <button type="submit">Update Job</button>
    </form>
    <a href="job_listings.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Listings</a>
    <?php else: ?>
        <p>Job not found or invalid access.</p>
    <?php endif; ?>
</body>
</html>

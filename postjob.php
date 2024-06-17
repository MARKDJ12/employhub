<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO jobs (company_name, job_title, city, country, category, closing_date, job_type, experience_required, job_description, responsibilities, requirements, salary, contact_details) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("sssssssssssss", 
        $_POST['company'],
        $_POST['title'],
        $_POST['city'],
        $_POST['country'],
        $_POST['category'],
        $_POST['closing_date'],
        $_POST['job_type'],
        $_POST['experience'],
        $_POST['description'],
        $_POST['responsibilities'],
        $_POST['requirements'],
        $_POST['salary'],
        $_POST['contact_details']
    );

 if ($stmt->execute()) {
    echo "<div class='success-message'>";
    echo "<i class='fas fa-check-circle'></i>";
    echo "<p>Thank you for posting a job with us! Your job listing has been successfully submitted and will be reviewed shortly.</p>";
    echo "<p>You can view all posted jobs after the admin approval <a href='alljobs.php'>here</a>.</p>";
    echo "</div>";
} else {
    echo "<p>Error: " . $stmt->error . "</p>";
}

  

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Job</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
    <link rel="icon" type="image/x-icon" href="img/ourlogo.png">   
    <style>
        $stmt-{
            text-align: center;
        }
        body {
            font-size: 120%;
            background: url('img/lef.jpg') no-repeat center center fixed; /* Update the image path accordingly */
            background-size: cover;
            margin: 0;
            padding: 0;
            overflow-y: auto;
            height: 90vh; /* Set body height to 100% of viewport height */
        }

        .headed {
            background-color: #0009;
            color: white;
            text-align: center;
            padding: 10px;
        }

        .content {
            background-color: #fff;
            margin: auto;
            padding: 20px;
            width: 40%;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .success-message {
        background-color: #4CAF50;
        color: white;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
        margin-bottom: 20px;
    }

        .success-message i {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .input-group input[type="text"],
        .input-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            flex: 1; 
            margin-right: 10px;
        }

        .input-group {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap; 
        }

        .input-group label {
            flex: 1 0 100%; 
            margin-bottom: 0px;
        }

        .input-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            display: flex;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>



<div class="headed">
    <h2>Post a Job</h2>
</div>

<div class="content">
    <form method="post" action="#">
        <!-- Form fields for posting a job -->
        <div class="input-group">
            <label>Company Name</label>
            <input type="text" name="company" required>
        </div>
        <div class="input-group">
            <label>Job Title</label>
            <input type="text" name="title" required>
        </div>
        <div class="input-group">
            <label>City</label>
            <input type="text" name="city" required>
        </div>
        <div class="input-group">
            <label>Country</label>
<select name="country" required>
    <option value="">Select Country</option>
    <option value="Afghanistan">Afghanistan</option>
    <option value="Armenia">Armenia</option>
    <option value="Azerbaijan">Azerbaijan</option>
    <option value="Bahrain">Bahrain</option>
    <option value="Bangladesh">Bangladesh</option>
    <option value="Bhutan">Bhutan</option>
    <option value="Brunei">Brunei</option>
    <option value="Cambodia">Cambodia</option>
    <option value="China">China</option>
    <option value="Cyprus">Cyprus</option>
    <option value="Georgia">Georgia</option>
    <option value="India">India</option>
    <option value="Indonesia">Indonesia</option>
    <option value="Iran">Iran</option>
    <option value="Iraq">Iraq</option>
    <option value="Israel">Israel</option>
    <option value="Japan">Japan</option>
    <option value="Jordan">Jordan</option>
    <option value="Kazakhstan">Kazakhstan</option>
    <option value="Kuwait">Kuwait</option>
    <option value="Kyrgyzstan">Kyrgyzstan</option>
    <option value="Laos">Laos</option>
    <option value="Lebanon">Lebanon</option>
    <option value="Malaysia">Malaysia</option>
    <option value="Maldives">Maldives</option>
    <option value="Mongolia">Mongolia</option>
    <option value="Myanmar">Myanmar (Burma)</option>
    <option value="Nepal">Nepal</option>
    <option value="North Korea">North Korea</option>
    <option value="Oman">Oman</option>
    <option value="Pakistan">Pakistan</option>
    <option value="Palestine">Palestine</option>
    <option value="Philippines">Philippines</option>
    <option value="Qatar">Qatar</option>
    <option value="Saudi Arabia">Saudi Arabia</option>
    <option value="Singapore">Singapore</option>
    <option value="South Korea">South Korea</option>
    <option value="Sri Lanka">Sri Lanka</option>
    <option value="Syria">Syria</option>
    <option value="Taiwan">Taiwan</option>
    <option value="Tajikistan">Tajikistan</option>
    <option value="Thailand">Thailand</option>
    <option value="Timor-Leste">Timor-Leste</option>
    <option value="Turkey">Turkey</option>
    <option value="Turkmenistan">Turkmenistan</option>
    <option value="United Arab Emirates">United Arab Emirates</option>
    <option value="Uzbekistan">Uzbekistan</option>
    <option value="Vietnam">Vietnam</option>
    <option value="Yemen">Yemen</option>
</select>

        </div>
        <div class="input-group">
            <label>Job Category</label>
<select name="category" id="job_category" required>
    <option value="">Select Category</option>
    <option value="Accounting/Finance">Accounting/Finance</option>
    <option value="Administrative">Administrative</option>
    <option value="Customer Service">Customer Service</option>
    <option value="Engineering">Engineering</option>
    <option value="Human Resources">Human Resources</option>
    <option value="Information Technology">Information Technology</option>
    <option value="Marketing">Marketing</option>
    <option value="Sales">Sales</option>
    <option value="Healthcare">Healthcare</option>
    <option value="Education/Training">Education/Training</option>
    <option value="Hospitality/Travel">Hospitality/Travel</option>
    <option value="Retail">Retail</option>
    <option value="Manufacturing">Manufacturing</option>
    <option value="Construction">Construction</option>
    <option value="Legal">Legal</option>
    <option value="Media/Communication">Media/Communication</option>
    <option value="Art/Design">Art/Design</option>
    <option value="Transportation/Logistics">Transportation/Logistics</option>
</select>
        </div>
        <div class="input-group">
            <label>Closing Date</label>
            <input type="date" name="closing_date" required>
        </div>
        <div class="input-group">
            <label>Job Type</label>
            <select name="job_type" required>
                <option value="">Select Job Type</option>
                <option value="PartTime">PartTime</option> 
                <option value="FullTime">FullTime</option> 
                <option value="FreeLance">FreeLance</option>
            </select>
        </div>
        <div class="input-group">
            <label>Salary</label>
            <input type="text" name="salary" required>
        </div>
        <div class="input-group">
            <label>Experience</label>
            <select name="experience" required>
                <option value="select experience">Select Experience</option>
                <option value="1 Year">1-3 Years</option> 
                <option value="2 Years">2-3 Years</option> 
                <option value="3 Years">3-5 Years</option> 
                <option value="4 Years">4-6 Years</option>
                <option value="5 Years">5-10 Years</option>                                               
            </select>
        </div>
        <div class="input-group">
            <label>Job Description</label>
            <textarea name="description" required></textarea>
        </div>
        <div class="input-group">
            <label>Responsibilities</label>
            <textarea name="responsibilities" required></textarea>
        </div>
        <div class="input-group">
            <label>Requirements</label>
            <textarea name="requirements" required></textarea>
        </div>
<div class="input-group">
    <label>Contact Details</label>
    <textarea name="contact_details" placeholder="Email here:&#10;Contact Number here:" required></textarea>

</div>

        <div class="input-group">
            <button type="submit" class="btn" name="postjob">Post Job</button>
        </div>
    </form>
    <p style="text-align: center;"><a href="alljobs.php">Go to Alljobs</a></p>
</div>

</body>
</html>

<?php
require_once './core/dbConfig.php';
require_once './core/models.php';

$user_id = $_SESSION['user_id'];
$action = 'INSERT';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $job_title = $_POST['job_title'];
    $skills = $_POST['skills'];
    $years_of_experience = $_POST['years_of_experience'];
    $status = $_POST['status'];
    $added_by = $_SESSION['username'];

    try {
        // Insert the applicant into the database
        $stmt = $pdo->prepare("INSERT INTO applicants (first_name, last_name, email, phone, address, job_title, skills, years_of_experience, status, added_by)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$first_name, $last_name, $email, $phone, $address, $job_title, $skills, $years_of_experience, $status, $added_by]);

        // Log the activity
        $details = "Added applicant: $first_name $last_name";
        logActivity($pdo, $user_id, $action, $details);

        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Applicant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff0f6;
            color: #333;
        }

        .container {
            width: 60%;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #ff66b2;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #4a148c;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ff66b2;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        textarea {
            height: 100px;
        }

        button {
            padding: 10px 20px;
            background-color: #ff66b2;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ff3385;
        }

        .actions {
            display: flex;
            justify-content: space-between;
        }

        a {
            color: #ff66b2;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add Applicant</h1>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <form method="POST" action="">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" required>

            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="phone">Phone</label>
            <input type="tel" name="phone" id="phone" required>

            <label for="address">Address</label>
            <textarea name="address" id="address" required></textarea>

            <label for="job_title">Job Title</label>
            <input type="text" name="job_title" id="job_title" required>

            <label for="skills">Skills</label>
            <input type="text" name="skills" id="skills" required>

            <label for="years_of_experience">Years of Experience</label>
            <input type="text" name="years_of_experience" id="years_of_experience" required>

            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="Pending">Pending</option>
                <option value="Shortlisted">Shortlisted</option>
                <option value="Hired">Hired</option>
                <option value="Rejected">Rejected</option>
            </select>

            <div class="actions">
                <button type="submit">Save</button>
                <a href="index.php"><button type="button">Back to Dashboard</button></a>
            </div>
        </form>
    </div>
</body>

</html>
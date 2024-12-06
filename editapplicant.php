<<?php
    require_once './core/dbConfig.php';
    require_once './core/models.php';

    $user_id = $_SESSION['user_id'];
    $action = 'EDIT';

    $id = isset($_GET['id']) ? intval($_GET['id']) : null;
    if (!$id) {
        die('Applicant ID is required');
    }

    $applicant = fetchApplicantById($pdo, $id);
    if (!$applicant) {
        die('Applicant not found');
    }

    $first_name = $applicant['first_name'];
    $last_name = $applicant['last_name'];
    $email = $applicant['email'];
    $phone = $applicant['phone'];
    $address = $applicant['address'];
    $job_title = $applicant['job_title'];
    $skills = $applicant['skills'];
    $years_of_experience = $applicant['years_of_experience'];
    $status = $applicant['status'];

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

        try {
            // Update the applicant in the database
            $stmt = $pdo->prepare("UPDATE applicants SET first_name = ?, last_name = ?, email = ?, phone = ?, address = ?, job_title = ?, skills = ?, years_of_experience = ?, status = ? WHERE id = ?");
            $stmt->execute([$first_name, $last_name, $email, $phone, $address, $job_title, $skills, $years_of_experience, $status, $id]);

            // Log the activity
            $details = "Edited applicant: $first_name $last_name";
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
        <title>Edit Applicant</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #fce4ec;
                color: #4a148c;
            }

            .container {
                width: 60%;
                margin: auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            h1 {
                text-align: center;
                color: #e91e63;
            }

            label {
                display: block;
                margin: 10px 0 5px;
            }

            input,
            textarea,
            select {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            button {
                background-color: #e91e63;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                width: 100%;
            }

            button:hover {
                background-color: #d81b60;
            }

            .form-container {
                margin-top: 20px;
            }

            a {
                color: #e91e63;
                text-decoration: none;
            }

            a:hover {
                text-decoration: underline;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h1>Edit Applicant</h1>
            <form method="POST" class="form-container">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($applicant['email']) ?>" required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($applicant['phone']) ?>" required>

                <label for="address">Address:</label>
                <textarea id="address" name="address" required><?= htmlspecialchars($applicant['address']) ?></textarea>

                <label for="job_title">Job Title:</label>
                <input type="text" id="job_title" name="job_title" value="<?= htmlspecialchars($applicant['job_title']) ?>" required>

                <label for="skills">Skills:</label>
                <input type="text" id="skills" name="skills" value="<?= htmlspecialchars($applicant['skills']) ?>" required>

                <label for="years_of_experience">Years of Experience:</label>
                <input type="number" id="years_of_experience" name="years_of_experience" value="<?= htmlspecialchars($applicant['years_of_experience']) ?>" required>

                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="Pending" <?= $applicant['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Shortlisted" <?= $applicant['status'] == 'Shortlisted' ? 'selected' : '' ?>>Shortlisted</option>
                    <option value="Hired" <?= $applicant['status'] == 'Hired' ? 'selected' : '' ?>>Hired</option>
                    <option value="Rejected" <?= $applicant['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                </select>

                <button type="submit">Update Applicant</button>
            </form>
            <p><a href="index.php">Back to Applicants List</a></p>
        </div>
    </body>

    </html>
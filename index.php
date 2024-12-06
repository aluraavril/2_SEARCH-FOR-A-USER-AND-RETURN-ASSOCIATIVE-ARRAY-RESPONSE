<?php
require_once './core/dbConfig.php';
require_once './core/models.php';

$search = $_GET['search'] ?? null;
$applicants = fetchApplicants($pdo, $search)['querySet'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Application System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff0f6;
            color: #333;
        }

        .container {
            width: 80%;
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

        .actions {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        input[type="text"] {
            padding: 10px;
            border: 2px solid #ff66b2;
            border-radius: 4px;
            width: 300px;
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

        a {
            color: #ff66b2;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #ff66b2;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        .logout {
            position: absolute;
            top: 20px;
            left: 160px;
        }

        .logout button {
            background-color: #ff66b2;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout button:hover {
            background-color: #ff3385;
        }
    </style>
</head>

<body>

    <div class="logout">
        <a href="logout.php"><button>Logout</button></a>
    </div>

    <div class="container">
        <h1>Teacher Application System</h1>
        <div class="actions">
            <form method="GET" action="" style="display: inline-block;">
                <input type="text" name="search" placeholder="Search applicants" value="<?= htmlspecialchars($search ?? '') ?>">
                <button type="submit">Search</button>
            </form>
            <?php if ($search): ?>
                <a href="index.php"><button type="button">Back to Main</button></a>
            <?php endif; ?>
            <a href="addApplicant.php"><button type="button">Add Applicant</button></a>
            <a href="activity_logs.php"><button type="button">Activity Logs</button></a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Job Title</th>
                    <th>Skills</th>
                    <th>Years of Experience</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($applicants)): ?>
                    <?php foreach ($applicants as $applicant): ?>
                        <tr>
                            <td><?= htmlspecialchars($applicant['first_name']) ?></td>
                            <td><?= htmlspecialchars($applicant['last_name']) ?></td>
                            <td><?= htmlspecialchars($applicant['email']) ?></td>
                            <td><?= htmlspecialchars($applicant['phone']) ?></td>
                            <td><?= htmlspecialchars($applicant['address']) ?></td>
                            <td><?= htmlspecialchars($applicant['job_title']) ?></td>
                            <td><?= htmlspecialchars($applicant['skills']) ?></td>
                            <td><?= htmlspecialchars($applicant['years_of_experience']) ?></td>
                            <td><?= htmlspecialchars($applicant['status']) ?></td>
                            <td>
                                <a href="editApplicant.php?id=<?= $applicant['id'] ?>">Edit</a> |
                                <a href="deleteApplicant.php?delete=<?= $applicant['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" style="text-align: center;">No applicants found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>
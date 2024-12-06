<?php
function fetchApplicants($pdo, $search = null)
{
    $sql = "SELECT * FROM applicants";
    if ($search) {
        $sql .= " WHERE CONCAT_WS(' ', first_name, last_name, email, phone, address, job_title, skills, status) LIKE ?";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($search ? ["%$search%"] : []);

    // Log the search query
    if ($search) {
        $log_sql = "INSERT INTO activity_logs (user_id, action_type, description) VALUES (:user_id, 'SEARCH', 'Searched for: $search')";
        $log_stmt = $pdo->prepare($log_sql);
        $log_stmt->execute(['user_id' => $_SESSION['user_id']]);
    }

    return [
        'message' => 'Applicants fetched successfully.',
        'statusCode' => 200,
        'querySet' => $stmt->fetchAll()
    ];
}


function insertApplicant($pdo, $data)
{
    try {
        $sql = "INSERT INTO applicants (first_name, last_name, email, phone, address, job_title, skills, years_of_experience, status, added_by) 
                VALUES (:first_name, :last_name, :email, :phone, :address, :job_title, :skills, :years_of_experience, :status, :added_by)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

        // Log the activity
        $log_sql = "INSERT INTO activity_logs (user_id, action_type, description) VALUES (:user_id, 'INSERTION', 'Added applicant: {$data['first_name']} {$data['last_name']}')";
        $log_stmt = $pdo->prepare($log_sql);
        $log_stmt->execute(['user_id' => $_SESSION['user_id']]);

        return ['message' => 'Applicant added successfully.', 'statusCode' => 200];
    } catch (PDOException $e) {
        return ['message' => 'Error: ' . $e->getMessage(), 'statusCode' => 400];
    }
}



function updateApplicant($pdo, $id, $data)
{
    try {
        $sql = "UPDATE applicants SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, 
                address = :address, job_title = :job_title, skills = :skills, status = :status, added_by = :added_by 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $data['id'] = $id;
        $stmt->execute($data);

        // Log the activity
        $log_sql = "INSERT INTO activity_logs (user_id, action_type, description) VALUES (:user_id, 'UPDATING', 'Updated applicant ID: $id')";
        $log_stmt = $pdo->prepare($log_sql);
        $log_stmt->execute(['user_id' => $_SESSION['user_id']]);

        return ['message' => 'Applicant updated successfully.', 'statusCode' => 200];
    } catch (PDOException $e) {
        return ['message' => 'Error: ' . $e->getMessage(), 'statusCode' => 400];
    }
}


function deleteApplicant($pdo, $id)
{
    try {
        $sql = "DELETE FROM applicants WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        // Log the activity
        $log_sql = "INSERT INTO activity_logs (user_id, action_type, description) VALUES (:user_id, 'DELETION', 'Deleted applicant ID: $id')";
        $log_stmt = $pdo->prepare($log_sql);
        $log_stmt->execute(['user_id' => $_SESSION['user_id']]);

        return [
            'message' => 'Applicant deleted successfully.',
            'statusCode' => 200
        ];
    } catch (PDOException $e) {
        return [
            'message' => 'Error deleting applicant: ' . $e->getMessage(),
            'statusCode' => 400
        ];
    }
}



function fetchApplicantById($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM applicants WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function fetchActivityLogs($pdo)
{
    // Prepare the query to fetch logs
    $stmt = $pdo->prepare("SELECT al.id, u.username AS user_name, al.action, al.timestamp, al.details
                           FROM activity_logs al
                           JOIN users u ON al.user_id = u.id
                           ORDER BY al.timestamp DESC");
    // Execute the query
    $stmt->execute();

    // Fetch the results as an associative array
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function logActivity($pdo, $user_id, $action, $details)
{
    $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action, details) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $action, $details]);
}

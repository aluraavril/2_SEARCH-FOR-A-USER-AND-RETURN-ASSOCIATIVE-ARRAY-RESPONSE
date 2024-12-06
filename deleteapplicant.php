<?php
require_once './core/dbConfig.php';
require_once './core/models.php';

$user_id = $_SESSION['user_id'];
$action = 'DELETE';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    try {
        // Fetch the applicant's details before deleting
        $stmt = $pdo->prepare("SELECT first_name, last_name FROM applicants WHERE id = ?");
        $stmt->execute([$id]);
        $applicant = $stmt->fetch();

        if ($applicant) {
            $details = "Deleted applicant: " . $applicant['first_name'] . " " . $applicant['last_name'];

            // Log the activity
            logActivity($pdo, $user_id, $action, $details);

            // Delete the applicant
            $stmt = $pdo->prepare("DELETE FROM applicants WHERE id = ?");
            $stmt->execute([$id]);

            echo "<script>alert('Applicant deleted successfully.'); window.location = 'index.php';</script>";
        } else {
            echo "<script>alert('Applicant not found.'); window.location = 'index.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

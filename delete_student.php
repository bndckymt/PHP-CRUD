<?php
/**
 * delete_student.php
 *
 * This script deletes a student record from the database based on the provided ID.
 * It connects to the database, prepares a DELETE SQL statement, and executes it.
 * If the deletion is successful, it redirects to the list_student.php page with a success message.
 * If no record is found or an error occurs, it redirects with an appropriate error message.
 */

/**
 * Include the database connection file.
 */
require("db_connect.php");

/**
 * Check if the 'id' parameter is set in the URL and is a numeric value.
 * If valid, proceed to delete the student record.
 * If invalid, display an error message and redirect to the list_student.php page.
 */
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        /**
         * Prepare the DELETE SQL statement with a parameterized query to prevent SQL injection.
         * Bind the 'id' parameter to the query and execute it.
         */
        $stmt = $conn->prepare("DELETE FROM tblstudent WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        /**
         * Check if any row was affected by the DELETE operation.
         * If yes, display a success message and redirect to the list_student.php page.
         * If no, display a message indicating no record was found and redirect.
         */
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Student deleted successfully!'); window.location='list_student.php';</script>";
        } else {
            echo "<script>alert('No record found with this ID.'); window.location='list_student.php';</script>";
        }
    } catch (PDOException $e) {
        /**
         * Catch any PDO exceptions that occur during the DELETE operation.
         * Display an error message and redirect to the list_student.php page.
         */
        echo "<script>alert('Error deleting student: " . $e->getMessage() . "'); window.location='list_student.php';</script>";
    }
} else {
    /**
     * If the 'id' parameter is not set or is not numeric, display an error message and redirect.
     */
    echo "<script>alert('Invalid ID!'); window.location='list_student.php';</script>";
}
?>

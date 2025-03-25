<?php
// Include the database connection file
require("db_connect.php");
?>

<!-- Link to the "Add Student" page -->
<a href="add_student.php">Add Student</a>

<!-- Table to display student records -->
<table border="1" cellpadding="10" align="center">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Sex</th>
            <th>Course</th>
            <th>Action</th> <!-- Column for edit & delete actions -->
        </tr>
    </thead>
    <tbody>
        <?php
        // Query to retrieve all records from the student table
        $sql = "SELECT * FROM tblstudent";

        // Execute the query
        $res = $conn->query($sql);
        $res->execute();

        // Check if any records exist
        if ($res->rowCount() > 0) {
            $i = 1; // Counter for numbering the students

            // Fetch each row from the result set
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . $i . "</td> <!-- Display record number -->
                        <td>" . $row['name'] . "</td> <!-- Display student name -->
                        <td>" . $row['address'] . "</td> <!-- Display student address -->
                        <td>" . $row['sex'] . "</td> <!-- Display student gender -->
                        <td>" . $row['course'] . "</td> <!-- Display student course -->
                        <td>
                            <!-- Edit link with student ID -->
                            <a href='edit.php?id=" . $row['id'] . "'>Edit</a>
                            <!-- Delete link with student ID -->
                            <a href='delete_student.php?id=" . $row['id'] . "'>Delete</a>
                        </td>
                    </tr>";
                $i++; // Increment counter
            }
        } else {
            // Display message if no data is found
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        ?>
    </tbody>
</table>

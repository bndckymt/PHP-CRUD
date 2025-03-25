<?php
    // Check if the form has been submitted by checking if 'btnsave' is set in the POST request
    if (isset($_POST['btnsave'])) {
        // Retrieve form input values
        $name = $_POST['txtname'];
        $address = $_POST['txtaddress'];
        $sex = $_POST['cbosex'];
        $course = $_POST['txtcourse'];

        // Input validation: Check if any required field is empty
        if ($name == '') {
            echo "<script>alert('Name is required');</script>";
        } else if ($address == '') {
            echo "<script>alert('Address is required');</script>";
        } else if ($sex == '') {
            echo "<script>alert('Sex is required');</script>"; 
        } else if ($course == '') {
            echo "<script>alert('Course is required');</script>";    
        } else {
            // Include database connection file
            require("db_connect.php");

            // SQL query to insert the student's details into the database
            $sql = "INSERT INTO tblstudent (name, address, sex, course) VALUES (:name, :address, :sex, :course)";

            // Prepare the SQL statement
            $result = $conn->prepare($sql);
            $values = array(":name" => $name, ":address" => $address, ":sex"=> $sex, ":course"=> $course);

            // Execute the SQL query with provided values
            $result->execute($values);

            // Check if the insertion was successful
            if ($result->rowCount() > 0) {
                echo "<script>alert('Student added successfully'); window.location = 'list_student.php';</script>";
            } else {
                echo "<script>alert('Failed to add Student');</script>";
            }
        }
    }
?>
<html>
    <head>
        <title>Add Student</title>
    </head>
    <body>
        <!-- Form for adding a student -->
        <form action="add_student.php" method="post">
        <table align="center" border="1" cellpadding="10">
            <tr align="center">
                <td colspan="2">Add Student</td>
            </tr>

            <tr>
                <td>Name:</td>
                <!-- Input field for the student's name -->
                <td><input type="text" name="txtname" placeholder="Name"></td>
            </tr>

            <tr>
                <td>Address:</td>
                <!-- Input field for the student's address -->
                <td><input type="text" name="txtaddress" placeholder="Address"></td>
            </tr>

            <tr>
                <td>Sex:</td>
                <!-- Dropdown menu for selecting the student's sex -->
                <td>
                    <select name="cbosex">
                        <option value="">Sex</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Course:</td>
                <!-- Input field for the student's course -->
                <td><input type="text" name="txtcourse" placeholder="Course"></td>
            </tr>

            <tr>
                <td colspan="2">
                    <!-- Submit button to save the student record -->
                    <input type="submit" value="Save" name="btnsave">
                </td>
            </tr>
        </table>
        </form>
    </body>
</html>

/*
Summary:
- This script allows users to add a new student to the database.
- It collects user inputs from a form (Name, Address, Sex, Course).
- Validates that required fields are not empty.
- If validation passes, it inserts the data into the database using PDO.
- If the insertion is successful, it redirects to a student list page.
- If any required field is missing, an alert message is displayed.
*/

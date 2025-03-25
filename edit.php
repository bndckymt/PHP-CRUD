<?php
require("db_connect.php");

// Fetch student data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM tblstudent WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo "<script>alert('Student not found'); window.location='list_student.php';</script>";
        exit();
    }
}

// Handle update request
if (isset($_POST['btnupdate'])) {
    $id = $_POST['id'];
    $name = $_POST['txtname'];
    $address = $_POST['txtaddress'];
    $sex = $_POST['cbosex'];
    $course = $_POST['txtcourse'];

    $sql = "UPDATE tblstudent SET name = :name, address = :address, sex = :sex, course = :course WHERE id = :id";
    $stmt = $conn->prepare($sql);

    $values = [
        ':name' => $name,
        ':address' => $address,
        ':sex' => $sex,
        ':course' => $course,
        ':id' => $id
    ];

    if ($stmt->execute($values)) {
        header("Location: list_student.php");
        exit();
    } else {
        echo "<script>alert('Failed to update student');</script>";
    }
}
?>

<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <form action="edit.php" method="post">
        <input type="hidden" name="id" value="<?= $student['id'] ?>">
        <table align="center" border="1" cellpadding="10">
            <tr align="center">
                <td colspan="2">Edit Student</td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><input type="text" name="txtname" value="<?= $student['name'] ?>"></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><input type="text" name="txtaddress" value="<?= $student['address'] ?>"></td>
            </tr>
            <tr>
                <td>Sex:</td>
                <td>
                    <select name="cbosex">
                        <option value="1" <?= ($student['sex'] == 1) ? 'selected' : '' ?>>Male</option>
                        <option value="2" <?= ($student['sex'] == 2) ? 'selected' : '' ?>>Female</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Course:</td>
                <td><input type="text" name="txtcourse" value="<?= $student['course'] ?>"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Update" name="btnupdate"></td>
            </tr>
        </table>
    </form>
</body>
</html>

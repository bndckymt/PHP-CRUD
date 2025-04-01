<?php
// Database configuration
$servername = "localhost";
$username = "root";      // Change to your MariaDB username
$password = "";          // Change to your MariaDB password
$dbname = "user_management";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create users table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

// Initialize variables
$id = 0;
$first_name = "";
$last_name = "";
$email = "";
$phone = "";
$update = false;
$message = "";
$message_type = "";

// Create or Update record
if (isset($_POST['save'])) {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update existing record
        $id = $conn->real_escape_string($_POST['id']);
        $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', phone='$phone' WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Record updated successfully";
            $message_type = "success";
        } else {
            $message = "Error updating record: " . $conn->error;
            $message_type = "danger";
        }
    } else {
        // Insert new record
        $sql = "INSERT INTO users (first_name, last_name, email, phone) VALUES ('$first_name', '$last_name', '$email', '$phone')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Record created successfully";
            $message_type = "success";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
            $message_type = "danger";
        }
    }
    
    // Reset form
    $id = 0;
    $first_name = "";
    $last_name = "";
    $email = "";
    $phone = "";
    $update = false;
}

// Edit record
if (isset($_GET['edit'])) {
    $id = $conn->real_escape_string($_GET['edit']);
    $update = true;
    
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        $phone = $row['phone'];
    }
}

// Delete record
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    
    $sql = "DELETE FROM users WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "Record deleted successfully";
        $message_type = "success";
    } else {
        $message = "Error deleting record: " . $conn->error;
        $message_type = "danger";
    }
}

// Fetch all records
$sql = "SELECT * FROM users ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MariaDB CRUD Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 1000px;
            margin-top: 30px;
        }
        h1 {
            margin-bottom: 30px;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">User Management System</h1>
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3><?php echo $update ? 'Update User' : 'Add User'; ?></h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>">
                            </div>
                            
                            <button type="submit" name="save" class="btn btn-primary">
                                <?php echo $update ? 'Update' : 'Save'; ?>
                            </button>
                            
                            <?php if ($update): ?>
                                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="btn btn-secondary">Cancel</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>User List</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0): ?>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['phone']; ?></td>
                                                <td><?php echo $row['created_at']; ?></td>
                                                <td>
                                                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?edit=' . $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?delete=' . $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No records found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
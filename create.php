<?php
require_once "db.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $age = trim($_POST["age"]);

    if (empty($name)) {
        $errors[] = "Full name is required!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email!";
    }

    if (!is_numeric($age) || $age < 1) {
        $errors[] = "Please enter a valid age!";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO students (full_name, email, age) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $age]);
        
        echo "Student added successfully!";
    }
}
?>
<?php if (!empty($errors)): ?>
    <div class="error">
        <?php foreach ($errors as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
require_once "db.php";

$errors = [];

$name = $email = $age = $course = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    
    $age = trim($_POST["age"] ?? "");
    $course = trim($_POST["course"] ?? "");

    if ($name == "") $errors[] = "Name is required.";

    if ($email == "") {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email.";
    }

    if (!ctype_digit($age) || $age < 10 || $age > 100)
        $errors[] = "Age must be between 10 and 1000.";

    if (empty($errors)) {
        try {
            $sql = "INSERT INTO students
                    (full_name, email, age, course)
                    VALUES (?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $email, $age, $course]);

            header("Location: index.php?success=created");
            exit;

        } catch (PDOException $e) {
            $errors[] = "Email already exists or registration failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <style>
    input {
    width: 100%;
    padding: 14px;
    margin: 10px 0;
    border: 2px solid #007bff;
    border-radius: 8px;
    background-color: #eef6ff;
    color: #222;
    font-size: 16px;
    outline: none;
    transition: 0.3s;
}

input:focus {
    border-color: #28a745;
    background-color: #e8fff0;
    box-shadow: 0 0 8px #28a745;
}

input::placeholder {
    color: #555;
}

button {
    width: 100%;
    padding: 13px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background: #0056b3;
}
</style>
    <style>
    * {
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background: #f2f4f8;
    margin: 0;
    padding: 30px;
}

.container {
    background: white;
    
    max-width: 30x;
    margin: 10px auto;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 3px 10px #ccc;
}

h2 {
    text-align: center;
    color: #333;
}

input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background: #007bff;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #0056b3;
}

.add {
    background: #28a745;
    color: white;
    padding: 10px;
    text-decoration: none;
    border-radius: 5px;
}

.delete {
    background: #dc3545;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 5px;
    border: 1px solid #ddd;
    text-align: center;
}

th {
    background: #007bff;
    color: sky blue;
}

.error {
    color: red;
}

.success {
    color: green;
}

a {
    text-decoration: none;
    color: #007bff;
}

form {
    margin-top: 15px;
}
</style>
</head>

<body>

<h2>Register Student</h2>

<?php foreach ($errors as $error): ?>
    <p style="color:red;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endforeach; ?>

<form method="POST">

    <input type="text" name="full_name"
    placeholder="Full Name"
    value="<?= htmlspecialchars($name) ?>"><br><br>

    <input type="email" name="email"
    placeholder="Email"
    value="<?= htmlspecialchars($email) ?>"><br><br>

    <input type="number" name="age"
    placeholder="Age" min="10" max="100"
    value="<?= htmlspecialchars($age) ?>"><br><br>

    <input type="text" name="course"
    placeholder="Course"
    value="<?= htmlspecialchars($course) ?>"><br><br>

    <button type="submit">Save Student</button>

</form>

<a href="index.php">Back</a>

</body>
</html>
<?php
require_once "db.php";

$id = $_GET["id"] ?? "";

$stmt = $pdo->prepare("SELECT * FROM students WHERE id=?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) die("Student not found.");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);

    $age = $_POST["age"];
    $course = trim($_POST["course"]);

    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL)
        && ctype_digit($age) && $age >= 10 && $age <= 100) {

        $sql = "UPDATE students SET full_name=?, email=?, age=?, course=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([$name, $email, $age, $course, $id]);

        header("Location: index.php?success=updated");
        exit;
    }

    echo "Invalid information.";
}
?>

<h2>Edit Student</h2>

<form method="POST">
    <input name="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" required><br><br>

    <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required><br><br>

    <input type="number" name="age" value="<?= htmlspecialchars($student['age']) ?>" min="10" max="100" required><br><br>

    <input name="course" value="<?= htmlspecialchars($student['course'] ?? '') ?>"><br><br>

    <button type="submit">Update Student</button>
</form>

<a href="index.php">Back</a>
<?php
require_once "db.php";

$students = $pdo->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();
?>

<h2>Head Manager</h2>
<a href="create.php">Add Student name</a>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th><th>Name</th><th>Email</th>
    <th>Age</th><th>Course</th><th>Action</th>
</tr>

<?php if (!$students): ?>
<tr><td colspan="6">No students found</td></tr>
<?php endif; ?>

<?php foreach ($students as $s): ?>
<tr>
    <td><?= $s['id'] ?></td>
    <td><?= htmlspecialchars($s['full_name']) ?></td>
    <td><?= htmlspecialchars($s['email']) ?></td>
    <td><?= $s['age'] ?></td>
    <td><?= htmlspecialchars($s['course'] ?? '') ?></td>
    <td>
        <a href="edit.php?id=<?= $s['id'] ?>">Edit</a>
        <form action="delete.php" method="POST">
            <input type="hidden" name="id" value="<?= $s['id'] ?>">
            <button onclick="return confirm('Delete student?')">Delete</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>
<!DOCTYPE html>
<html>
    <head>
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
    max-width: 900px;
    margin: 40px auto;
    padding: 25px;
    border-radius: 10px;
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
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background: #007bff;
    color: white;
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
</html>
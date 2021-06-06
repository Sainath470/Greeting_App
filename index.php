<?php
$errors = "";
$id = 0;
$task = "";
$edit_option = false;
//connecting to database
$db = mysqli_connect('localhost', 'root', 'Sainath@8801', 'todo');
//if add task button is clicked
if (isset($_POST['add_task'])) {
    if (empty($_POST['task'])) {
        $errors = "You must fill in the task";
    } else {
        $id = $_POST['add_task'];
        $task = $_POST['task'];
        $insert_query = "INSERT INTO tasks (task) VALUES ('$task')";
        mysqli_query($db, $insert_query);
        header('location: index.php'); //redirecting to the index.php after inserting
    }
}
// retrieveing records from the database
$retrieve = mysqli_query($db, "SELECT * FROM tasks");

// update records in database
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $task = $_POST['task'];
    $update_query = "UPDATE tasks set task = '$task' WHERE id=$id";
    mysqli_query($db, $update_query);
    header('location:index.php');
}

//fetching the record to update
if (isset($_GET['edit_task'])) {
    $id = $_GET['edit_task'];
    $edit_option = true;
    $retrieve_query = mysqli_query($db, "SELECT * FROM tasks WHERE id=$id");
    $record = mysqli_fetch_array($retrieve_query);
    $id = $record['id'];
    $task = $record['task'];
}

//deleting record
if (isset($_GET['delete_task'])) {
    $id = $_GET['delete_task'];
    mysqli_query($db, "DELETE FROM tasks WHERE id=" . $id);
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List Application</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="heading">
        <h2 style="font-style: 'Hervetica';">ToDo List Application PHP and MySQL database</h2>
    </div>
    <form method="post" action="index.php">
    <?php if (isset($errors)) { ?>
    <p><?php echo $errors; }?></p>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="input-task">
            <input type="text" name="task" placeholder="Enter task here..." value="<?php echo $task; ?>">
            <?php if ($edit_option == false) : ?>
                <button type="submit" name="add_task" class="btn" onclick="greetFunction1()">Add Task</button>
            <?php else : ?>
                <button type="submit" name="update" class="btn" onclick="greetFunction2()">Update</button>
            <?php endif ?>

        </div>
    </form>
    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Task</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            while ($row = mysqli_fetch_array($retrieve)) { ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['task']; ?></td>
                    <td>
                        <a class="edit_btn" href="index.php?edit_task=<?php echo $row['id']; ?>">Edit</a>
                    </td>
                    <td>
                        <a class="del_btn" href="index.php?delete_task=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
</body>
<script>
function greetFunction1(){
    alert("Hello! Welcome to todo Application");
    alert("task recorded successfully!");
    }
function greetFunction2(){
    alert("Details updated succesfully!");
}
</script>

</html>
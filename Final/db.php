<?php

include "config.php";

$success = "";
$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $department = $_POST["department"];
    $age = $_POST["age"];


    // 1. INSERT

    if(isset($_POST["insert"]))
    {
        if(empty($username) || empty($password) || empty($email) ||
           empty($phone) || empty($department) || empty($age))
        {
            $error = "Fill the form";
        }
        else
        {
            $sql = "INSERT INTO wt_k
            (username, password, email, phone, department, age)
            VALUES
            ('$username', '$password', '$email', '$phone', '$department', '$age')";

            if($conn->query($sql) === TRUE)
            {
                $success = "Registration complete";
            }
            else
            {
                $error = "Error: " . $conn->error;
            }
        }
    }


    // 2. DISPLAY

    if(isset($_POST["display"]))
    {
        $sql = "SELECT * FROM wt_k";

        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                echo $row["id"] . " ";
                echo $row["username"] . " ";
                echo $row["email"] . " ";
                echo $row["phone"] . " ";
                echo $row["department"] . " ";
                echo $row["age"] . "<br>";
            }
        }
        else
        {
            $error = "No records found";
        }
    }


    // 3. UPDATE

    if(isset($_POST["update"]))
    {
        $id = $_POST["id"];

        $sql = "UPDATE wt_k SET
        username='$username',
        password='$password',
        email='$email',
        phone='$phone',
        department='$department',
        age='$age'
        WHERE id='$id'";

        if($conn->query($sql) === TRUE)
        {
            $success = "Data updated successfully";
        }
        else
        {
            $error = "Error: " . $conn->error;
        }
    }


    // 4. DELETE

    if(isset($_POST["delete"]))
    {
        $id = $_POST["id"];

        $sql = "DELETE FROM wt_k WHERE id='$id'";

        if($conn->query($sql) === TRUE)
        {
            $success = "Data deleted successfully";
        }
        else
        {
            $error = "Error: " . $conn->error;
        }
    }


    // 5. SEARCH

    if(isset($_POST["search"]))
    {
        $id = $_POST["id"];

        $sql = "SELECT * FROM wt_k WHERE id='$id'";

        $result = $conn->query($sql);

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();

            echo "Username: " . $row["username"] . "<br>";
            echo "Email: " . $row["email"] . "<br>";
            echo "Phone: " . $row["phone"] . "<br>";
            echo "Department: " . $row["department"] . "<br>";
            echo "Age: " . $row["age"] . "<br>";
        }
        else
        {
            $error = "User not found";
        }
    }


    // 6. COUNT

    if(isset($_POST["count"]))
    {
        $sql = "SELECT COUNT(*) AS total FROM wt_k";

        $result = $conn->query($sql);

        $row = $result->fetch_assoc();

        $success = "Total users: " . $row["total"];
    }
}

?>

<!DOCTYPE html>
<html>
<body>

<h2>Registration Form</h2>

<?php

if($success != "")
{
    echo $success . "<br>";
}

if($error != "")
{
    echo $error . "<br>";
}

?>

<form method="POST">

    ID:
    <input type="number" name="id"><br><br>

    Username:
    <input type="text" name="username"><br><br>

    Password:
    <input type="password" name="password"><br><br>

    Email:
    <input type="email" name="email"><br><br>

    Phone:
    <input type="text" name="phone"><br><br>

    Department:
    <input type="text" name="department"><br><br>

    Age:
    <input type="number" name="age"><br><br>

    <input type="submit" name="insert" value="Insert">

    <input type="submit" name="display" value="Display">

    <input type="submit" name="update" value="Update">

    <input type="submit" name="delete" value="Delete">

    <input type="submit" name="search" value="Search">

    <input type="submit" name="count" value="Count">

</form>

</body>
</html>
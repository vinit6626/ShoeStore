<?php
require_once('db_conn.php');

function sanitizeInput($input)
{
    $input = strip_tags($input);
    $input = trim($input);
    $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

function validateSpecialCharacters($input)
{
    if (preg_match('/[\(\){\}<>]/', $input)) {
        return false;
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = [];

    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $errors = [];

    if (empty($username)) {
        $errors['username'] = "Username is required";
    } else if (strlen($username) > 50) {
        $errors['username'] = "Username should not exceed 50 characters";
    } else if (!validateSpecialCharacters($username)) {
        $errors['username'] = "Username should not contain special characters () {} <>";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    } else if (strlen($email) > 200) {
        $errors['email'] = "Email should not exceed 200 characters";
    } else if (!validateSpecialCharacters($email)) {
        $errors['email'] = "Email should not contain special characters () {} <>";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    } else if (strlen($password) < 6) {
        $errors['password'] = "Password should be at least 6 characters long";
    } else if (!validateSpecialCharacters($password)) {
        $errors['password'] = "Password should not contain special characters () {} <>";
    }

    if (empty($cpassword)) {
        $errors['cpassword'] = "Confirm Password is required";
    } else if ($password !== $cpassword) {
        $errors['cpassword'] = "Passwords do not match";
    }

    if (empty($errors)) {
        $sql_insert_query = "INSERT INTO users (username, email, userPassword) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert_query);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);

        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            $response['success'] = true;
            $response['message'] = "User registered successfully.";
        } else {
            $response['success'] = false;
            $response['message'] = "Error inserting user: " . mysqli_error($conn);
        }

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Return JSON response with errors
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'errors' => $errors]);
    }
}
?>

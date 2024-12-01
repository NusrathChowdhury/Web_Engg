<?php
define('TITLE', 'Submit Request Success');
define('PAGE', 'SubmitRequest');
include('includes/header.php');
include('../dbConnection.php');

session_start();

if (!isset($_SESSION['is_login']) || !isset($_SESSION['myid'])) {
    echo "<script> location.href='RequesterLogin.php'; </script>";
    exit;
}

$myid = $_SESSION['myid'];

$sql = "SELECT * FROM submitrequest_tb WHERE request_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("<div class='alert alert-danger'>Error preparing statement: " . $conn->error . "</div>");
}
$stmt->bind_param("i", $myid);
if (!$stmt->execute()) {
    die("<div class='alert alert-danger'>Error executing query: " . $stmt->error . "</div>");
}
$result = $stmt->get_result();

if ($result && $result->num_rows == 1) {
    $row = $result->fetch_assoc();
    echo "<div class='ml-5 mt-5'>
    <h3>Request Submitted Successfully</h3>
    <p>Your request has been successfully submitted. Below are the details:</p>
    <table class='table'>
    <tbody>
    <tr>
    <th>Request ID</th>
    <td>" . htmlspecialchars($row['request_id']) . "</td>
    </tr>
    <tr>
    <th>Name</th>
    <td>" . htmlspecialchars($row['requester_name']) . "</td>
    </tr>
    <tr>
    <th>Email ID</th>
    <td>" . htmlspecialchars($row['requester_email']) . "</td>
    </tr>
    <tr>
    <th>Request Info</th>
    <td>" . htmlspecialchars($row['request_info']) . "</td>
    </tr>
    <tr>
    <th>Request Description</th>
    <td>" . htmlspecialchars($row['request_desc']) . "</td>
    </tr>
    <tr>
    <th>Address Line 1</th>
    <td>" . htmlspecialchars($row['requester_add1']) . "</td>
    </tr>
    <tr>
    <th>Address Line 2</th>
    <td>" . htmlspecialchars($row['requester_add2']) . "</td>
    </tr>
    <tr>
    <th>City</th>
    <td>" . htmlspecialchars($row['requester_city']) . "</td>
    </tr>
    <tr>
    <th>State</th>
    <td>" . htmlspecialchars($row['requester_state']) . "</td>
    </tr>
    <tr>
    <th>Zip Code</th>
    <td>" . htmlspecialchars($row['requester_zip']) . "</td>
    </tr>
    <tr>
    <th>Mobile</th>
    <td>" . htmlspecialchars($row['requester_mobile']) . "</td>
    </tr>
    <tr>
    <th>Request Date</th>
    <td>" . htmlspecialchars($row['request_date']) . "</td>
    </tr>
    <tr>
    <th><form class='d-print-none'>
        <input class='btn btn-info' type='button' value='Print' onClick='window.print()'>
    </form></th>
    </tr>
    </tbody>
    </table>
    </div>";
} else {
    echo "<div class='alert alert-danger'>Unable to fetch request details. Please try again later.</div>";
}

$stmt->close();
$conn->close();
?>

<?php include('includes/footer.php'); ?>
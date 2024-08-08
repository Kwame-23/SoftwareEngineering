<?php
include '../settings/connection.php';

// Function to get the profile picture of a logged-in user
function getProfilePicture($userId) {
    global $conn;
    // Prepare SQL statement
    $sql = "SELECT imagepath FROM profile WHERE gamer_id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    // Execute the query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if user exists and has a profile picture
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $profilePicture = $row["imagepath"];
    } else {
        // User not found or no profile picture available
        $profilePicture = 'default.jpg'; // path to default profile picture
    }

    return $profilePicture;
}
?>

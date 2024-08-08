<?php
function get_image_fxn($conn, $user_id) {
    // Prepare SQL statement
    $sql = "SELECT imagepath FROM profile WHERE gamer_id = ? ORDER BY id DESC LIMIT 1";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("i", $user_id);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Get the result
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Fetch the image path
                $row = $result->fetch_assoc();
                return $row['imagepath'];
            } else {
                // No image found, return a default image path
                return "../images/default_profile.png";
            }
        } else {
            // Error executing the query
            return false;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // Error preparing the statement
        return false;
    }
}

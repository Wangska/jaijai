<?php
// Test database connection
include 'db_connector.php';

echo "<h2>Database Connection Test</h2>";

// Test connection
if ($conn) {
    echo "✅ Database connection successful!<br><br>";
    
    // Show current database
    $result = mysqli_query($conn, "SELECT DATABASE() as current_db");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo "<strong>Current database:</strong> " . $row['current_db'] . "<br><br>";
    }
    
    // Check if personal_data table exists
    $result = mysqli_query($conn, "SHOW TABLES LIKE 'personal_data'");
    if ($result && mysqli_num_rows($result) > 0) {
        echo "✅ Table 'personal_data' exists<br><br>";
        
        // Check table structure
        $result = mysqli_query($conn, "DESCRIBE personal_data");
        echo "<strong>Table structure:</strong><br>";
        echo "<table border='1'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "</tr>";
        }
        echo "</table><br>";
        
        // Check if there's any data
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM personal_data");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            echo "<strong>Records in table:</strong> " . $row['count'] . "<br>";
        }
    } else {
        echo "❌ Table 'personal_data' does not exist<br>";
        echo "You may need to import your accounts.sql file into the 'default' database<br>";
    }
    
    mysqli_close($conn);
} else {
    echo "❌ Database connection failed<br>";
}
?>

<?php
// Database Migration Script - Run this ONCE to fix your database schema
include 'db_connector.php';

echo "<h2>Database Migration - Fixing Column Types</h2>";

if ($conn) {
    echo "✅ Connected to database<br><br>";
    
    // Migration SQL
    $migrations = [
        "ALTER TABLE personal_data MODIFY COLUMN phone VARCHAR(20) NOT NULL",
        "ALTER TABLE personal_data MODIFY COLUMN tele VARCHAR(20) NOT NULL", 
        "ALTER TABLE personal_data MODIFY COLUMN zip VARCHAR(10) NOT NULL",
        "ALTER TABLE personal_data MODIFY COLUMN zip2 VARCHAR(10) NOT NULL",
        "ALTER TABLE personal_data MODIFY COLUMN tin VARCHAR(20) NOT NULL"
    ];
    
    $success = true;
    
    foreach ($migrations as $index => $sql) {
        echo "Running migration " . ($index + 1) . "...<br>";
        
        if (mysqli_query($conn, $sql)) {
            echo "✅ Success: " . $sql . "<br><br>";
        } else {
            echo "❌ Error: " . mysqli_error($conn) . "<br>";
            echo "SQL: " . $sql . "<br><br>";
            $success = false;
        }
    }
    
    if ($success) {
        echo "<h3>🎉 Migration completed successfully!</h3>";
        echo "Your database schema has been updated. You can now submit your form without errors.<br><br>";
        
        // Show updated table structure
        echo "<strong>Updated table structure:</strong><br>";
        $result = mysqli_query($conn, "DESCRIBE personal_data");
        if ($result) {
            echo "<table border='1'>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                $highlight = in_array($row['Field'], ['phone', 'tele', 'zip', 'zip2', 'tin']) ? ' style="background-color: #90EE90;"' : '';
                echo "<tr{$highlight}>";
                echo "<td>" . $row['Field'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "<td>" . $row['Null'] . "</td>";
                echo "<td>" . $row['Key'] . "</td>";
                echo "</tr>";
            }
            echo "</table><br>";
            echo "<em>Highlighted rows show the updated columns</em>";
        }
    } else {
        echo "<h3>❌ Migration failed</h3>";
        echo "Please check the errors above and try again.";
    }
    
    mysqli_close($conn);
} else {
    echo "❌ Database connection failed";
}

echo "<br><br><strong>⚠️ Important:</strong> Delete this file after running the migration for security reasons.";
?>

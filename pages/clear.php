<?php
// clear.php - Simple script to delete all comments
$db = new PDO("sqlite:database.sqlite");
$db->exec("DELETE FROM comments");
echo "All comments have been cleared! <a href='contact.php'>Go back to contact form</a>";
?>
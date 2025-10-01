<?php
// db.php
$db = new PDO("sqlite:database.sqlite");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create tables
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password_hash TEXT,
    email TEXT,
    bio TEXT
)");

$db->exec("CREATE TABLE IF NOT EXISTS comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    commenter_id INTEGER,
    comment_text TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$db->exec("CREATE TABLE IF NOT EXISTS flags (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    flag_text TEXT
)");

// AUTO-DELETE COMMENTS ON EVERY PAGE LOAD
$db->exec("DELETE FROM comments");

// Always reset and insert the flag
$db->exec("DELETE FROM flags");
$db->exec("INSERT INTO flags (flag_text) VALUES ('CTF{stored XSS}')");

// Insert users if they don't exist
$users = $db->query("SELECT COUNT(*) AS cnt FROM users")->fetch(PDO::FETCH_ASSOC);
if($users['cnt'] == 0) {
    $db->exec("INSERT INTO users (username, password_hash, email, bio) VALUES
        ('alice', '".md5('password123')."', 'alice@freshcart.com', 'Food lover and recipe enthusiast'),
        ('bob', '".md5('bobpass')."', 'bob@freshcart.com', 'Enjoys pizza')
    ");
}
?>
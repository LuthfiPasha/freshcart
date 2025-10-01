<?php
// Function to list files and folders
function listFiles($dir = 'assets') {
    $base_path = realpath($dir);
    
    if (!$base_path || !file_exists($base_path)) {
        return "Directory not found: $dir";
    }
    
    $items = scandir($base_path);
    $output = "<h3>File Browser: $dir/</h3>";
    $output .= "<div style='font-family: monospace; margin: 20px;'>";
    
    // Add parent directory link if not in root assets
    if ($dir != 'assets') {
        $parent_dir = dirname($dir);
        if ($parent_dir == '.') $parent_dir = 'assets';
        $output .= "📁 <a href='?path=$parent_dir/'>../</a><br>";
    }
    
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') continue;
        
        $full_path = $base_path . DIRECTORY_SEPARATOR . $item;
        $relative_path = $dir . '/' . $item;
        
        if (is_dir($full_path)) {
            $output .= "📁 <a href='?path=$relative_path/'>$item/</a><br>";
        } else {
            $output .= "📄 <a href='?file=$relative_path'>$item</a><br>";
        }
    }
    
    $output .= "</div>";
    return $output;
}

// Main code
if(isset($_GET['file']) && !empty($_GET['file'])) {
    // File download request
    $filename = $_GET['file'];
    $file_path = $filename;
    
    if(file_exists($file_path)) {
        header('Content-Type: text/plain');
        echo file_get_contents($file_path);
    } else {
        echo "Error: File not found - " . htmlspecialchars($file_path);
        echo "<br><br><a href='download.php'>&larr; Back to file browser</a>";
    }
} else if(isset($_GET['path']) && !empty($_GET['path'])) {
    // Directory browsing request
    $path = rtrim($_GET['path'], '/');
    echo "<h2>File Download Browser</h2>";
    echo listFiles($path);
    echo "<hr>";
    echo "<p><strong>Hint:</strong> Click on folders to browse, click on files to view contents.</p>";
    echo "<p><a href='download.php'>&larr; Back to root</a></p>";
} else {
    // Show the file browser interface
    echo "<h2>File Download Browser</h2>";
    echo listFiles('assets');
    echo "<hr>";
    echo "<p><strong>Hint:</strong> Click on folders to browse, click on files to view contents.</p>";
}
?>
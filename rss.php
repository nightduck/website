<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 3/3/18
 * Time: 2:23 PM
 */

try {
    # Connect to the SQL database
    $conn = new PDO("mysql:host=localhost;dbname=website","guest");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $feed = $_GET['feed'];      # General category this'll filter the pages shown

    if (!is_null($feed)) {
        #TODO: Replace this to find tags instead of templates
        # If a feed is specified, the user wants to look at a categorized list of pages. Pass this as a
        # WHERE template = ... in the SQL query. Ignore unpublished posts if on the main orenbell.com domain
        $filter = " WHERE template='" . $feed . "'" . ((file_exists("public-facing.lock")) ? " AND published" : "");
        $title_ornament = " - " . $feed;    # TODO: Fetch display name here once template metadata db is added
    } else if (file_exists("public-facing.lock")) {
        #Ignore unpublished posts if lockfile present
        $filter = " WHERE published";
        $title_ornament = "";
    } else {
        $filter = "";
        $title_ornament = "";
    }

    # Fetch basic metadata
    $stmt = $conn->query("SELECT id, title, description FROM pages " . $filter
        . " ORDER BY pub_date desc");
    $pages = $stmt->fetchall();

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

echo "<?xml version=\"1.0\" ?><rss version=\"2.0\"><channel>"
    . "<title>Oren's Personal website" . $title_ornament . "</title>"
    . "<description>RSS feed for oren's personal website</description>"
    . "<link>"
        . (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"
    . "</link>";

foreach($pages as $row) {
    echo "<item>"
        . "<title>" . $row['title'] . "</title>"
        . "<description>" . $row['description'] . "</description>"
        . "<link>" . (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"
            . "/?id=" . base64_encode(sprintf("%06d", $row['id'])) . "</link>"
        . "</item>";

}

echo "</channel></rss>";
?>

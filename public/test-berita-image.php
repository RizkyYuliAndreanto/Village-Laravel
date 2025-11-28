<!DOCTYPE html>
<html>

<head>
    <title>Test Image URL</title>
</head>

<body>
    <h1>Test Berita Image</h1>
    <?php
    // Simulate the accessor logic
    $gambar_url = 'berita/images/01KANX7P4J8HEGSD537CH69X9R.jpg';
    $image_url = asset('storage/' . $gambar_url);

    echo "<p>Gambar URL: " . htmlspecialchars($gambar_url) . "</p>";
    echo "<p>Image URL: " . htmlspecialchars($image_url) . "</p>";
    echo "<img src='" . htmlspecialchars($image_url) . "' alt='Test Image' style='max-width: 300px;'>";
    ?>
</body>

</html>
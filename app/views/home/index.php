<?php
    define ("LOCAL_URL", __DIR__);
    $url_str = substr(LOCAL_URL, 16, -5);
    $url_str = str_replace('\\', '/', $url_str);
    var_dump($url_str);

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
<h1>Welcome</h1>
<p>Hello <?php echo htmlspecialchars($name); ?>!</p>

<ul>
    <?php foreach ($colors as $color): ?>
        <li><?php echo htmlspecialchars($color); ?></li>
    <?php endforeach; ?>
</ul>

</body>
</html>

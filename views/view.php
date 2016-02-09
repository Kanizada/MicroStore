<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="../web/microstore.css" rel="stylesheet" />
    <title>MicroStore - Home</title>
</head>
<body>
<header>
    <h1>MicroStore</h1>
</header>
<?php
foreach ($article as $article): ?>   <!-- foreach = pour chaques tuples successivement   -->
    <article>
        <h2><?php echo $article['art_title'] ?></h2>
        <p><?php echo $article['art_content'] ?></p>
    </article>
<?php endforeach ?>
<footer class="footer">
    <a href="https://github.com/bpesquet/OC-MicroCMS">MicroCMS</a> is a minimalistic CMS built as a showcase for modern PHP development.
</footer>
</body>
</html>
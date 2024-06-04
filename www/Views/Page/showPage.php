<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
</head>
<body>
  
  <h1><?= htmlspecialchars($page->getTitle(), ENT_QUOTES, 'UTF-8') ?></h1>
  <p><?= htmlspecialchars($page->getContent(), ENT_QUOTES, 'UTF-8') ?></p>

</body>
</html>

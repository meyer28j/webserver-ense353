<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Homepage</title>
    <link href="/res/styles.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/res/skeleton.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/res/normalize.css" media="screen" rel="stylesheet" type="text/css" />
  </head>
  
  <body>
    <?php include 'menu.php';?>
    <h1>Home</h1>
    <p>Go to <a href="employees.php">Employees</a> page</p>
    <p>Hello World! I am a web server running off of Apache!</p>
    <h2>Movie Posters</h2>
    <p>NOTE: all images are taken from <a href="https://www.movieposters.com/">https://www.movieposters.com/</a> and are being used on this site explicitly for educational purposes.</p>
    <div class="flex-container">
      <img class="flex-item" src="res/raiders.jpg">
      <img class="flex-item" src="res/doom.jpg">
      <img class="flex-item" src="res/crusade.jpg">
      <img class="flex-item" src="res/crystal.jpg">
      <img class="flex-item" src="res/destiny.jpg">
      <img class="flex-item" src="res/patriot.jpg">
    </div>
  </body>
</html>

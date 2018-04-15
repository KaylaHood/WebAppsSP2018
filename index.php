<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Kayla Hood's Website</title>
  <link href='https://fonts.googleapis.com/css?family=Coda' rel='stylesheet'>
  <style type="text/css">
  @import url('Styles/Tasks.css');
  </style>
  <script type="text/javascript" src="Scripts/utils.js">
  </script>
  <script type="text/javascript" src="Scripts/index.js">
  </script>
</head>
<body>
  <div id="main">
  <div id="page-title">
    <p class="title">Kayla Hood, Computer Science Major</p>
    <p class="subtitle">Graduating May 2018</p>
  </div>
  <div id="nav-menu">
    <div class="button-row">
    <div id="button-home" class="button">Home</div>
    <div id="button-aboutme" class="button">About Me</div>
    <div id="button-stats" class="button">Task 3</div>
    <div id="button-canvas" class="button">Task 4</div>
    <div id="button-tasks" class="button">Task 5</div>
    <div id="button-sprites" class="button">Task 7</div>
    <div id="button-tasks2" class="button">Task 8</div>
    </div>
  </div>
  <div id="page-body">
    <div id="dynamic-content" class="body"><?php
    $GLOBALS["INDEXPHP"] = $_SERVER['REQUEST_URI'];
    $defaultcontent = "Home";
    $text = "";
    $contentdir = "Views";
    $contentext = "php";
    if($_SERVER['REQUEST_METHOD'] === 'GET')  {
      if(isset($_GET["view"])) {
        $content = $_GET["view"];
      }
      else {
        $content = "Home";
      }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if(isset($_POST["view"])) {
        $content = $_POST["view"];
      }
      else {
        echo "The view value was not set for the post request";
      }
    }
    $contentpath = "./{$contentdir}/{$content}.{$contentext}";
    require $contentpath;
    ?></div>
  </div>
  </div>
</body>
</html>

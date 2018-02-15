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
      </div>
    </div>
    <div id="page-body">
      <div id="dynamic-content" class="body"><?php
        $defaultcontent = "Home";
        $text = "";
        $contentdir = "Views";
        $contentext = "html";
        if($_SERVER['REQUEST_METHOD'] === 'GET')  {
          $content = $_GET["view"];
          
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $content = $_POST["view"];
        }
        $contentfile = fopen("./{$contentdir}/{$content}.{$contentext}","r") or die("");
        $text = fread($contentfile,filesize("./{$contentdir}/{$content}.{$contentext}"));
        fclose($contentfile);
        echo $text;
      ?></div>
    </div>
  </div>
</body>
</html>

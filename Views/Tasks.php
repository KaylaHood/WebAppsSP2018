<script type="text/javascript" src="Scripts/tasks.js"></script>
<?php
  session_start();
  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*if ($_SERVER['SERVER_NAME'] != "dias11.cs.trinity.edu") {
      echo "<p>You must access this page from on campus through dias11.</p>";
      die ();
    }*/
    if(isset($_POST["form-login"])) {
      echo "Login form has been submitted";
      login_user();
    }
    else if(isset($_POST["form-save"])) {
      echo "Save tasks form has been submitted";
      if(isset($_POST["user-data"])) {
        save_tasks($_POST["user-data"]);
      }
      else {
        echo "No data was sent with the save request";
      }
    }
    else if(isset($_POST["form-logout"])) {
      echo "Logout form has been submitted";
      logout_user();
    }
  }

  function isValidJson($strJson) { 
      if($strJson === "") {
        return FALSE;
      }
      else {
        json_decode($strJson); 
        return (json_last_error() === JSON_ERROR_NONE);
      } 
  }

  function save_tasks($data) {
    if(isValidJson($data)) {
      $data = json_decode($data,TRUE);
      $_SESSION["user-data"] = $data;
      $data_path = get_data_save_path(); 
      $s = serialize($data);
      file_put_contents($data_path, $s);
    }
  }

  function load($fn) {
    $s = file_get_contents($fn);
    $new = unserialize($s);
    return $new;
  }

  function login_failure($msg) {
    $_POST["LOGIN_FAILURE_MSG"] = $msg;
  }

  function login_user() {
    $mlewis = "password";
    $khood = "password";
    $username = test_input($_POST["username"]);
    if(isset(${$username})) {
      $password = test_input($_POST["password"]);
      if(${$username} == $password) {
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        $data_path = get_data_save_path();
        $tasks = array();
        if(file_exists($data_path)) {
          $tasks = load($data_path);
        }
        $_SESSION["user-data"] = $tasks;
      }
      else {
        login_failure("password was incorrect");
      }
    }
    else {
      login_failure("username was incorrect");
    }
  }

  function get_data_save_path() {
    if(isset($_SESSION["username"])) {
      $data_path = "/Users/Tasks/" . $_SESSION["username"] . ".txt";
      return $data_path;
    }
    else {
      echo "No user is logged in, cannot save.";
      die();
    }
  }

  function logout_user() {
    session_unset();
    session_destroy();
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
<div id="tasks">
  <?php if(!(isset($_SESSION["username"])) || !(isset($_SESSION["password"]))) : ?>
  <div id="login">
    <p><?php
      if(isset($_POST["LOGIN_FAILURE_MSG"])) {
        echo $_POST["LOGIN_FAILURE_MSG"]; 
      }
    ?></p>
    <form id="form-login" action="<?php echo $GLOBALS["INDEXPHP"]; ?>" method="post">
      <fieldset>
      <legend>Login</legend>
      Username:<br>
      <input id="username" type="text" placeholder="Username" name="username" required><br>
      Password:<br>
      <input id="password" type="password" placeholder="Password" name="password" required><br><br>
      <input id="submit-login" type="submit" value="Submit" name="form-login"> 
      <input type="hidden" value="Tasks" name="view">
      </fieldset>
    </form>
    <div id="unknown-user">
      <p> Please log in to see your tasks </p>
    </div>
  </div>
  <?php else : ?>
  <div id="div-logout">
    <form id="form-logout" action="<?php echo $GLOBALS["INDEXPHP"]; ?>" method="post">
      <input id="submit-logout" type="submit" value="Logout" name="form-logout">
      <input type="hidden" value="Tasks" name="view">
    </form>
  </div>
  <span id="welcome-user" class="left-aligned">
    <p>Hello, <?php echo $_SESSION["username"]; ?></p>
  </span>
  <span id="data-msg" class="right-aligned">
  <p>No unsaved changes.</p>
  </span>
  <div id="actions">
    <span id="action-save">
      <form id="form-save" action="<?php echo $GLOBALS["INDEXPHP"]; ?>" method="post">
        <input id="user-data" type="hidden" value="" name="user-data">
        <input id="submit-save" type="submit" value="Save Changes" name="form-save">
        <input type="hidden" value="Tasks" name="view">
      </form>
    </span>
  </div>
  <div id="table-tasks">
    <table id="tasks">
      <caption><?php echo $_SESSION["username"]; ?>'s Tasks</caption>
      <thead>
        <tr>
          <th>-</th>
          <th>Title</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody id="table-body">
      <?php if(isset($_SESSION["user-data"])) : ?>
      <?php for($i = 0, $size = count($_SESSION["user-data"]); $i < $size; $i++) : ?>
        <tr>
          <td><button id="task-delete-<?php echo $i; ?>" type="button">Delete</button></td>
          <td><input id="task-title-<?php echo $i; ?>" type="text" value="<?php echo $_SESSION["user-data"][$i]["title"]; ?>"></td>
          <td><textarea id="task-desc-<?php echo $i; ?>" name="task-desc-<?php echo $i; ?>"><?php 
            echo $_SESSION["user-data"][$i]["desc"]; 
          ?></textarea></td>
        </tr>
      <?php endfor; ?>
      <?php endif; ?>
      </tbody>
      <tfoot>
        <tr>
          <td><button id="new-task-delete" type="button" disabled>Delete</button></td>
          <td><input id="new-task-title" type="text" placeholder="my new task" disabled></td>
          <td><textarea id="new-task-desc" name="new-task-desc" placeholder="my new task's description" disabled></textarea></td>
        </tr>
      </tfoot>
    </table>
  </div>
  <?php endif; ?>
</div>

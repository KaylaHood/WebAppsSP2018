<script type="text/javascript" src="Scripts/tasks.js"></script>
<?php
  
  $LOGIN_FAILURE = 0;
  $LOGIN_FAILURE_MSG = "";


  class TaskData {
    // array of arrays:
    // $tasks = array(
    //  array("title" => "my task",
    //        "desc" => "description"),
    //  array("title" => "my 2nd task",
    //        "desc" => "description"),
    //  ...
    //  );
    //
    public $tasks = array();

    public function __construct() {
      //empty
    }

    public function set_tasks($data) {
      $this->tasks = $data;
    }

    public function save($fn) {
      $s = serialize($this);
      file_put_contents($fn, $s);
    }

    public static function load($fn) {
      $s = file_get_contents($fn);
      $new = unserialize($s);
      return $new;
    }

  }


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
        save_tasks(test_input($_POST["user-data"]));
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

  function login_failure($msg) {
    $LOGIN_FAILURE = 1;
    $LOGIN_FAILURE_MSG = $msg;
  }

  function login_user() {
    $mlewis = "password";
    $khood = "password";
    $username = test_input($_POST["username"]);
    if(isset(${$username})) {
      $password = test_input($_POST["password"]);
      if(${$username} == $password) {
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        $data_path = get_data_save_path();
        if(file_exists($data_path)) {
          $_SESSION["user-data"] = TaskData::load($data_path);
        }
        else {
          $empty_array = array();
          $newData = new TaskData();
          $newData->set_tasks($empty_array);
          $_SESSION["user-data"] = $newData;
        }
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

  function save_tasks($data) {
    $data = json_decode($data,TRUE);
    $data_obj = new TaskData();
    $data_obj->set_tasks($data); 
    $_SESSION["user-data"] = $data_obj;
    $data_path = get_data_save_path(); 
    $data_obj->save($data_path); 
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
      if($LOGIN_FAILURE === 1) {
        echo $LOGIN_FAILURE_MSG; 
      }
    ?></p>
    <form id="form-login" action="/index.php" method="post">
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
    <form id="form-logout" action="/index.php" method="post">
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
      <form id="form-save" action="/index.php" method="post">
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
          <td><input id="task-title-<?php echo $i; ?>" type="text" value="<?php echo (($_SESSION["user-data"])->$tasks[$i])["title"]; ?>"></td>
          <td><textarea id="task-desc-<?php echo $i; ?>" name="task-desc-<?php echo $i; ?>"><?php 
            echo (($_SESSION["user-data"])->$tasks[$i])["desc"]; 
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

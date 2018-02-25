<script type="text/javascript" src="Scripts/tasks.js"></script>
<?php
  $login = $savetasks = $deletetasks = 0;

  $USERS = array(
    "mlewis" => "password",
    "khood" => "password"
  ); 

  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SERVER['SERVER_NAME'] != "dias11.cs.trinity.edu") {
      echo "<p>You must access this page from on campus through dias11.</p>";
      die ();
    }
    if(isset($_POST["form-login"])) {
      echo "Login form has been submitted";
      $login = 1;
      login_user();
    }
    else if(isset($_POST["form-save"])) {
      echo "Save tasks form has been submitted";
      $savetasks = 1;
      save_tasks();
    }
    else if(isset($_POST["form-delete"])) {
      echo "Delete tasks form has been submitted";
      $deletetasks = 1;
      delete_selected_tasks();
    }
  }

  function login_user() {
    $tmp_username = test_input($_POST["username"]);
    if(isset($USERS["${tmp_username}"])) {
      echo "Found user ${tmp_username}";
      $username = $tmp_username;
      $tmp_password = test_input($_POST["password"]);
      if($USERS["${username}"] === "${tmp_password}") {
        echo "User's credentials were accepted!";
        $password = $tmp_password;
      }
    }
  }

  function save_tasks() {

  }

  function delete_selected_tasks() {

  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
<div id="tasks">
  <?php if() : ?>
  <div id="login">
    <form id="form-login" action="/Views/Tasks.php" method="post">
      <fieldset>
      <legend>Login</legend>
      Username:<br>
      <input id="username" type="text" placeholder="Username" name="username" required><br>
      Password:<br>
      <input id="password" type="password" placeholder="Password" name="password" required><br><br>
      <input id="submit-login" type="submit" value="Submit" name="form-login"> 
      </fieldset>
    </form>
  </div>
  <?php else : ?>
  <div id="welcome-user">
    <p>Hello, <?php echo $username; ?>!</p>
  </div>
  <?php endif; ?>
  <?php if() : ?>
  <div id="actions">
    <span id="action-save">
      <form id="form-save" action="/Views/Tasks.php" method="post">
        <input id="submit-save" type="submit" value="Save Changes" name="form-save">
      </form>
    </span>
    <span id="action-delete">
      <form id="form-delete" action="/Views/Tasks.php" method="post">
        <input id="submit-delete" type="submit" value="Delete Selected Tasks" name="form-delete">
      </form>
    </span>
  </div>
  <div id="table-tasks">
    <table id="tasks">
      <caption><?php echo $username; ?>'s Tasks</caption>
      <thead>
        <tr>
          <th><button type="button">&#9745;</button></th>
          <th>Title</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
      <tfoot>
        <tr>
          <td><input id="new-task-select" type="checkbox" disabled></td>
          <td><input id="new-task-title" type="text" placeholder="my new task" disabled></td>
          <td><textarea id="new-task-desc" name="new-task-desc" placeholder="my new task's description" disabled></textarea></td>
        </tr>
      </tfoot>
    </table>
  </div>
  <?php else : ?>
  <div id="unknown-user">
    <p> Please log in to see your tasks </p>
  </div>
  <?php endif; ?>
</div>

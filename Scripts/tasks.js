
var TaskData = [];

function saveTaskData() {
  var saveForm = document.getElementById("form-save");
  var userData = saveForm.elements.namedItem("user-data");
  userData.value = JSON.stringify(TaskData);
  return true;
}

function loadTaskData() {
  var table = document.getElementById("table-body");
  var numRows = table.rows.length;
  for(var i = 0;i < numRows; i++) {
    var row = table.rows[i].cells;
    var title = row[1].firstChild.value;
    var desc = row[2].firstChild.value;
    TaskData.push({
      "title": title,
      "desc": desc
    });
  }
}

function tasks_main() {
  document.addEventListener("DOMContentLoaded", function(event) {
    console.log("Tasks are being initiated!");
    initTasks();
  });
}

function initTasks() {
  loadTaskData();
  setupTaskSubmit();
  setupTaskButtons();
}

function setupTaskSubmit() {
  var saveForm = document.getElementById("form-save");
  saveForm.onsubmit = function(){ saveTaskData(); };
}

function setupTaskButtons() {
  var table = document.getElementById("table-body");
  var numRows = table.rows.length;
  for(var i = 0;i < numRows; i++) {
    var row = table.rows[i].cells;
    var deleteButton = row[0].firstChild;
    deleteButton.onclick = function(){
      TaskData.splice(i,1);
      table.removeChild(table.rows[i]);
    };
  }
  var newTaskTitle = document.getElementById("new-task-title");
  newTaskTitle.onclick = function(){
    setFooterDisabled(false);  
  };
  newTaskTitle.onfocusout = function(){
    if(!(this.value === "")) {
      var newTitle = this.value;
      var newDesc = document.getElementById("new-task-desc").value;
      var newTask = {
        "title": newTitle,
        "desc": newDesc
      };
      addTaskToTable(newTask);
    }
    setFooterDisabled(true);
  };
}

function addTaskToTable(newTask) {
  TaskData.push(newTask);
  var table = document.getElementById("table-body");
  var newTaskIdx = table.rows.length + 1;
  var newRow = table.insertRow(table.rows.length);
  var delCell = newRow.insertCell(0);
  var delButton = document.createElement("button");
  delButton.setAttribute("id","task-delete-" + newTaskIdx.toString());
  delButton.setAttribute("type","button");
  delButton.innerHTML = "Delete";
  delCell.appendChild(delButton);
  var titleCell = newRow.insertCell(1);
  var titleInput = document.createElement("input");
  titleInput.setAttribute("id","task-title-" + newTaskIdx.toString());
  titleInput.setAttribute("type","text");
  titleInput.setAttribute("value",newTask["title"]);
  titleCell.appendChild(titleInput);
  var descCell = newRow.insertCell(2);
  var descText = document.createElement("textarea");
  descText.setAttribute("id","task-desc-" + newTaskIdx.toString());
  descText.setAttribute("name","task-desc-" + newTaskIdx.toString());
  descText.value = newTask["desc"];
  descCell.appendChild(descText);
}

function setFooterDisabled(boolvalue) {
  var newTaskTitle = document.getElementById("new-task-title");
  var newTaskDesc = document.getElementById("new-task-desc");
  var newTaskDelete = document.getElementById("new-task-delete");
  newTaskTitle.disabled = boolvalue;
  newTaskDesc.disabled = boolvalue;
  newTaskDelete.disabled = boolvalue;
}

tasks_main();

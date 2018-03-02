
var TaskData = {};
var highestKey = 0;

function saveTaskData() {
  console.log("saveTaskData");
  var saveForm = document.getElementById("form-save");
  var userData = saveForm.elements.namedItem("user-data");
  userData.value = JSON.stringify(TaskData);
  return true;
}

function loadTaskData() {
  console.log("loadTaskData");
  var table = document.getElementById("table-body");
  var numRows = table.rows.length;
  for(var i = 0;i < numRows; i++) {
    var row = table.rows[i];
    var key = row.getAttribute("id");
    var cells = row.cells;
    var title = cells[1].firstChild.value;
    var desc = cells[2].firstChild.value;
    TaskData[key] = {
      "title": title,
      "desc": desc
    };
    if(parseInt(key) > highestKey) {
      highestKey = key;
    }
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
  console.log("setupTaskSubmit");
  var saveForm = document.getElementById("form-save");
  saveForm.onsubmit = function(){ saveTaskData(); };
}

function getNextKey() {
  var nextKey = parseInt(highestKey) + 1;
  highestKey = nextKey.toString();
  return nextKey;
}

function setupTaskButtons() {
  console.log("setupTaskButtons");
  var table = document.getElementById("table-body");
  var numRows = table.rows.length;
  for(var i = 0;i < numRows; i++) {
    var cells = table.rows[i].cells;
    var deleteButton = cells[0].firstChild;
    deleteButton.onclick = function(){
      buttonDeleteTask(this);
    };
    titleInput = cells[1].firstChild;
    titleInput.addEventListener("focusout", function() {
      titleUpdate(this);
    });
    descInput = cells[2].firstChild;
    descInput.addEventListener("focusout", function() {
      descUpdate(this);
    });
  }
  var newTaskTitle = document.getElementById("td-new-task-title");
  newTaskTitle.onclick = function(){
    setFooterDisabled(false);  
  };
  var newTaskTitleInput = document.getElementById("new-task-title");
  newTaskTitleInput.addEventListener("focusout", function(){
    if(!(this.value === "")) {
      var newTitle = this.value;
      var newDesc = document.getElementById("new-task-desc").value;
      console.log("description: "+newDesc);
      var newTask = {
        "title": newTitle,
        "desc": newDesc
      };
      addTaskToTable(newTask, getNextKey());
    }
    setFooterDisabled(true);
  });
}

function buttonDeleteTask(button) {
  var table = document.getElementById("table-body");
  var tableRow = button.parentNode.parentNode;
  var key = tableRow.getAttribute("id");
  if(parseInt(highestKey) == parseInt(key)) {
    highestKey = (parseInt(highestKey) - 1).toString();
  }
  delete TaskData[key];
  table.removeChild(tableRow);
}

function addTaskToTable(newTask, newKey) {
  console.log("addTaskToTable");
  TaskData[newKey] = newTask;
  var table = document.getElementById("table-body");
  var newRow = table.insertRow(table.rows.length);
  newRow.setAttribute("id",newKey);
  var delCell = newRow.insertCell(0);
  var delButton = document.createElement("button");
  delButton.setAttribute("id","task-delete-" + newKey);
  delButton.setAttribute("type","button");
  delButton.innerHTML = "Delete";
  delButton.onclick = function(){
    buttonDeleteTask(this);
  };
  delCell.appendChild(delButton);
  var titleCell = newRow.insertCell(1);
  var titleInput = document.createElement("input");
  titleInput.setAttribute("id","task-title-" + newKey);
  titleInput.setAttribute("type","text");
  titleInput.setAttribute("value",newTask["title"]);
  titleInput.addEventListener("focusout", function() {
    titleUpdate(this);
  });
  titleCell.appendChild(titleInput);
  var descCell = newRow.insertCell(2);
  var descText = document.createElement("textarea");
  descText.setAttribute("id","task-desc-" + newKey);
  descText.setAttribute("name","task-desc-" + newKey);
  descText.value = newTask["desc"];
  descText.addEventListener("focusout", function() {
    descUpdate(this);
  });
  descCell.appendChild(descText);
}

function titleUpdate(elem) {
  var key = elem.parentNode.parentNode.getAttribute("id");
  var newTitle = elem.value;
  TaskData[key]["title"] = newTitle;
}

function descUpdate(elem) {
  var key = elem.parentNode.parentNode.getAttribute("id");
  var newDesc = elem.value;
  TaskData[key]["desc"] = newDesc;
}

function setFooterDisabled(boolvalue) {
  console.log("setFooterDisabled");
  var newTaskTitle = document.getElementById("new-task-title");
  var newTaskDesc = document.getElementById("new-task-desc");
  var newTaskDelete = document.getElementById("new-task-delete");
  newTaskTitle.disabled = boolvalue;
  newTaskDesc.disabled = boolvalue;
  newTaskDelete.disabled = boolvalue;
}

tasks_main();

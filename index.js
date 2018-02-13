console.log("We got here!");

function NavButtonActions(button, call_after_click) {
  this.click = function(button) {
      getData(button.src, 'dynamic-content');
      if(call_after_click) {
        call_after_click();
      }
  };
  this.onmouseover = function(elem){
      elem.style.background = 'linear-gradient(dimgrey,black,dimgrey)';
  };
  this.onmouseout = function(elem){
      this.onmouseup(elem);
      elem.style.background = 'black';
  };
  this.onmousedown = function(elem){
      elem.style.textShadow = '0 0 0.3rem #87CEEB';
  };
  this.onmouseup = function(elem){
      elem.style.textShadow = 'none';
  };
  this.init = function(button) {
    var buttonDOM = document.getElementById(button.id);
    buttonDOM.addEventListener("click", function() {
      button.actions.click(button);
    });
    buttonDOM.onmouseover = function() { button.actions.onmouseover(buttonDOM);};
    buttonDOM.onmouseout = function() { button.actions.onmouseout(buttonDOM);};
    buttonDOM.onmousedown = function() { button.actions.onmousedown(buttonDOM);};
    buttonDOM.onmouseup = function() { button.actions.onmouseup(buttonDOM);};
  }
}

const buttons = [
  buttonHome = {
    id:'button-home',
    src:'index.txt',
    actions: new NavButtonActions(this)
  },
  buttonAboutMe = {
    id:'button-aboutme',
    src:'aboutme.txt',
    actions: new NavButtonActions(this)
  },
  buttonStats = {
    id:'button-stats',
    src:'stats.txt',
    actions: new NavButtonActions(this, function() {
      window.setTimeout(function() {
        let str = document.getElementById('dynamic-content').innerHTML.toString();
        buildTable(str);
      }, 500);
    })
  }
];

function initButtons() {
  buttons.forEach(function(element) {
    element.actions.init(element);
  });
}

const tableHeader = ["Player","Team","Position","Games Played","Minutes Played","Field Goals Made","Field Goals Attempted","Threes Made","Threes Attempted","Free Throws Made","Free Throws Attempted","Offensive Rebounds","Total Rebounds","Assists","Steals","Turnovers","Blocks","Personal Fouls","Disqualifications","Total Points","Technicals","EJ","FF","Games Started","+/-"];

function buildTable(tableData) {
    var lines = tableData.toString().split('\n');
    lines.shift();
    var container = document.getElementById('dynamic-content');
    var tbl = document.createElement('table');
    tbl.style.width = '100%';
    tbl.setAttribute('border','1');
    var tbdy = document.createElement('tbody');
    var tr = document.createElement('tr');
    var td = null;
    for(var m = 0; m < tableHeader.length; m++) {
        td = document.createElement('td');
        td.appendChild(document.createTextNode(tableHeader[m]));
        tr.appendChild(td);
    }
    tbdy.appendChild(tr);
    var words = null;
    for(var i = 0; i < lines.length; i++) {
        tr = document.createElement('tr');
        words = (lines[i]).split(/(\s+)/);
        words = words.filter(word => word.trim() != "");
        for(var j = 0; j < words.length; j++) {
            td = document.createElement('td');
            td.appendChild(document.createTextNode(words[j]));
            tr.appendChild(td);
        }
        tbdy.appendChild(tr);
    }
    tbl.appendChild(tbdy);
    container.innerHTML = "";
    container.appendChild(tbl);
}

document.addEventListener("DOMContentLoaded", function(event) {
    buttons[0].actions.click(buttons[0]);
    initButtons();
});

var XMLHttpRequestObject = false;

if (window.XMLHttpRequest) {
    XMLHttpRequestObject = new XMLHttpRequest();
} else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}

function getData(dataSource, divID) {
    if(XMLHttpRequestObject) {
        var obj = document.getElementById(divID);
        XMLHttpRequestObject.open("GET", dataSource);
        XMLHttpRequestObject.onreadystatechange = function() {
            if (XMLHttpRequestObject.readyState == 4 &&
            XMLHttpRequestObject.status == 200) {
                obj.innerHTML = XMLHttpRequestObject.responseText;
            }
        }
        XMLHttpRequestObject.send(null);
    }
}

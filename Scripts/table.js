const tableHeader = ["Player","Team","Position","Games Played","Minutes Played","Field Goals Made","Field Goals Attempted","Threes Made","Threes Attempted","Free Throws Made","Free Throws Attempted","Offensive Rebounds","Total Rebounds","Assists","Steals","Turnovers","Blocks","Personal Fouls","Disqualifications","Total Points","Technicals","EJ","FF","Games Started","+/-"];

function buildTable(tableElem) {
  var tableData = tableElem.innerHTML;
  var lines = tableData.toString().split('\n');
  lines.shift();
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
  tableElem.innerHTML = "";
  tableElem.appendChild(tbl);
}

function main() {
  document.addEventListener("DOMContentLoaded", function(event) {
    var body = document.getElementById('table');
    buildTable(body);
  });
}

main();

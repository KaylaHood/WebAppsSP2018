function NavButtonActions(button) {
  this.click = function(button) {
      var path = window.location.pathname;
      post(path,{view: button.src});
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
    src:'Home',
    actions: new NavButtonActions(this)
  },
  buttonAboutMe = {
    id:'button-aboutme',
    src:'AboutMe',
    actions: new NavButtonActions(this)
  },
  buttonStats = {
    id:'button-stats',
    src:'Stats',
    actions: new NavButtonActions(this)
  },
  buttonCanvas = {
    id:'button-canvas',
    src:'Canvas',
    actions: new NavButtonActions(this)  
  },
  buttonTasks = {
    id:'button-tasks',
    src:'Tasks',
    actions: new NavButtonActions(this)
  }
];

function initButtons() {
  buttons.forEach(function(element) {
    element.actions.init(element);
  });
}


function main () {
    document.addEventListener("DOMContentLoaded", function(event) {
        initButtons();
    });
}

main();

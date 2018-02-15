var canvasElem = null;
var ctx = null;

var ripples = [];

function Ripple(x,y) {
  this.radius = 0;
  this.lineWidth = 2;
  this.pos = {
    x: x,
    y: y
  };
  var grd = ctx.createRadialGradient(x,y,5,x,y,100);
  grd.addColorStop(0,'#0000FF');
  grd.addColorStop(0.5,'#0001C0');
  grd.addColorStop(1,'#FFFFFF');
  this.gradient = grd;
  this.draw = function() {
    // draw ripple
    var gradient = 
    ctx.beginPath();
    ctx.arc(this.pos.x,this.pos.y,this.radius,0,2*Math.PI);
    ctx.strokeStyle = this.gradient;
    ctx.lineWidth = this.lineWidth;
    ctx.stroke();
    this.radius = this.radius + 1;
    this.lineWidth = this.lineWidth + 0.1;
  };
}

function resizeCanvas() {
  canvasElem.width = canvasElem.parentElement.clientWidth;
  canvasElem.height = canvasElem.parentElement.clientHeight;
  draw();
}

function draw() {
  ctx.fillStyle = "white";
  ctx.fillRect(0,0,canvasElem.width,canvasElem.height);
  ripples.forEach(function(element) {
    element.draw();
  });
  for(var i = 0; i < ripples.length; i++) {
    ripples[i].draw();
    if(ripples[i].radius > 150) {
      ripples[i] = null;
      ripples.splice(i,1);
    }
  }
}

function addRipple(x,y,recur) {
  var r = new Ripple(x,y);
  ripples.push(r);
  if(recur) {
    setTimeout(function() { addRipple(x,y,false); },500);
    setTimeout(function() { addRipple(x,y,false); },1000);
  }
}

function main() {
  document.addEventListener("DOMContentLoaded", function(event) {
    canvasElem = document.getElementById('interactive-canvas');
    ctx = canvasElem.getContext('2d');
    window.addEventListener('resize',resizeCanvas(), false);
    resizeCanvas();
    canvasElem.addEventListener('click', function(event) {
      var vpOffset = canvasElem.getBoundingClientRect();
      var x = (event.pageX - (vpOffset.left + window.scrollX));
      var y = (event.pageY - (vpOffset.top + window.scrollY));
      addRipple(x,y,true);
    }, false);
    setInterval(function() { draw(); },80);
  });
}

main()

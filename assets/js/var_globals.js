//canvas
let canvas = document.getElementById('scene');
let ctx = canvas.getContext('2d');
let canvasWidth;
let canvasHeight;
//engine
let boutonSelection = document.getElementById('drawBrush');
let saveMousePoints = [[],[]];
let saveMousePointsIndice = -1;
let dessinEnCours = 0;
let test = 0;
//options
let stroke = true;
let fill = false;
let red = 0;
let green = 0;
let blue = 0;
let redStroke = 0;
let greenStroke = 0;
let blueStroke = 0;
let lineOptionWidth = 3;
let strokeOpacity = 1;
let fillOpacity = 1;
//shapes
let mouseX;
let mouseY;
let originX;
let originY;
let tempoDessin = 0;
let circleByCenter = false;
let circleCenterX;
let circleCenterY;
let circleRadius;
let circleAngle = 2;
//undo/redo
let undoRedo = [];
let undoRedoCode = [];
let undoIndex = -1;
let canvasSaveDuringCreationShape;
let canvasSaveBetweenTwoShapes;
let canvas = document.getElementById('scene');
let ctx = canvas.getContext('2d');
//BUTTONS!
//outil selectionné par défaut.
let toolSelected = "drawBrush";
//distribution de l'evenement "click" sur les boutons "outils".
let toolButtons = document.querySelectorAll('.brushs button')
for (let i = 0, toolButtonsLength = toolButtons.length; i < toolButtonsLength; i++)
{
  toolButtons[i].addEventListener('click', function()
  {
  		selectTool(toolButtons[i]);
  });
}
//activation/desactivation de l'outil.
function selectTool(button)
{
	if (button.classList.contains('button_unselect') && !button.classList.contains('button_Select'))
	{
		button.classList.toggle('button_Select');
		toolSelected = button.id;
		for (let i = 0, toolButtonsLength = toolButtons.length; i < toolButtons.length; i++)
		{
			if (toolButtons[i] != button && toolButtons[i].classList.contains('button_Select'))
			{
				toolButtons[i].classList.toggle('button_Select');
			}
		}
	}
}

//option contour ou rempli par défaut.
let stroke = true;
let fill = false;
//distribution de l'evenement "click" sur les boutons "stroke" et "fill".
let strokeAndFill = document.querySelectorAll('.sousOptionsContainer button')
for (let i = 0, strokeAndFillLength = strokeAndFill.length; i < strokeAndFillLength; i++)
{
	strokeAndFill[i].addEventListener('click', function()
	{
	  	selectStrokeFill(strokeAndFill[i]);
	});
}

function selectStrokeFill(button)
{
	let strokeButton = strokeAndFill[0];
	let fillButton = strokeAndFill[1];
	if (button.id === "fillOption" && strokeButton.classList.contains('button_Select') || button.id === "strokeOption" && fillButton.classList.contains('button_Select'))
	{
		button.classList.toggle('button_Select');
	}
	stroke = strokeButton.classList.contains('button_Select') ? true : false;
	fill = fillButton.classList.contains('button_Select') ? true : false;
}

//MOUSE COORDINATES!
let mouseX;
let mouseY;
document.addEventListener('mousemove', saveMouseXY);

function getX(event)
{
    if(event.offsetX)
    {
        return event.offsetX;
    }
    if(event.clientX) /*firefix*/
    {
        return event.clientX - canvas.offsetLeft;
    }
    return null;
 }
function getY(event)
{
    if(event.offsetY)
    {
        return event.offsetY;
    }
    if(event.clientY) /*firefix*/
    {
        return event.clientY- canvas.offsetTop;
    }
    return null;    
}

function saveMouseXY(event)
{
    mouseX = getX(event);
    mouseY = getY(event);
}
//BEGIN/STOP DRAW!
let canvasContainer = document.getElementById('canvasRelative');
let mouseDown = false;
canvasContainer.addEventListener('mousedown', function()
{
	mouseDown = true;
	launchDraw()
});
document.addEventListener('mouseup', function()
{
	mouseDown = false;
});
//DRAW!
//détecter l'outil sélectionné.
let drawTemp;

function launchDraw()
{
	undo = ctx.getImageData(0, 0, canvas.width, canvas.height); 
	if (toolSelected === "drawRectangle")
	{
		drawRectangle();
	}
	else if (toolSelected === "drawCircle")
	{
		drawCircle();
	}
	else if (toolSelected === "drawLineForm")
	{
		drawLineForm()
	}
	console.log(drawTemp);
}

//SHAPES!
let undo = ctx.getImageData(0, 0, canvas.width, canvas.height); 

function colorShape()
{
    if (stroke === true)
    {
        ctx.lineWidth = lineOptionWidth;
        ctx.strokeStyle = 'rgba( '+redStroke+', '+greenStroke+', '+blueStroke+', '+strokeOpacity+')';
        ctx.stroke();
    }

    if (fill === true)
    {
        ctx.fillStyle = 'rgba( '+red+', '+green+', '+blue+', '+fillOpacity+')';
        ctx.fill();
    }
}

function drawLineForm()
{
	if (drawTemp === undefined)
	{
	    originX = mouseX;
	    originY = mouseY;
	    let saveMousePoints = [[],[]];
		let saveMousePointsIndice = 0;
	    saveMousePoints[0].push(originX);
	    saveMousePoints[1].push(originY);
       	undo = ctx.getImageData(0, 0, canvas.width, canvas.height);
       	//dummy variables.
        let circleCenterX = originX + ((mouseX - originX)/2);
        let circleCenterY = originY + ((mouseY - originY)/2);

		drawTemp = setInterval(function()
	    {
            ctx.beginPath();
            ctx.moveTo(saveMousePoints[0][saveMousePointsIndice], saveMousePoints[1][saveMousePointsIndice]);
            ctx.putImageData(undo, 0, 0);
            ctx.lineTo(mouseX, mouseY);
            ctx.closePath();
            ctx.lineWidth = lineOptionWidth;
            ctx.strokeStyle = 'rgba( '+redStroke+', '+greenStroke+', '+blueStroke+', '+strokeOpacity+')';
            ctx.stroke();
           	//dummy origin circle.
		    ctx.beginPath();
		    ctx.arc(circleCenterX, circleCenterY, 10, 0, 2*Math.PI);
		    ctx.strokeStyle = 'rgb(0, 150, 255)';
	        ctx.stroke();
	        ctx.fillStyle = 'rgb(100, 150, 0)';
	        ctx.fill();
		}, 10);
		canvas.onmousedown = function()
		{
			console.log('mousex:'+mouseX);
			console.log('originx:'+originX);
			if (mouseX <= originX + 5 && mouseX >= originX - 5 && mouseY <= originY + 5 && mouseY >= originY - 5)
			{	
				console.log('OKOKOKOKOKOKOKOK');
				clearInterval(drawTemp);
				canvas.onmousedown = null;
				return;
			}
			saveMousePointsIndice++;
			saveMousePoints[0].push(mouseX);
	    	saveMousePoints[1].push(mouseY);
		};
	}
}

function drawRectangle()
{
    let originX = mouseX;
    let originY = mouseY;
    drawTemp = setInterval(function()
    {
    	if (mouseDown === true)
    	{
	        ctx.clearRect(0, 0, canvas.width, canvas.height);
	        ctx.putImageData(undo, 0, 0);
	        ctx.beginPath();
	        ctx.rect(originX, originY, mouseX - originX, mouseY - originY);
			colorShape()
	    }
		else
	    {
	    	clearInterval(drawTemp);
	        ctx.clearRect(0, 0, canvas.width, canvas.height);
	        ctx.putImageData(undo, 0, 0);
	        ctx.beginPath();
	        ctx.rect(originX, originY, mouseX - originX, mouseY - originY);
			colorShape()
	        //addUndo();
	    }
	}, 10);
}

function drawCircle()
{
    let originX = mouseX;
    let originY = mouseY;
    let circleRadius;
    let circleAngle = 2;
    let negativeX = 1;
    let circleByCenter = false;//en prévision d'un raccourci clavier pour dessiner un cercle par le centre.
	let circleCenterX;
	let circleCenterY;

    drawTemp = setInterval(function()
    {
    	if (mouseDown === true)
    	{
	        circleRadius = Math.sqrt(Math.pow((mouseX - originX), 2) + Math.pow(mouseY - originY, 2))/2;
	        circleRadius = parseInt(circleRadius);

	        if (circleByCenter === false)
	        {
	            circleCenterX = originX + ((mouseX - originX)/2);
	            circleCenterY = originY + ((mouseY - originY)/2);
	        }

	        ctx.clearRect(0, 0, canvas.width, canvas.height);
	       	ctx.putImageData(undo, 0, 0);
	        ctx.beginPath();
	        ctx.arc(circleCenterX, circleCenterY, circleRadius, 0, circleAngle*Math.PI);
			colorShape()
	    }
	    else
	    {
	    	clearInterval(drawTemp);
      		ctx.clearRect(0, 0, canvas.width, canvas.height);
      		ctx.putImageData(undo, 0, 0);
	        ctx.beginPath();
	        ctx.arc(circleCenterX, circleCenterY, circleRadius, 0, circleAngle*Math.PI);
			colorShape()
	        //addUndo();
		}
    }, 10);
}
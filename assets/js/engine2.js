let canvas = document.getElementById('scene');
let ctx = canvas.getContext('2d');
//MANAGE TOOLS BUTTONS!
//outil selectionné par défaut.
let toolSelected = "drawBrush";
//distribution de l'evenement "click" sur les boutons "outils".
let toolButtons = document.querySelectorAll('.brushs button')
for (let i = 0, toolButtonsLength = toolButtons.length; i < toolButtons.length; i++)
{
  toolButtons[i].addEventListener('click', function()
  {
  		selectTool(toolButtons[i]);
  });
}
//activation/desactivation de l'outil.
function selectTool(toolButton)
{
	if (toolButton.classList.contains('button_unselect') && !toolButton.classList.contains('button_Select'))
	{
		toolButton.classList.toggle('button_Select');
		toolSelected = toolButton.id;
		for (let i = 0, toolButtonsLength = toolButtons.length; i < toolButtons.length; i++)
		{
			if (toolButtons[i] != toolButton && toolButtons[i].classList.contains('button_Select'))
			{
				toolButtons[i].classList.toggle('button_Select');
			}
		}
	}
}

//MOUSE COORDINATES!
let mouseX;
let mouseY;
let mouseDown = false;
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
//BEGIN/STOP DRAWN!
let canvasContainer = document.getElementById('canvasRelative');
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
	if (toolSelected === "drawCircle")
	{
		drawCircle();
	}
}

//temp
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

let undo = ctx.getImageData(0, 0, canvas.width, canvas.height); 


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
		else
	    {
	    	clearInterval(drawTemp);
	        ctx.clearRect(0, 0, canvas.width, canvas.height);
	        ctx.putImageData(undo, 0, 0);
	        ctx.beginPath();
	        ctx.rect(originX, originY, mouseX - originX, mouseY - originY);

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

	        /*document.getElementById('code').removeChild(document.getElementById('lastChild'));
	        document.getElementById('code').innerHTML += 'ctx.beginPath();<br>ctx.rect( '+originX+', '+originY+', '+rectDestX+', '+rectDestY+');<br>'
	        if (stroke === true)
	        {
	            document.getElementById('code').innerHTML += 'ctx.lineWidth = '+lineOptionWidth+';<br>ctx.strokeStyle = "rgba( '+redStroke+', '+greenStroke+', '+blueStroke+', '+strokeOpacity+')";<br>ctx.stroke();<br>';
	        }
	        if (fill === true)
	        {
	            document.getElementById('code').innerHTML += 'ctx.fillStyle = "rgba( '+red+', '+green+', '+blue+', '+fillOpacity+')";<br>ctx.fill();<br>';
	        }
	        document.getElementById('code').innerHTML += '<span id="lastChild">&lt;/script&gt;</span>';
	        undo = ctx.getImageData(0, 0, canvas.width, canvas.height);
	        addUndo();*/
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
    let circleByCenter = false;//en prévision de la possibilité de dessiner un cercle par le centre.

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
	    else
	    {
	    	clearInterval(drawTemp);
      		ctx.clearRect(0, 0, canvas.width, canvas.height);
      		ctx.putImageData(undo, 0, 0);
	        ctx.beginPath();
	        ctx.arc(circleCenterX, circleCenterY, circleRadius, 0, circleAngle*Math.PI);

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
	       	undo = ctx.getImageData(0, 0, canvas.width, canvas.height); 

	        /*document.getElementById('code').removeChild(document.getElementById('lastChild'));
	        document.getElementById('code').innerHTML += 'ctx.beginPath();<br>ctx.arc( '+circleCenterX+', '+circleCenterY+', '+circleRadius+', 0, '+2*Math.PI+');<br>'

	        if (stroke === true)
	        {
	            document.getElementById('code').innerHTML += 'ctx.lineWidth = '+lineOptionWidth+';<br>ctx.strokeStyle = "rgba( '+redStroke+', '+greenStroke+', '+blueStroke+', '+strokeOpacity+')";<br>ctx.stroke();<br>';
	        }

	        if (fill === true)
	        {
	            document.getElementById('code').innerHTML += 'ctx.fillStyle = "rgba( '+red+', '+green+', '+blue+', '+fillOpacity+')";<br>ctx.fill();<br>';
	        }
		        document.getElementById('code').innerHTML += '<span id="lastChild">&lt;/script&gt;</span>';
		        //canvasSaveBetweenTwoShapes = ctx.getImageData(0, 0, canvas.width, canvas.height);
		        //addUndo();*/
		}
    }, 10);
}
document.addEventListener("keydown", keyDownHandler, false);
document.addEventListener("keyup", keyUpHandler, false);

function keyDownHandler(e)
{
    if(e.keyCode == 90)
    {
        activerUndo();
    }
    else if (e.keyCode == 89)
    {
        activerRedo();
    }
}
function keyUpHandler(e)
{
}

function gestionEvent()
{
	if (boutonSelection == document.getElementById('drawBrush'))
	{
        canvas.removeEventListener('click', detecterOutil, false);
		canvas.addEventListener('mousedown', detecterOutil, false);
		document.addEventListener('mouseup', stopBrush, false);
	}
	else
	{
		canvas.addEventListener('click', detecterOutil, false);
		canvas.removeEventListener('mousedown', detecterOutil, false);
		document.removeEventListener('mouseup', stopBrush, false);
	}
}

function activerBouton(ceBouton)
{
    desactiverBouton();
    ceBouton.className = "button_Select";
    boutonSelection = ceBouton;
    gestionEvent();
}

function desactiverBouton()
{
    if (boutonSelection != 'aucun')
    {
        saveMousePoints = [[],[]];
        ctx.putImageData(canvasSaveBetweenTwoShapes, 0, 0);
        canvasSaveDuringCreationShape = ctx.getImageData(0, 0, canvas.width, canvas.height);
        dessinEnCours = 0;
        saveMousePointsIndice = -1;
        boutonSelection.className = "button_unselect";
        clearInterval(tempoDessin);
        ctx.putImageData(canvasSaveDuringCreationShape, 0, 0);
    }
}

canvas.addEventListener('mousemove', saveMouseXY);
document.addEventListener('mousemove', saveMouseAbsoluteXY);

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

let mouseAbsoluteX;
let mouseAbsoluteY;
function saveMouseAbsoluteXY(event)
{
    mouseAbsoluteX = event.clientX;
    mouseAbsoluteY = event.clientY;
}
function saveMouseXY(event)
{
    mouseX = getX(event);
    mouseY = getY(event);
}

function detecterOutil()
{
	let boutonDrawBrush = document.getElementById('drawBrush');
    let boutonDrawLine = document.getElementById('drawLine');
    let boutonDrawLineForm = document.getElementById('drawLineForm');
    let boutonDrawRect = document.getElementById('drawRectangle');
    let boutonDrawCircle = document.getElementById('drawCircle');
    changeLineWidth();

    if (stroke == false && fill == false)
    {
        stroke = true;
        document.getElementById('strokeOption').className = "button_Select";
    }
    if (boutonSelection == boutonDrawBrush)
    {
    	if (dessinEnCours == 0)
    	{
    	   	originX = mouseX;
       		originY = mouseY;
		}
        if (dessinEnCours == 1)
        {
            dessinEnCours = 2;
        }
        busy = true;
        drawBrush();
    }
    if (boutonSelection == boutonDrawLine)
    {
        if (dessinEnCours == 1)
        {
            dessinEnCours = 2;
        }
        busy = true;
        drawLine();
    }
    if (boutonSelection == boutonDrawLineForm)
    {
        clearInterval(tempoDessin);
        if (mouseX >= saveMousePoints[0][0] - 10 && mouseX <= saveMousePoints[0][0] + 10 && mouseY >= saveMousePoints[1][0] - 10 && mouseY <= saveMousePoints[1][0] + 10 && dessinEnCours == 2)
        {
            canvasSaveDuringCreationShape = ctx.getImageData(0, 0, canvas.width, canvas.height);
            dessinEnCours = 3;
        }
        if (dessinEnCours == 2)
        {
            canvasSaveDuringCreationShape = ctx.getImageData(0, 0, canvas.width, canvas.height);
            dessinEnCours = 1;
        }
        busy = true;
        drawLineForm();
    }
    if (boutonSelection == boutonDrawRect)
    {   
        if (dessinEnCours == 1)
        {
            dessinEnCours = 2;
        }
        busy = true;
        drawRectangle();
    }
    if (boutonSelection == boutonDrawCircle)
    {   
        if (dessinEnCours == 1)
        {
            dessinEnCours = 2;
        }
        busy = true;
        drawCircle();
    }
}

//enregistrer le code.

let recordButton = document.getElementById('recordSubmit');
let recordCode = document.getElementById('record_code');
let recordPng = document.getElementById('record_png');
if (recordButton)
{
    recordButton.addEventListener('click', function(event)
    {
        event.preventDefault();

        let data = canvas.toDataURL("image/png");
        recordPng.value = data;
        recordCode.value = document.getElementById('code').innerHTML;
        document.getElementById("galRecordForm").submit(); 
    });
}

/*recordButton.addEventListener('click', function(event)
{
    event.preventDefault();
    record.value = document.getElementById('code').innerHTML;
    document.getElementById("galRecordForm").submit(); 
});*/
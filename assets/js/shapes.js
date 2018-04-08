function stopBrush()
{
    if (mouseAbsoluteX > 134)
    {
    	clearInterval(tempoDessin);
    	originX = mouseX;
        originY = mouseY;
        dessinEnCours = 0;
        if (stroke === true)
        {
            document.getElementById('code').innerHTML += 'ctx.lineWidth = '+lineOptionWidth+';<br>ctx.strokeStyle = "rgba( '+redStroke+', '+greenStroke+', '+blueStroke+', '+strokeOpacity+')";<br>ctx.stroke();<br>';
        }
        if (fill === true && stroke === false)
        {
           document.getElementById('code').innerHTML += 'ctx.lineWidth = '+lineOptionWidth+';<br>ctx.strokeStyle = "rgba( '+red+', '+green+', '+blue+', '+fillOpacity+')";<br>ctx.stroke();<br>';
        }
        document.getElementById('code').innerHTML += '//BRUSH - END<br>';
        document.getElementById('code').innerHTML += '<span id="lastChild">&lt;/script&gt;</span>';
        addUndo();
        busy = false;
    }
}

function drawBrush()
{
    if (dessinEnCours == 0)
    {
    	ctx.beginPath();
        ctx.moveTo(originX, originY);
      	document.getElementById('code').removeChild(document.getElementById('lastChild'));
      	document.getElementById('code').innerHTML += '//BRUSH - START<br>';
        document.getElementById('code').innerHTML += 'ctx.beginPath();<br>ctx.moveTo('+originX+', '+originY+');<br>';
        dessinEnCours = 1;
    }
   	if (dessinEnCours == 1)
    {
        tempoDessin = setInterval(function(){
        ctx.lineTo(mouseX, mouseY);
        ctx.lineWidth = lineOptionWidth;
        if (stroke === true)
        {
            ctx.strokeStyle = 'rgba( '+redStroke+', '+greenStroke+', '+blueStroke+', '+strokeOpacity+')';
            ctx.stroke();
        }
        if (fill === true && stroke === false)
        {
            ctx.strokeStyle = 'rgba( '+red+', '+green+', '+blue+', '+fillOpacity+')';
            ctx.stroke();
        }
        canvasSaveBetweenTwoShapes = ctx.getImageData(0, 0, canvas.width, canvas.height);

		document.getElementById('code').innerHTML += 'ctx.lineTo('+mouseX+', '+mouseY+');<br>';
        }, 10);
    }
}
function drawLine()
{
    if (dessinEnCours == 0)
    {
        originX = mouseX;
        originY = mouseY;
        dessinEnCours = 1;
    }
    if (dessinEnCours == 1)
    {
        tempoDessin = setInterval(function(){
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.putImageData(canvasSaveDuringCreationShape, 0, 0);
            ctx.beginPath();
            ctx.moveTo(originX, originY);
            ctx.lineTo(mouseX, mouseY);
            saveOriginXForGen = mouseX;
            saveOriginYForGen = mouseY;
            ctx.lineWidth = lineOptionWidth;
            if (stroke === true)
            {
                ctx.strokeStyle = 'rgba( '+redStroke+', '+greenStroke+', '+blueStroke+', '+strokeOpacity+')';
                ctx.stroke();
            }
            if (fill === true && stroke === false)
            {
                ctx.strokeStyle = 'rgba( '+red+', '+green+', '+blue+', '+strokeOpacity+')';
                ctx.stroke();
            }
            ctx.stroke();
            test++;
        }, 10);
    }
    if (dessinEnCours == 2)
    {
        ctx.closePath();
        canvasSaveDuringCreationShape = ctx.getImageData(0, 0, canvas.width, canvas.height);
        clearInterval(tempoDessin);
        dessinEnCours = 0;
        canvasSaveBetweenTwoShapes = ctx.getImageData(0, 0, canvas.width, canvas.height);
        document.getElementById('code').removeChild(document.getElementById('lastChild'));
        document.getElementById('code').innerHTML += 'ctx.beginPath();<br>ctx.moveTo('+originX+', '+originY+');<br>ctx.lineTo('+saveOriginXForGen+', '+saveOriginYForGen+');<br>'
        if (stroke === true)
        {
            document.getElementById('code').innerHTML += 'ctx.lineWidth = '+lineOptionWidth+';<br>ctx.strokeStyle = "rgba( '+redStroke+', '+greenStroke+', '+blueStroke+', '+strokeOpacity+')";<br>ctx.stroke();<br>';
        }
        if (fill === true && stroke === false)
        {
            document.getElementById('code').innerHTML += 'ctx.strokeStyle = "rgba( '+red+', '+green+', '+blue+', '+strokeOpacity+')";<br>ctx.stroke();<br>';
        }
        document.getElementById('code').innerHTML += '<span id="lastChild">&lt;/script&gt;</span>';
        addUndo();
        busy = false;
    }
}


function drawLineForm()
{
    if (dessinEnCours == 0)
    {
        canvasSaveBetweenTwoShapes = ctx.getImageData(0, 0, canvas.width, canvas.height);
        dessinEnCours = 1;
    }
    if (dessinEnCours == 1)
    {
        originX = mouseX;
        originY = mouseY;
        saveMousePoints[0].push(originX);
        saveMousePoints[1].push(originY);
        saveMousePointsIndice++;
        canvasSaveDuringCreationShape = ctx.getImageData(0, 0, canvas.width, canvas.height);
        dessinEnCours = 2;
    }
    if (dessinEnCours == 2)
    {
        tempoDessin = setInterval(function(){
            ctx.beginPath();
            ctx.moveTo(saveMousePoints[0][saveMousePointsIndice], saveMousePoints[1][saveMousePointsIndice]);
            ctx.putImageData(canvasSaveDuringCreationShape, 0, 0);
            ctx.lineTo(mouseX, mouseY);
            ctx.closePath();
            ctx.lineWidth = lineOptionWidth;
            ctx.strokeStyle = 'rgba( '+redStroke+', '+greenStroke+', '+blueStroke+', '+strokeOpacity+')';
            ctx.stroke();
            test++;
        }, 10);
    }
    if (dessinEnCours == 3)
    {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        dessinEnCours = 4;
    }
    if (dessinEnCours == 4)
    {
        clearInterval(tempoDessin);
        ctx.putImageData(canvasSaveBetweenTwoShapes, 0, 0);
        ctx.beginPath();
        ctx.moveTo(saveMousePoints[0][0], saveMousePoints[1][0]);
        for (i = 1; i < saveMousePoints[0].length; i++)
        {
            ctx.lineTo(saveMousePoints[0][i], saveMousePoints[1][i]);
        }
        ctx.lineTo(saveMousePoints[0][0], saveMousePoints[1][0]);
        ctx.closePath();
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
        saveMousePointsIndice = -1;
        dessinEnCours = 5;
    }
    if (dessinEnCours == 5)
    {
        let posGeneratorX = saveMousePoints[0][0];
        let posGeneratorY = saveMousePoints[1][0];
        let parentGenerator = document.getElementById('code');
        let textGenerator = document.createTextNode('ctx.moveTo('+posGeneratorX+', '+posGeneratorY+');');
        document.getElementById('code').removeChild(document.getElementById('lastChild'));
        document.getElementById('code').innerHTML += 'ctx.beginPath();<br>';
        parentGenerator.appendChild(textGenerator);
        parentGenerator.appendChild(document.createElement('br'));
        for (i = 1; i < saveMousePoints[0].length; i++)
        {
            posGeneratorX = saveMousePoints[0][i];
            posGeneratorY = saveMousePoints[1][i];
            textGenerator = document.createTextNode('ctx.lineTo('+posGeneratorX+', '+posGeneratorY+');');
            parentGenerator.appendChild(textGenerator);
            parentGenerator.appendChild(document.createElement('br'));
        }
        document.getElementById('code').innerHTML += 'ctx.closePath();<br>';
        if (stroke === true)
        {
            document.getElementById('code').innerHTML += 'ctx.lineWidth = '+lineOptionWidth+';<br>ctx.strokeStyle = "rgba( '+redStroke+', '+greenStroke+', '+blueStroke+', '+strokeOpacity+')";<br>ctx.stroke();<br>';
        }
        if (fill === true)
        {
            document.getElementById('code').innerHTML += 'ctx.fillStyle = "rgba( '+red+', '+green+', '+blue+', '+fillOpacity+')";<br>ctx.fill();<br>';
        }
        document.getElementById('code').innerHTML += '<span id="lastChild">&lt;/script&gt;</span>';
        canvasSaveBetweenTwoShapes = ctx.getImageData(0, 0, canvas.width, canvas.height);
        saveMousePoints = [[],[]];
        dessinEnCours = 0;
        addUndo();
        busy = false;
    }
}

function drawRectangle()
{
    if (dessinEnCours == 0)
    {
        canvasSaveBetweenTwoShapes = ctx.getImageData(0, 0, canvas.width, canvas.height);
        originX = mouseX;
        originY = mouseY;
        dessinEnCours = 1;
    }
    if (dessinEnCours == 1)
    {
        tempoDessin = setInterval(function(){
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.putImageData(canvasSaveBetweenTwoShapes, 0, 0);
            ctx.beginPath();
            saveOriginXForGen = mouseX;
            saveOriginYForGen = mouseY;
            ctx.rect(originX, originY, saveOriginXForGen - originX, saveOriginYForGen - originY);
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
        }, 10);
    }

    if (dessinEnCours == 2)
    {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.putImageData(canvasSaveBetweenTwoShapes, 0, 0);
        ctx.beginPath();
        ctx.rect(originX, originY, saveOriginXForGen - originX, saveOriginYForGen - originY);
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
        clearInterval(tempoDessin);
        dessinEnCours = 0;
        let rectDestX = saveOriginXForGen - originX;
        let rectDestY = saveOriginYForGen - originY;
        document.getElementById('code').removeChild(document.getElementById('lastChild'));
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
        canvasSaveBetweenTwoShapes = ctx.getImageData(0, 0, canvas.width, canvas.height);
        addUndo();
        busy = false;
    }
}
function drawCircle()
{
    if (dessinEnCours == 0)
    {
        canvasSaveBetweenTwoShapes = ctx.getImageData(0, 0, canvas.width, canvas.height);
        originX = mouseX;
        originY = mouseY;
        dessinEnCours = 1;
    }
    if (dessinEnCours == 1)
    {
        tempoDessin = setInterval(function(){
            circleRadius = Math.sqrt(Math.pow(mouseX - originX, 2) + Math.pow(mouseY - originY, 2))/2;
            circleRadius = parseInt(circleRadius);
            if (circleByCenter === false)
            {
                circleCenterX = originX + ((mouseX - originX)/2);
                circleCenterY = originY + ((mouseY - originY)/2);
            }
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.putImageData(canvasSaveBetweenTwoShapes, 0, 0);
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
        }, 10);
    }

    if (dessinEnCours == 2)
    {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.putImageData(canvasSaveBetweenTwoShapes, 0, 0);
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
        clearInterval(tempoDessin);
        dessinEnCours = 0;
        document.getElementById('code').removeChild(document.getElementById('lastChild'));

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
        canvasSaveBetweenTwoShapes = ctx.getImageData(0, 0, canvas.width, canvas.height);
        addUndo();
        busy = false;
    }
}
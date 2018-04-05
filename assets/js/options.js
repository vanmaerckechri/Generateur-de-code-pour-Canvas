function changeStrokeOpacity()
{
    let opacityStrokeId = document.querySelector("#opacityStroke");
    opacityStrokeId.value = opacityStrokeId.value > 100 ? 100 : opacityStrokeId.value;
    opacityStrokeId.value = opacityStrokeId.value < 0 ? 0 : opacityStrokeId.value;
    opacityStrokeId.value = isNaN(opacityStrokeId.value) ? 100 : opacityStrokeId.value;
    strokeOpacity = (opacityStrokeId.value/100);
}

function changeFillOpacity()
{
    let opacityFillId = document.querySelector("#opacityFill");
    opacityFillId.value = opacityFillId.value > 100 ? 100 : opacityFillId.value;
    opacityFillId.value = opacityFillId.value < 0 ? 0 : opacityFillId.value;
    opacityFillId.value = isNaN(opacityFillId.value) ? 100 : opacityFillId.value;
    fillOpacity = (opacityFillId.value/100);
}

function changeColor()
{
    let slider = document.getElementsByClassName("slider");
    let colorActu = document.getElementById('color');
    let colorActuStroke = document.getElementById('colorStroke');
    redStroke = slider[0].value;
    greenStroke = slider[2].value;
    blueStroke = slider[4].value;
    red = slider[1].value;
    green = slider[3].value;
    blue = slider[5].value;
    colorActu.style.backgroundColor = 'rgb( '+red+', '+green+', '+blue+')';
    colorActuStroke.style.backgroundColor = 'rgb( '+redStroke+', '+greenStroke+', '+blueStroke+')';
}

function changeLineWidth()
{
	let lineWidthId = document.getElementById('lineOptionWidth');
	lineWidthId.value = (lineWidthId.value <= 0 || isNaN(lineWidthId.value)) ? 1 : lineWidthId.value;
	lineOptionWidth = document.getElementById('lineOptionWidth').value;
}

document.getElementById('lineOptionWidth').addEventListener('keypress', function (e)
{
	var key = e.which || e.keyCode;
	if (key === 13)
	{
		changeLineWidth();
	}
});


function changePaintOption(thisId, option)
{
    if (thisId == document.getElementById('strokeOption'))
    {
        if (stroke == false)
        {
            thisId.className = 'button_Select';
            stroke = true;
        }
        else
        {
            thisId.className = 'button_unselect';
            stroke = false;
        }
    }
    if (thisId == document.getElementById('fillOption'))
    {
        if (fill == false)
        {
            thisId.className = 'button_Select';
            fill = true;
        }
        else
        {
            thisId.className = 'button_unselect';
            fill = false;
        }
    }
}
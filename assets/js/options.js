//OPACITY!
let strokeOpacity;
let opacityStrokeId = document.querySelector("#opacityStroke");
opacityStrokeId.addEventListener('change', changeStrokeOpacity);
function changeStrokeOpacity()
{
    opacityStrokeId.value = opacityStrokeId.value > 100 ? 100 : opacityStrokeId.value;
    opacityStrokeId.value = opacityStrokeId.value < 0 ? 0 : opacityStrokeId.value;
    opacityStrokeId.value = isNaN(opacityStrokeId.value) ? 100 : opacityStrokeId.value;
    strokeOpacity = (opacityStrokeId.value/100);
}

let fillOpacity;
let opacityFillId = document.querySelector("#opacityFill");
opacityFillId.addEventListener('change', changeFillOpacity);
function changeFillOpacity()
{
    opacityFillId.value = opacityFillId.value > 100 ? 100 : opacityFillId.value;
    opacityFillId.value = opacityFillId.value < 0 ? 0 : opacityFillId.value;
    opacityFillId.value = isNaN(opacityFillId.value) ? 100 : opacityFillId.value;
    fillOpacity = (opacityFillId.value/100);
}

//COLOR!
let slider = document.getElementsByClassName("slider");
let redStroke, greenStroke, blueStroke, red, green, blue;
//distribution de l'evenement "click" sur les options de couleur.
for (let i = 0, sliderLength = slider.length; i < sliderLength; i++)
{
    slider[i].addEventListener('change', function()
    {
        changeColor();
    });
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

//LINE WIDTH!
let lineWidth = document.getElementById('lineOptionWidth');
lineWidth.addEventListener('change', changeLineWidth);
function changeLineWidth()
{
	lineWidth.value = (lineWidth.value <= 0 || isNaN(lineWidth.value)) ? 1 : lineWidth.value;
	lineOptionWidth = lineWidth.value;
}

changeStrokeOpacity();
changeFillOpacity();
changeColor();
changeLineWidth();

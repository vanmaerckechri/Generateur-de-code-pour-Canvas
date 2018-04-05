window.onload = function()
{                
      let slider = document.getElementsByClassName("slider");
      redStroke = slider[0].value = 255;
      greenStroke = slider[2].value = 0;
      blueStroke = slider[4].value = 0;
      red = slider[1].value = 0;
      green = slider[3].value = 255;
      blue = slider[5].value = 0;
      //canvasWidth = prompt('width canvas');
      //canvasHeight = prompt('height canvas');
      if (isNaN(parseFloat(canvasWidth)) || isNaN(parseFloat(canvasHeight)))
      {
            canvasWidth = 700;
            canvasHeight = 700;
      }
      canvas.width = canvasWidth;
      canvas.height = canvasHeight;
      canvasSaveDuringCreationShape = ctx.getImageData(0, 0, canvas.width, canvas.height);
      canvasSaveBetweenTwoShapes = ctx.getImageData(0, 0, canvas.width, canvas.height);
      document.getElementById('lineOptionWidth').value = 3;
      document.getElementById('code').innerHTML += '&lt;canvas id="scene" width="'+canvasWidth+'" height="'+canvasHeight+'"&gt;<br>&lt;/canvas&gt;<br>&lt;script type="text/javascript"&gt;<br>var canvas = document.getElementById("scene");<br>var ctx = canvas.getContext("2d");<br><span id="lastChild">&lt;/script&gt;<br></span>';
      gestionEvent();
      addUndo();
      changeStrokeOpacity();
      changeFillOpacity();
};
function activerUndo()
{
	if (undoIndex > 0 && busy == false)
	{
		undoIndex--;
		let restoreUndo = undoRedo[undoIndex];
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		ctx.putImageData(restoreUndo, 0, 0);
        canvasSaveDuringCreationShape = ctx.getImageData(0, 0, canvas.width, canvas.height);
        canvasSaveBetweenTwoShapes = ctx.getImageData(0, 0, canvas.width, canvas.height);
		document.getElementById('code').innerHTML = undoRedoCode[undoIndex];
	}
}
function activerRedo()
{
	if (undoIndex + 1 < undoRedo.length && busy == false)
	{
		undoIndex++;
		let restoreUndo = undoRedo[undoIndex];
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		ctx.putImageData(restoreUndo, 0, 0);
        canvasSaveDuringCreationShape = ctx.getImageData(0, 0, canvas.width, canvas.height);
        canvasSaveBetweenTwoShapes = ctx.getImageData(0, 0, canvas.width, canvas.height);
		document.getElementById('code').innerHTML = undoRedoCode[undoIndex];
	}
}

function addUndo()
{
	let saveThisStep = ctx.getImageData(0, 0, canvas.width, canvas.height);
	if (undoIndex < 9)
	{
		let deleteRedo = 9 - undoIndex;
		undoIndex++;
		undoRedo.splice(undoIndex, deleteRedo);
			undoRedoCode.splice(undoIndex, deleteRedo);
		}
	else
	{
		for (let i = 0; i < undoRedo.length; i++)
      	{
				undoRedo[i] = undoRedo[i+1];
				undoRedoCode[i] = undoRedoCode[i+1];
      	}
      }
	undoRedo[undoIndex] = saveThisStep;
	undoRedoCode[undoIndex] = document.getElementById('code').innerHTML;
}
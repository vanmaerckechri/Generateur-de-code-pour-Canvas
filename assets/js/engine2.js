//MANAGE TOOLS BUTTONS!
let toolButtons = document.querySelectorAll('.brushs button')
let toolSelected = "brush";
for (let i = 0, toolButtonsLength = toolButtons.length; i < toolButtons.length; i++)
{
  toolButtons[i].addEventListener('click', function()
  {
  		selectTool(toolButtons[i]);
  });
}

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
		console.log(toolSelected);
	}
}
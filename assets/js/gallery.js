//filtres
let parPage = document.getElementById('parPage');
parPage.addEventListener("change", function()
{
    document.getElementById("formFilter").submit(); 
});

let trierPar = document.getElementById('trierPar');
trierPar.addEventListener("change", function()
{
    document.getElementById("formFilter").submit(); 
});

let dessins = document.querySelectorAll('.dessins > .dessin > img');
let dessinsLength = dessins.length;
	console.log(dessins);

for (i = 0; i < dessinsLength; i++)
{
	dessins[i].addEventListener("click", zoomDrawDetails, false)
}

function zoomDrawDetails(event)
{
	console.log(event);
	let dessinDetail = document.getElementById('dessinDetail');
	dessinDetail.className += " dessinDetailMax";
	dessinDetail.innerHTML = '<img src="'+event.target.src+'">';
}

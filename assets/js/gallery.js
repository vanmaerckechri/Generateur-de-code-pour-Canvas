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

//fenetre modale sur dessin cliqué.
let dessins = document.querySelectorAll('.dessins > .dessin > img');
let dessinsLength = dessins.length;

for (i = 0; i < dessinsLength; i++)
{
	dessins[i].addEventListener("click", zoomDrawDetails)
}

function zoomDrawDetails(event)
{
	let dessinDetail = document.getElementById('dessinDetail');
	dessinDetail.innerHTML = '<img src="'+event.target.src+'">';
	dessinDetail.classList.add("dessinDetailMax");
}

dessinDetail.addEventListener("click", dezoomDrawDetails)

function dezoomDrawDetails(event)
{
	if(event.target == dessinDetail)
	{
		dessinDetail.classList.remove("dessinDetailMax");
	}
}

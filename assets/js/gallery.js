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

let imgActu;
let arrowLeft;
let arrowRight;
let imgActuDiv
function zoomDrawDetails(event)
{
	let dessinDetail = document.getElementById('dessinDetail');
	imgActuDiv = document.getElementById('imgActu');

	imgActuDiv.innerHTML = '<img src="'+event.target.src+'">';
	dessinDetail.classList.add("dessinDetailMax");

	arrowLeft = document.querySelectorAll('.arrowLeft');
	arrowRight = document.querySelectorAll('.arrowRight');
	arrowLeft[0].addEventListener("click", previousImg);
	arrowRight[0].addEventListener("click", nextImg);

	let dessinsListeLength = dessinsListe[0].length;
	let imgSource = event.target.src.replace(/.png/, "");
    imgSource = imgSource.substring(imgSource.indexOf('/assets'));
	imgSource = imgSource.replace("/assets", "./assets");

	for (i = 0; i < dessinsListeLength; i++)
	{
		if (dessinsListe[0][i] == imgSource)
		{
			imgActu = i;
		}
	}
}

dessinDetail.addEventListener("click", dezoomDrawDetails)
function dezoomDrawDetails(event)
{
	if(event.target == dessinDetail)
	{
		arrowLeft[0].removeEventListener("click", previousImg);
		arrowRight[0].removeEventListener("click", nextImg);
		imgActuDiv.innerHTML = '';
		dessinDetail.classList.remove("dessinDetailMax");
	}
}


function previousImg()
{
	imgActu --;
	imgActu = imgActu < 0 ? dessinsListe[0].length - 1 : imgActu;
	imgActuDiv.innerHTML = '<img src="'+dessinsListe[0][imgActu]+'">';
}
function nextImg()
{
	imgActu ++;
	imgActu = imgActu >= dessinsListe[0].length ? 0 : imgActu;
	imgActuDiv.innerHTML = '<img src="'+dessinsListe[0][imgActu]+'">';
}

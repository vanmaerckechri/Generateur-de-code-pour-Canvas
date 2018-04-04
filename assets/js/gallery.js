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
let imgActuDiv = document.getElementById('imgActu');
let changeTitleForm;
let deleteDessin;
let changeTitle;
let changeTitleIcon;
let dessinDetail = document.getElementById('dessinDetail');
dessinDetail.addEventListener("click", dezoomDrawDetails)

function displayTitle()
{
	let title = "<form id='changeTitleForm' method='post' action='index.php?action=gallery&updtitle'>";
	title += "<input class='changeTitle' type='text' value='"+dessinsListe[2][imgActu]+"'>";
	title += "<input type='hidden' name='idTitle' value='"+dessinsListe[1][imgActu]+"'>";
	title += "</form>";
	return title;
}

function zoomDrawDetails(event)
{
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
		dessinsListe[4][i] = dessinsListe[4][i].replace(/\r/i, '');
	}

	let title = displayTitle();

	imgActuDiv.innerHTML = '<div class="titre">'+title+'</div><img src="'+event.target.src+'"><div class="auteur">'+dessinsListe[1][imgActu]+' | '+dessinsListe[3][imgActu]+'</div>';
	dessinDetail.classList.add("dessinDetailMax");
	toggleDisplayID.innerHTML = "Code";
	toggleDisplay = 1;

	arrowLeft = document.querySelectorAll('.arrowLeft');
	arrowRight = document.querySelectorAll('.arrowRight');
	arrowLeft[0].addEventListener("click", previousImg);
	arrowRight[0].addEventListener("click", nextImg);
	displayMyOptions();
}
//fermer fenetre modale
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
//circuler dans les images via la fenetre modale
function previousImg()
{
	imgActu --;
	imgActu = imgActu < 0 ? dessinsListe[0].length - 1 : imgActu;

	let title = displayTitle();

	if (toggleDisplay == 1)
	{
		imgActuDiv.innerHTML = '<div class="titre">'+title+'</div><img src="'+dessinsListe[0][imgActu]+'.png"><div class="auteur">'+dessinsListe[1][imgActu]+' | '+dessinsListe[3][imgActu]+'</div>';
	}
	else
	{
		imgActuDiv.innerHTML = '<div class="titre">'+title+'</div><p id="codeActu">'+dessinsListe[4][imgActu]+'</p><div class="auteur">'+dessinsListe[1][imgActu]+' | '+dessinsListe[3][imgActu]+'</div>';
	}
	displayMyOptions();
}
function nextImg()
{
	imgActu ++;
	imgActu = imgActu >= dessinsListe[0].length ? 0 : imgActu;

	let title = displayTitle();

	if (toggleDisplay == 1)
	{
		imgActuDiv.innerHTML = '<div class="titre">'+title+'</div><img src="'+dessinsListe[0][imgActu]+'.png"><div class="auteur">'+dessinsListe[1][imgActu]+' | '+dessinsListe[3][imgActu]+'</div>';
	}
	else
	{
		imgActuDiv.innerHTML = '<div class="titre">'+title+'</div><p id="codeActu">'+dessinsListe[4][imgActu]+'</p><div class="auteur">'+dessinsListe[1][imgActu]+' | '+dessinsListe[3][imgActu]+'</div>';
	}
	displayMyOptions();
}
//afficher code|dessin
let toggleDisplay = 1;
let toggleDisplayID = document.getElementById('toggleDisplay');
toggleDisplayID.addEventListener('click', toggleDisplayCode);

let title = displayTitle();

function toggleDisplayCode()
{
	if (toggleDisplay == 1)
	{
		imgActuDiv.innerHTML = '<div class="titre">'+title+'</div><p id="codeActu">'+dessinsListe[4][imgActu]+'</p><div class="auteur">'+dessinsListe[1][imgActu]+' | '+dessinsListe[3][imgActu]+'</div>';
		toggleDisplayID.innerHTML = "Dessin";
		toggleDisplay = 0;
	}
	else
	{
		imgActuDiv.innerHTML = '<div class="titre">'+title+'</div><img src="'+dessinsListe[0][imgActu]+'.png"><div class="auteur">'+dessinsListe[1][imgActu]+' | '+dessinsListe[3][imgActu]+'</div>';
		toggleDisplayID.innerHTML = "Code";
		toggleDisplay = 1;
	}
	displayMyOptions();
}

function displayMyOptions()
{
	if (dessinsListe[5][imgActu] == 1)
	{
		let modalTitle = document.querySelectorAll('.titre');
		modalTitle = modalTitle[0];
		modalTitle.innerHTML += '<div class="dessinOptions"><img src="assets/img/pen.png" class="changeTitleIcon"><img src="assets/img/trash.png" class="deleteDessin"></div>';
		imgActuDiv.style.borderColor = "orange";

		deleteDessin = document.querySelectorAll('.deleteDessin');
		deleteDessin = deleteDessin[0];
		deleteDessin.addEventListener('click', deleteDraw);

		changeTitleIcon = document.querySelectorAll('.changeTitleIcon');
		changeTitleIcon = changeTitleIcon[0];
		changeTitleIcon.addEventListener('click', openChangeTitle);
	}
	else
	{
		imgActuDiv.style.borderColor = "white";
	}
}

function deleteDraw()
{
	let deleteValidation = document.querySelectorAll('.deleteValidation');
	if (deleteValidation[0] === undefined)
	{
		imgActuDiv.innerHTML += "<form class='deleteValidation' method='post' action='index.php?action=delete'><input type='hidden' name='deleteDessin' id='deleteDessin'><input type='hidden' name='deleteAuteur' value='"+dessinsListe[1][imgActu]+"'><p>Etes-vous sûr de vouloir supprimer définitivement ce dessin?  </p><input type='submit' value='OUI'></form>";
		document.getElementById('deleteDessin').value = parseInt(dessinsListe[6][imgActu], 10);

		changeTitleIcon = document.querySelectorAll('.changeTitleIcon');
		changeTitleIcon = changeTitleIcon[0];
		changeTitleIcon.addEventListener('click', openChangeTitle);
	}
	else
	{
        deleteValidation[0].parentNode.removeChild(deleteValidation[0]);
    }
    let deleteDessin = document.querySelectorAll('.deleteDessin');
	deleteDessin = deleteDessin[0];
	deleteDessin.addEventListener('click', deleteDraw);
}

function openChangeTitle()
{
	changeTitleForm = document.getElementById('changeTitleForm')
	changeTitle = document.querySelectorAll('.changeTitle');
	changeTitle = changeTitle[0];
	if (!changeTitle.classList.contains('changeTitleOpen'))
	{
		changeTitle.classList.add('changeTitleOpen');
	}
	else
	{
		changeTitle.classList.remove('changeTitleOpen');
	}
}
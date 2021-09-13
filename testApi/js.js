let select = document.querySelector('select');
let content = document.querySelector('.content');
let form = document.querySelector('.form');
let list = document.createElement('select');

function a(){
    list.style.display='none';
    let request = select.value;
    content.innerHTML = '';
    if(request == 'Animal'){
        list.style.display = 'block';
        AnimalList();
    } else if (request == 'Animaux' || request == 'Familles' ||request == 'Continents')
    getData(request)
    else responseDisplay('');
}

function animal(){
    let request2 = select.value + '/' + list.value;
    if(list.value>0)getData(request2);
}

function responseDisplay(data){
    switch (select.value) {

        case 'Animaux':
            for (let Animal in data){
                let continent = '';
                for(let test in data[Animal].continents){
                    continent+=data[Animal].continents[test].continentLibelle+', ';
                }
                continent = continent.substring(0, continent.length - 2);
                let card = document.createElement('div');
                card.innerHTML = `<div class="card my-3" style="width: 18rem;">
                        <img src="image/${data[Animal].image}" class="card-img-top" alt="${data[Animal].nom}">
                        <div class="card-body">
                            <h5 class="card-title">${data[Animal].nom}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">${data[Animal].famille.libelleFamille}</h6>
                            <p class="card-text">${data[Animal].description}</p>
                            <p class="text-muted">Continent : ${continent} </p>
                        </div>
                    </div>`;
                content.append(card);
            }
            break;

        case 'Animal':
            for (let Animal in data){
                let continent = '';
                for(let test in data[Animal].continents){
                    continent+=data[Animal].continents[test].continentLibelle+', ';
                }
                continent = continent.substring(0, continent.length - 2);
                let card = document.createElement('div');
                card.innerHTML = `<div class="card my-3" style="width: 28rem;">
                            <img src="image/${data[Animal].image}" class="card-img-top" alt="${data[Animal].nom}">
                            <div class="card-body">
                                <h5 class="card-title">${data[Animal].nom}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">${data[Animal].famille.libelleFamille}</h6>
                                <p class="card-text">${data[Animal].description}</p>
                                <p class="text-muted">Continent : ${continent} </p>
                            </div>
                        </div>`;
                content.append(card);
            }

            break;

        case 'Continents':
            for (let Continents in data){
                let card = document.createElement('div');
                card.innerHTML = `<div class="d-flex justify-content-between flex-wrap content">
                        <div class="card my-3" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">${data[Continents].continent_libelle}</h5>
                            </div>
                        </div>
                    </div>`;
                content.append(card);
            }
            break;

        case 'Familles':
            for (let Familles in data){
                let card = document.createElement('div');
                card.innerHTML = `<div class="d-flex justify-content-between flex-wrap content">
                        <div class="card my-3" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">${data[Familles].famille_libelle}</h5>
                                <p class="card-text">${data[Familles].famille_description}</p>
                            </div>
                        </div>
                    </div>`;
                content.append(card);
            }
            break;

        default:
        break;

    }
}

function getData(data){

    fetch("http://localhost/Animaux/Front/"+data, {
	"method": "GET"
    })

    .then(response => response.json())

    .then(response => {
        responseDisplay(response);
    })

    .catch(err => {
        console.error(err);
    });

}

function AnimalList(){
    fetch("http://localhost/Animaux/Front/Animaux", {
	"method": "GET"
    })

    .then(response => response.json())

    .then(response => {
        if (list.length == 0){
        for (let Animal in response){
            let option = document.createElement('option');
            option.value = response[Animal].id;
            option.innerHTML = response[Animal].nom;
            list.append(option);
        }
        form.append(list);}
        animal();
    })

    .catch(err => {
        console.error(err);
    });

}



select.addEventListener('change',a);
list.addEventListener('change',a);
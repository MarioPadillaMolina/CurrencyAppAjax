(function () {
    /* global fetch, $ */

    /**************************************************************************/
    /* variables 'globales' de la función                                     */

    let lastPage = '';
    let pageNumber = 1;
    let route = '';
    let rows = 3;
    let token = '';

    /**************************************************************************/
    /* acciones que se ejecutan inmediatamente                                */

    //evento clic del botón addCurrency de los modales (al método store)
    let addMoneda = document.getElementById('addCurrency');
    if (addMoneda) {
        addMoneda.addEventListener('click', function (event) {
            addCurrency();
        });
    }

    let deleteMoneda = document.getElementById('deleteCurrency');
    if (deleteMoneda) {
        deleteMoneda.addEventListener('click', function (event) {
            deleteCurrency();
        });
    }

    //evento click del botón editEmpresa
    let editMoneda = document.getElementById('editCurrency');
    if (editMoneda) {
        editMoneda.addEventListener('click', function (event) {
            editCurrency();
        });
    }

    //evento click de los botones de paginación
    //https://stackoverflow.com/questions/15995813/best-way-to-bind-events-with-dynamiac-data-to-elements-after-ajax-load-in-raw
    let tbody = document.getElementById('tbody');
    if (tbody) {
        tbody.addEventListener('click', function (event) {
            if (event.target.classList.contains('editModal')) {
                document.body.classList.add('body');
                //setTimeout sólo para percibir correctamente el tiempo de procesamiento
                setTimeout(function () { getCurrency(event.target.dataset.id); }, 200);
            }
            if (event.target.classList.contains('deleteModal')) {
                document.getElementById('nameBorrar').innerHTML = event.target.dataset.name;
                route = 'ajaxcurrency/' + event.target.dataset.id;
                $('#deleteModal').modal('show');
            }
        });
    }

    //carga de la primera página
    getPage('ajaxcurrency');

    /**************************************************************************/
    /* declaración e implementación de funciones usadas                       */

    //después de editar una moneda se muestran los datos actualizados
    function updateCurrency(data) {
        let id = data.currency.id;
        document.getElementById('td' + id + "_0").textContent = data.currency.name;
        document.getElementById('td' + id + "_1").firstChild.nodeValue = data.currency.symbol;
        document.getElementById('td' + id + "_2").textContent = data.currency.zone;
        document.getElementById('td' + id + "_3").textContent = data.currency.value;
        document.getElementById('td' + id + "_4").textContent = data.currency.creationdate;
    }

    //petición ajax para agregar una moneda nueva
    function addCurrency() {
        let data = getFormdata('addCurrencyForm');
        let url = 'ajaxcurrency';
        document.body.classList.add('body');
        fetch(url, {
            body: data,
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            method: 'post',
        })
            .then(function (response) {
                document.body.classList.remove('body');
                return response.json();
            })
            .then(function (data) {
                //no controlamos los errores, habría que hacerlo
                //if(!data.notValid) {
                //mostrar errores
                //} else {
                showCurrency(data);
                $('#addModal').modal('hide');
                let form = document.getElementById('addCurrencyForm');
                form.reset();
                //}
                console.log('Request succeeded with JSON response', data);
            })
            .catch(function (error) {
                console.log('Request failed', error);
            });
    }

    //crea los enlaces de paginación
    function createLink(json) {
        let li;
        if (json.active) {
            //enlace actual
            //<li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
            li = createLinkActual(json);
        } else {
            if (json.url) {
                //enlace que existe
                //<li class="page-item"><a class="page-link" href="URL">LABEL</a></li>
                li = createLinkPage(json);
            } else {
                //enlace que no existe
                //<li class="page-item disabled" aria-disabled="true" aria-label="LABEL"><span class="page-link" aria-hidden="true">LABEL</span></li>
                li = createLinkDisabled(json);
            }
        }
        return li;
    }

    //enlace de paginación a la página actual
    function createLinkActual(json) {
        let li = document.createElement('li');
        li.classList.add('page-item');
        li.classList.add('active');
        li.setAttribute('aria-current', 'page');
        let span = document.createElement('span');
        span.classList.add('page-link');
        let node = document.createTextNode(decodeLabel(json.label));
        span.appendChild(node);
        li.appendChild(span);
        return li;
    }

    //enlace de paginación deshabilitado
    function createLinkDisabled(json) {
        let li = document.createElement('li');
        li.classList.add('page-item');
        li.classList.add('disabled');
        li.setAttribute('aria-disables', 'true');
        li.setAttribute('aria-label', json.label);
        let span = document.createElement('span');
        span.classList.add('page-link');
        span.setAttribute('aria-hidden', 'true');
        let node = document.createTextNode(decodeLabel(json.label));
        span.appendChild(node);
        li.appendChild(span);
        return li;
    }

    //enlace de paginación a una página que existe
    function createLinkPage(json) {
        let li = document.createElement('li');
        li.classList.add('page-item');
        li.classList.add('pointer');
        let a = document.createElement('a');
        li.classList.add('page-link');
        a.dataset.url = json.url;
        a.dataset.page = json.label;
        a.addEventListener('click', function (event) {
            event.preventDefault();
            getPage(event.target.dataset.url);
        });
        let node = document.createTextNode(decodeLabel(json.label));
        a.appendChild(node);
        li.appendChild(a);
        return li;
    }

    //crea la lista de enlaces de paginación
    function createLinkDom(jsonComplete) {
        deleteChildNodes('enlacesPaginacion');
        let enlaces = document.getElementById('enlacesPaginacion');
        let json = jsonComplete.currencies;
        for (let i = 0; i < json.links.length; i++) {
            let enlace = createLink(json.links[i]);
            enlaces.appendChild(enlace);
        }
    }

    //crea la tabla con la lista de monedas recibidas por ajax
    function createTableDom(jsonComplete) {
        deleteChildNodes('tbody');
        let tbody = document.getElementById('tbody');
        let json = jsonComplete.currencies;
        for (let i = 0; i < json.data.length; i++) {
            tbody.appendChild(createTr(json.data[i]));
        }
    }

    //crea el elemento td de la tabla de monedas
    function createTd(text, classNames = [], data = [], id = '') {
        let td = document.createElement('td');
        let node = document.createTextNode(text);
        td.appendChild(node);
        if (id != '') {
            td.id = 'td' + id;
        }
        //https://stackoverflow.com/questions/3010840/loop-through-an-array-in-javascript
        for (const className of classNames) {
            td.classList.add(className);
        }
        for (const dataAttribute of data) {
            td.dataset[dataAttribute.name] = dataAttribute.value;
        }
        return td;
    }

    function createTr(json) {
        let tr = document.createElement('tr');
        let id = json.id;
        tr.appendChild(createTd(id));
        tr.appendChild(createTd(json.name, [], [{ name: 'name', value: id + '_' + 0 }], id + '_' + 0));
        tr.appendChild(createTd(json.symbol, [], [{ name: 'name', value: id + '_' + 1 }], id + '_' + 1));
        tr.appendChild(createTd(json.zone, [], [{ name: 'name', value: id + '_' + 2 }], id + '_' + 2));
        tr.appendChild(createTd(json.value, [], [{ name: 'name', value: id + '_' + 3 }], id + '_' + 3));
        tr.appendChild(createTd(json.creationdate, [], [{ name: 'name', value: id + '_' + 4 }], id + '_' + 4));
        tr.appendChild(createTd('show', [],));
        tr.appendChild(createTd('edit', ['pointer', 'azul', 'editModal'], [{ name: 'id', value: id },
        { name: 'name', value: json.name },
        { name: 'symbol', value: json.symbol },
        { name: 'zone', value: json.zone },
        { name: 'value', value: json.value },
        { name: 'creationdate', value: json.creationdate },]));
        tr.appendChild(createTd('delete', ['pointer', 'azul', 'deleteModal'], [{ name: 'id', value: id }, { name: 'name', value: json.name }]));
        return tr;
    }

    //para decodificar los enlaces de página anterior y siguiente de forma correcta
    //son estos dos símbolos que daban problemas: « y »
    function decodeLabel(jsonLabel) {
        var textarea = document.createElement('textarea');
        textarea.innerHTML = jsonLabel;
        return textarea.value;
    }

    //borrar todos los hijos de un elemento (id)
    function deleteChildNodes(id) {
        let element = document.getElementById(id);
        //element.innerHTML = '';
        if (element) {
            while (element.firstChild) {
                element.removeChild(element.firstChild);
            }
        }
    }

    function deleteCurrency() {
        let url = route;
        document.body.classList.add('body');
        fetch(url, {
            body: getFormdata() + "&lastPage=" + encodeURIComponent(lastPage),
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            method: 'delete',
        })
            .then(function (response) {
                document.body.classList.remove('body');
                return response.json();
            })
            .then(function (data) {
                //no controlamos los errores, habría que hacerlo
                //if(!data.notValid) {
                //mostrar errores
                //} else {
                //actualizarEmpresa(data);
                $('#deleteModal').modal('hide');
                createTableDom(data);
                createLinkDom(data);
                //getPage(lastPage);
                //}
                console.log('Request succeeded with JSON response', data);
            })
            .catch(function (error) {
                console.log('Request failed', error);
            });
    }

    //petición ajax para editar la moneda actual
    function editCurrency() {
        let data = getFormdata('currencyForm');
        let url = route;
        document.body.classList.add('body');
        fetch(url, {
            body: data,
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            method: 'put',
        })
            .then(function (response) {
                document.body.classList.remove('body');
                return response.json();
            })
            .then(function (data) {
                //no controlamos los errores, habría que hacerlo
                //if(!data.notValid) {
                //mostrar errores
                //} else {
                updateCurrency(data);
                $('#editModal').modal('hide');
                //}
                console.log('Request succeeded with JSON response', data);
            })
            .catch(function (error) {
                console.log('Request failed', error);
            });
    }

    //petición ajax para obtener datos de la moneda que se va a editar
    function getCurrency(id) {
        fetch('ajaxcurrency/' + id) //llama al show() del controlador
            .then(function (response) {
                return response.json();
            })
            .then(function (json) {
                document.body.classList.remove('body');
                if (json.currency.id) {
                    document.getElementById('name').value = json.currency.name;
                    document.getElementById('symbol').value = json.currency.symbol;
                    document.getElementById('zone').value = json.currency.zone;
                    document.getElementById('value').value = json.currency.value;
                    document.getElementById('creationdate').value = json.currency.creationdate;
                    route = 'ajaxcurrency/' + json.currency.id;
                    $('#editModal').modal('show');
                } else {
                    alert('Error, the currency doesnt exists.');
                }
            })
            .catch(function (error) {
                document.body.classList.remove('body');
                alert('error');
                console.log('Request failed', error)
            });
    }

    //convierte los datos del formulario FormData en parámetros de la petición
    function getFormdata(idForm = '') {
        let data = '';
        if (idForm != '') {
            let form = document.getElementById(idForm);
            if (form) {
                let formData = new FormData(form); //multipart/form-data
                for (var entry of formData.entries()) {
                    data += encodeURIComponent(entry[0]) + '=' + encodeURIComponent(entry[1]) + '&'; //pares clave valor = 0 clave - 1 valor
                    //encodeURIComponent -> para que las cadenas con caracteres especiales viajen bien
                }
            }
        }
        data += '_page=' + pageNumber + '&';
        data += '_token=' + token;
        return data;
    }

    //petición ajax de la página con el listado de monedas paginado
    function getPage(page) {
        lastPage = page;//ajaxcurrency?page=2 https://...../ajaxcurrency?page=2&orderby=2&rows=12&query=algo
        //page, orderby, rows, query
        fetch(page)
            .then(function (response) {
                return response.json();
            })
            .then(function (json) {
                //habría que comprobar que los datos llegan bien
                console.log(json);
                createTableDom(json);
                createLinkDom(json);
                //estas dos asignaciones se realizan por conveniencia
                //al incluir los token en el formulario se procesan junto con todos
                //los demás elementos del formulario
                token = json.token;
                pageNumber = json.currencies.current_page;
            })
            .catch(function (error) {
                alert('error');
                console.log('Request failed', error)
            });
    }

    function showCurrency(data) {
        console.log(data);
        let tr = createTr(data.currency);
        let tbody = document.getElementById('tbody');
        tbody.appendChild(tr);
    }

})();


/*

//https://stackoverflow.com/questions/15995813/best-way-to-bind-events-with-dynamiac-data-to-elements-after-ajax-load-in-raw

$('#editModal').modal('show');
document.getElementById('name').value = event.target.dataset.name;
document.getElementById('phone').value = event.target.dataset.phone;
document.getElementById('address').value = event.target.dataset.address;
document.getElementById('taxnumber').value = event.target.dataset.taxnumber;
document.getElementById('contactperson').value = event.target.dataset.contactperson;

function pintaEnlace(json) {
    let text = '<a id="e1" class="getpage" data-url="' + json.next_page_url + '" href="javascript: void(0)">siguiente página</a>';
    document.getElementById('enlacesPaginacion').innerHTML = text;
    document.getElementById('e1').addEventListener('click', function(event) {
        getPage(event.target.dataset.url);
    });
}

function pintaTabla(json) {
    let text = '';
    for(let i = 0; i < json.data.length; i++) {
        text += '<tr><td>' +
                json.data[i].id +
                '</td><td>' +
                json.data[i].name +
                '</td><td>' +
                json.data[i].phone +
                '</td><td>' +
                json.data[i].contactperson +
                '</td><td>' +
                json.data[i].taxnumber +
                '</td><td>enlace</td><td>enlace</td><td>enlace</td><td>enlace</td><td>enlace</td></tr>';
    }
    //document.getElementById('tbody').innerHTML = text;
    deleteChildNodes('tbody');
    document.getElementById('tbody').insertAdjacentHTML('afterbegin', text);
}

//$('#editModal').modal('show');
//$('#createModal').modal('show');

function createLinkDomOld(json) {
    let ahref = document.createElement('a');
    ahref.classList.add('getPage'); //ahref.setAttribute('class', 'getPage');
    ahref.setAttribute('href', 'javascript: void(0)');
    ahref.dataset.url = json.next_page_url;
    let node = document.createTextNode('siguiente página');
    ahref.appendChild(node);
    deleteChildNodes('enlacesPaginacion');
    ahref.addEventListener('click', function(event) {
        getPage(event.target.dataset.url);
    });
    let enlaces = document.getElementById('enlacesPaginacion');
    enlaces.appendChild(ahref);
}

*/
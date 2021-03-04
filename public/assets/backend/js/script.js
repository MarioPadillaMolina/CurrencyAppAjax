(function() {

    //validación...
    let createMonedaForm = document.getElementById('createMonedaForm');
    
    //incompleto, falta validación
    if (createMonedaForm) {
        createMonedaForm.addEventListener('submit', function(event) {
            if (1 == 1) {
                //submit
            }
            else {
                alert("error validating");
                event.preventDefault();
            }
        })
    }
    
    //borrado
    let launchModal = document.getElementsByClassName('launchModal');
    if (launchModal) {
        for (var i = 0; i < launchModal.length; i++) {
            launchModal[i].addEventListener('click', sendModal);
        }
    }
    
    function sendModal(){
        let id = event.target.dataset.id;
        let name = event.target.dataset.name;
        document.getElementById("monedaId").innerText = id;
        document.getElementById("monedaName").innerText = name;
        document.getElementById("modalConfirmation").setAttribute("data-id", id);
        document.getElementById("modalConfirmation").setAttribute("data-name", name);
    }
    
    
    let modalConfirmation = document.getElementById("modalConfirmation");
    if(modalConfirmation) {
        modalConfirmation.addEventListener('click', getModalConfirmation);        
    }
    
    function getModalConfirmation() {
        let id = event.target.dataset.id; //data-id
        let name = event.target.dataset.name; //data-name
            var formDelete = document.getElementById('formDelete');
            formDelete.action += '/' + id;
            formDelete.submit();
    }


    //los de id="enlaceBorrar"
    let enlaceBorrar = document.getElementById('enlaceBorrar');
    if (enlaceBorrar) {
        enlaceBorrar.addEventListener('click', getConfirmation);
    }

    function getConfirmation() {
        let id = event.target.dataset.id; //data-id
        let name = event.target.dataset.name; //data-name
            var formDelete = document.getElementById('formDelete');
            formDelete.submit();
    }

})();

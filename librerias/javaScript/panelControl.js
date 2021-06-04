window.onload = function init() {
    fetchComponentes([0]);
    fetchTemplates([0]);
}

function deleteTemplate($id) {
    $.post('index.php', {'accion':'deleteTemplate','id':$id}, (response) => {
        fetchTemplates([0]);
    });
}

function deleteComponent($id) {
    $.post('index.php', {'accion':'deleteComponente','id':$id}, (response) => {
        fetchComponentes([0]);
    });
}

$(document).on('click','.resetComp', (e) => {
    $compId = document.getElementById('hiddenComponenteId').value = "";
});

$(document).on('click','.resetTemp', (e) => {
    $compId = document.getElementById('hiddenTemplateId').value = "";
});

function insertComponent() {
    $name = document.getElementById('nameComponente').value;
    $desc = document.getElementById('descriptionComponente').value;
    $htm = document.getElementById('codeHtmlComponente').value;
    $cs = document.getElementById('codeCssComponente').value;
    $compId = document.getElementById('hiddenComponenteId').value;
    if ($compId === "") {
        $datos = [$name,$desc,$htm,$cs];
        $.post('index.php', {'accion':"insertNewComponent",'id':$datos}, (response) => {
            fetchComponentes([0]);
        });
    } else {
        $datos = [$name,$desc,$htm,$cs,$compId];
        $.post('index.php', {'accion':'updateComponent','id':$datos}, (response) => {
            console.log(response);
            fetchComponentes([0]);
        });
    }
}

function insertTemplate() {
    $name = document.getElementById('nombre').value;
    $desc = document.getElementById('descriptionTemplate').value;
    $htm = document.getElementById('codeHtmlTemplate').value;
    $cs = document.getElementById('codeCssTemplate').value;
    $tempId = document.getElementById('hiddenTemplateId').value;
    if ($tempId === "") {
        $datos = [$name,$desc,$htm,$cs];
        $.post('index.php', {'accion':"insertNewTemplate",'id':$datos}, (response) => {
            fetchTemplates([0]);
        });
    } else {
        $datos = [$name,$desc,$htm,$cs,$tempId];
        $.post('index.php', {'accion':'updateTemplate','id':$datos}, (response) => {
            console.log(response);
            fetchTemplates([0]);
        });
    }
}

function clickTemplate (id){
    $.get('index.php', {'accion':'getTemplate','id':id}, (response) => {
        response = response.replace("[","");
        response = response.replace("]","");
        const data = JSON.parse(response);
        $('#nombre').val(data.name);
        $('#descriptionTemplate').val(data.description);
        $('#hiddenTemplateId').val(data.id);
        $('#codeHtmlTemplate').val(data.htm);
        $('#codeCssTemplate').val(data.cs);
    });
}

function clickComponente(id) {
    $.get('index.php', {'accion':'getComponente','id':id}, (response) => {
        response = response.replace("[","");
        response = response.replace("]","");
        const data = JSON.parse(response);
        $('#nameComponente').val(data.name);
        $('#descriptionComponente').val(data.description);
        $('#hiddenComponenteId').val(data.id);
        $('#codeHtmlComponente').val(data.htm);
        $('#codeCssComponente').val(data.cs);
    });
}


function fetchComponentes($id) {
    $.get('index.php',{'accion':'getListaComponentesAdmin','id':$id},function (plantilla) {
        $('#componentes').html(plantilla);
    });
}

function fetchTemplates($id) {
    $.get('index.php',{'accion':'getListaTemplatesAdmin','id':$id},function (plantilla) {
        $('#templates').html(plantilla);
    });
}


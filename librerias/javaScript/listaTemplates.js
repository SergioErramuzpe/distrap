window.onload = function init() {
    fetchTemplates([0]);

    document.getElementById('1').addEventListener("click", setChecked);
    document.getElementById('2').addEventListener("click", setChecked);
    document.getElementById('3').addEventListener("click", setChecked);
    document.getElementById('4').addEventListener("click", setChecked);
    document.getElementById('5').addEventListener("click", setChecked);
}

function setChecked() {
    $checkedElements = [];
    $counter = 0;
    for ($i = 1; $i<=5; $i++) {
        if (document.getElementById($i).checked) {
            $checkedElements.push($i);
            $counter+=1;
        }
    }
    if ($counter === 0)
        fetchTemplates([0]);
    else
        fetchTemplates($checkedElements);
}


function fetchTemplates($id) {
    $.get('index.php',{'accion':'getTemplatesFiltrados','id':$id},function (plantilla) {
        $('#lista').html(plantilla);
    });
}
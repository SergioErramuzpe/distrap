

window.onload = function init() {

    fetchComponentes([0]);

    document.getElementById('1').addEventListener("click", setChecked);
    document.getElementById('2').addEventListener("click", setChecked);
    document.getElementById('3').addEventListener("click", setChecked);
    document.getElementById('4').addEventListener("click", setChecked);
    document.getElementById('5').addEventListener("click", setChecked);

}



function setChecked()  {
    $checkedElements = [];
    $counter = 0;
    for ($i = 1; $i<=5; $i++) {
        if (document.getElementById($i).checked) {
            $checkedElements.push($i);
            $counter+=1;
        }
    }
    if ($counter === 0)
        fetchComponentes([0]);
    else
        fetchComponentes($checkedElements);
}


function fetchComponentes($id) {
    $.get('index.php',{'accion':'getComponentesFiltrados','id':$id},function (plantilla) {
        $('#lista').html(plantilla);
    });
}



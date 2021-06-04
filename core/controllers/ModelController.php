<?php

include "core/models/Componente.php";
include "core/models/Template.php";

class ModelController
{
    /**
     * @var null
     */
    private static $instance = null;
    private  $db;

    private function __construct (DataBase $db) {
        $this->db = $db;
    }

    public static function getInstance(Database $db)
    {
        if (is_null(self::$instance))
            self::$instance = new self($db);
        return self::$instance;
    }

    function getListaComponentes($componentsId) {
        $listaComponentes = array();
        if ($componentsId == [0])
            $rows = $this->db->getComponents();
        else
            $rows =  $this->db->filtroComponentes($componentsId);
        while ($componente = $rows->fetch_assoc())
            array_push($listaComponentes, new Componente($componente['id'],$componente['name'],$componente['description']));

        return $listaComponentes;
    }

    function getListaTemplates($templatesId) {
        $listaTemplates = array();
        if ($templatesId == [0])
            $rows = $this->db->getTemplates();
        else
            $rows =  $this->db->filtroTemplates($templatesId);
        while ($template = $rows->fetch_assoc())
            array_push($listaTemplates, new Componente($template['id'],$template['name'],$template['description']));

        return $listaTemplates;
    }

    public function getTemplate($id)
    {
        $row =  $this->db->getTemplate($id);
        $template = $row->fetch_assoc();
        return new Template($template['id'],$template['name'],$template['description']);
    }

    public function getComponente($id)
    {

        $row =  $this->db->getComponent($id);
        $componente = $row->fetch_assoc();
        return new Componente($componente['id'],$componente['name'],$componente['description']);
    }

    public function jsonComponentes($idCategoria)
    {
        echo "AntesConsulta";
        $result = $this->db->filtroComponentes($idCategoria);
        echo "dspuesConsulta";
        $json = array();
        while($row = mysqli_fetch_array($result)) {
            echo $row["id"];
            $json[] = array(
                'name' => $row['name'],
                'description' => $row['description'],
                'id' => $row['id']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

    public function jsonTemplate($idCategoria)
    {
        $result = $this->db->filtroTemplates($idCategoria);
        $json = array();
        while($row = mysqli_fetch_array($result)) {
            $json[] = array(
                'name' => $row['name'],
                'description' => $row['description'],
                'id' => $row['id']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

    public function registrarUsuario()
    {
        return $this->db->insertNewUser();
    }

    public function modificarUsuario()
    {
        return $this->db->updateUser();
    }

    public function deleteTemplate($id)
    {
        $resultado = $this->getTemplate($id);
        unlink('./public/templates/'.$resultado->getName().'.html');
        $this->db->deleteTemplate($id);
    }

    public function deleteComponente($id)
    {
        $resultado = $this->getComponente($id);
        unlink('./public/componentes/'.$resultado->getName().'.html');
        $this->db->deleteComponente($id);
    }

    public function sendComponente($id)
    {
        $componente = $this->getComponente($id);
        $name =$componente->getName();
        $desc = $componente->getDescription();
        $fId = $componente->getId();
        $htm =  file_get_contents("./public/components/".$name.".html");
        $cs =  file_get_contents("./public/css/accesible.css");
        $json = array(
            'name' => $name,
            'description' => $desc,
            'id' => $fId,
            'htm' => $htm,
            'cs' => $cs
        );
        echo json_encode($json);
    }

    public function sendTemplate($id)
    {
        $template = $this->getTemplate($id);
        $name =$template->getName();
        $desc = $template->getDescription();
        $fId = $template->getId();
        $htm =  file_get_contents("./public/templates/".$name.".html");
        $cs =  file_get_contents("./public/css/accesible.css");
        $json = array(
            'name' => $name,
            'description' => $desc,
            'id' => $fId,
            'htm' => $htm,
            'cs' => $cs
        );
        echo json_encode($json);
    }

    public function insertNewComponent($id)
    {
        $newcontent = file_get_contents("./public/components/".$id[0].".html");
        $handle = fopen("./public/components/".$id[0].".html",'w+');
        fwrite($handle,$id[2]);
        fclose($handle);
        $handle = fopen("./public/components/accesible.css",'w+');
        fwrite($handle,$id[3]);
        fclose($handle);
        $handle = fopen("./public/css/accesible.css",'w+');
        fwrite($handle,$id[3]);
        fclose($handle);
        $this->db->insertNewComponent($id[0],$id[1]);

    }

    public function insertNewTemplate($id)
    {
        $newcontent = file_get_contents("./public/components/".$id[0].".html");
        $handle = fopen("./public/templates/".$id[0].".html",'w+');
        fwrite($handle,$id[2]);
        fclose($handle);
        $handle = fopen("./public/templates/accesible.css",'w+');
        fwrite($handle,$id[3]);
        fclose($handle);
        $handle = fopen("./public/css/accesible.css",'w+');
        fwrite($handle,$id[3]);
        fclose($handle);
        $this->db->insertNewTemplate($id[0],$id[1]);
    }

    public function updateComponent($id)
    {
        $handle = fopen("./public/components/".$id[0].".html",'w+');
        fwrite($handle,$id[2]);
        fclose($handle);
        $handle = fopen("./public/components/accesible.css",'w+');
        fwrite($handle,$id[3]);
        fclose($handle);
        $handle = fopen("./public/css/accesible.css",'w+');
        fwrite($handle,$id[3]);
        fclose($handle);
        $this->db->updateComponent($id[0],$id[1],$id[4]);

    }

    public function updateTemplate($id)
    {
        $handle = fopen("./public/templates/".$id[0].".html",'w+');
        fwrite($handle,$id[2]);
        fclose($handle);
        $handle = fopen("./public/templates/accesible.css",'w+');
        fwrite($handle,$id[3]);
        fclose($handle);
        $handle = fopen("./public/css/accesible.css",'w+');
        fwrite($handle,$id[3]);
        fclose($handle);
        $this->db->updateTemplate($id[0],$id[1],$id[4]);
    }


}

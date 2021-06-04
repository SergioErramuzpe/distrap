<?php
class DataBase
{
    private static $instance = NULL;
    private $conexion;

    private function __construct($params) {
        $this->conexion = mysqli_connect($params[0],$params[1],$params[2],$params[3]);
        if (!$this->conexion)
            echo "Error de conexion";
    }

    public static function getInstance($params) {
        if (is_null(self::$instance))
            self::$instance = new self($params);
        return self::$instance;
    }

    public function getComponents() {
        $consultaSql="select * from components";
        if ($resultado = $this->conexion->query($consultaSql))
            return $resultado;
        else
            return -1;
    }

    public function getTemplates() {
        $consultaSql="select * from templates";
        if ($resultado = $this->conexion->query($consultaSql))
            return $resultado;
        else
            return -1;
    }

    public function getComponent($id) {
        $consultaSql="select * from components where id='$id'";
        $resultado = $this->conexion->query($consultaSql);
        if ($resultado != null) {
            return $resultado;
        }
        return -1;
    }
    public function getTemplate($id)
    {
        $consultaSql="select * from templates where id='$id'";
        $resultado = $this->conexion->query($consultaSql);
        if ($resultado != null) {
            return $resultado;
        }
        return -1;
    }

    public function getLogedParams() {
        $email = $_POST['email'];
        $pass = md5($_POST['pass']);
        $consultaSql="select * from users where email='$email' and password='$pass'";
        $resultado = $this->conexion->query($consultaSql);
        return $resultado;
    }

    public function getLoged () {
        if (($_POST['email'] != '') && ($_POST['pass'])) {
            $email = $_POST['email'];
            $pass = md5($_POST['pass']);
            $consultaSql="select * from users where email='$email' and password='$pass'";
            $resultado = $this->conexion->query($consultaSql);
            if ($resultado->fetch_row() == null) {
                return -1;
            }
            return 0;
        }
        return -2;
    }

    /*Programar bien las consultas*/
    public function insertNewUser()
    {
        if (($_POST["email"] != "") && ($_POST["pass"] != "") && ($_POST["nombre"] != "")) {
            $resultado = $this->getLoged();
            if ($resultado < 0) {
                $email = $_POST["email"];
                $name = $_POST["nombre"];
                $pass = md5($_POST["pass"]);
                $consultaSql = "insert into users (id, name, email, password, isAdmin) values (null,'$email', '$name','$pass',0)";
                $resultado = $this->conexion->query($consultaSql);
                if ($resultado == true) {
                    return 0;
                }
                return -1;

            }
        }
        return -2;
    }

    /*Estas dos funciones devuelven las plantillas y componentes
      filtradas por un id de categoria*/
    public function filtroTemplates($idDisabilities) {

        $consultaSql = "select t.id,t.name, t.description from  templates t, disabilities_templates d where t.id=d.disability_id and d.disability_id=$idDisabilities[0] ";
        if (sizeof($idDisabilities) > 1) {
            for ($i = 1; $i < sizeof($idDisabilities); $i++) {
                $consultaSql .= "or d.disability_id=$idDisabilities[$i] ";
            }
        }
        $resultado = $this->conexion->query($consultaSql);
        return $resultado;

    }


    public function filtroComponentes($idDisabilities)
    {
            $consultaSql = "select t.id,t.name,t.description from  components t, disabilities_components d where t.id=d.disability_id and d.disability_id=$idDisabilities[0] ";
            if (sizeof($idDisabilities) > 1) {
                for ($i = 1; $i < sizeof($idDisabilities); $i++) {
                    $consultaSql .= "or d.disability_id=$idDisabilities[$i] ";
                }
            }
            if ($resultado = $this->conexion->query($consultaSql))
                return $resultado;
            return "";

    }




    /*Programar bien las consultas*/
    public function updateUser() {
        if (($_POST["pass"] != "") || ($_POST["nombre"] != "")) {
            $consultaSql = "update users set ";
            if ($_POST["pass"] != "") {
                $consultaSql .= "password = '".md5($_POST["pass"])."'";
                if ($_POST["nombre"] != "")
                    $consultaSql .= ", name = '".$_POST["nombre"]."'";
            } elseif ($_POST["nombre"] != ""){
                $consultaSql .= " name = '".$_POST["nombre"]."'";
            }
            $consultaSql .= " where id = '".$_SESSION['id']."'";
            $resultado = $this->conexion->query($consultaSql);
            if ($resultado)
                return 0;
            return -1;

        } else {
            return -2;
        }
    }

    public function deleteComponente($id)
    {
        $consulta = "delete from components where id='$id'";
        return $this->conexion->query($consulta);
    }

    public function deleteTemplate($id)
    {
        $consulta = "delete from templates where id='$id'";
        return $this->conexion->query($consulta);
    }

    public function updateComponent($name, $desc, $id)
    {
        $consultaSql = "UPDATE `components` SET `name` = '$name', `description` = '$desc' WHERE `components`.`id` = '$id';";
        $this->conexion->query($consultaSql);

    }

    public function insertNewTemplate($name, $desc)
    {
        $consultaSql = "insert into templates (id, name, description) values (null,'$name', '$desc')";
        $this->conexion->query($consultaSql);
    }

    public function updateTemplate($name, $desc, $id)
    {
        $consultaSql = "UPDATE `templates` SET `name` = '$name', `description` = '$desc' WHERE `templates`.`id` = $id";
        $this->conexion->query($consultaSql);
    }


    public function insertNewComponent($name, $desc)
    {
        $consultaSql = "insert into components (id, name, description) values (null,'$name', '$desc')";
        $this->conexion->query($consultaSql);
    }
}
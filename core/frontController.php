<?php

    if (isset($_GET["accion"])) {
        $accion = $_GET["accion"];
    } else {
        if (isset($_POST["accion"])) {
            $accion = $_POST["accion"];
        } else {
            $accion = "bienvenida";
        }
    }

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    } else {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
        } else {
            $id = 1;
        }
    }

    if (!isset($db)) {
        require_once "./core/models/DataBase.php";
        require_once "core/controllers/ModelController.php";
        require_once "core/controllers/ViewController.php";
        require_once "core/controllers/SessionController.php";
		$db = DataBase::getInstance(["eim-srv-mysql", "iw21_erramuzpes", "7dJnoSF2020", "iw21_db_erramuzpes"]);     
	    $sc = SessionController::getInstance($db);
        $vc = ViewController::getInstance($sc);
        $mc = ModelController::getInstance($db);
    }


	switch ($accion) {
        case "bienvenida": //Portada de la web con el mensaje de bienvenida e instrucciones
            $vc->renderBienvenida();
            break;
        case "listaComponentes": //Cuando se hace click en componentes en el header (y sale la lista de componentes)
            $vc->renderListaComponentes();
            break;
        case "listaTemplates": //Cuando se hace click en componentes en el header (y sale la lista de templates)
            $vc->renderListaTemplates();
            break;
        case "componente": //Cuando se hace click en un componente y expone el template con codigo y descripcion
            $vc->renderComponente($mc->getComponente($id));
            break;
        case "template": //Cuando se hace click en un template y expone el template con codigo y descripcion
            $vc->renderTemplate($mc->getTemplate($id));
            break;
        case "login": //Cuando se hace click en el boton de login del header
            $vc->renderLogin();
            break;
        case "registro": //Cuando se hace click en el boton de registro del header
            $vc->renderRegistro();
            break;
        case "registrarse": //Cuando se hace click en registrarse en la pantalla de registro
            $vc->renderRegistrado($mc->registrarUsuario());
            break;
        case "logearse": //Cuando se hace click en entrar en la pantalla de login
            $vc->renderLogeado($sc->loginTry());
            break;
        case "logout": //Cuando termina la session un usuario/admin
            $sc->logout();
            $vc->renderBienvenida();
            break;
        case "perfil": //Cuando un usuario/admin está con sessionUp y entra en su perfil
            $vc->renderPerfil();
            break;
        case "modificar": //Cuando el usuario hace click en modificar su perfil
            $vc->renderModificado($mc->modificarUsuario());
            break;

            /*Peticiones AJAX*/
        case "getComponentesFiltrados": //Cuando el usuario hace click en modificar su perfil
            $vc->sendComponentesFiltrados($mc->getListaComponentes($id));
            break;
        case "getTemplatesFiltrados": //Cuando el usuario hace click en modificar su perfil
            $vc->sendTemplatesFiltrados($mc->getListaTemplates($id));
            break;
        case "getListaComponentesAdmin": //Cuando el usuario hace click en modificar su perfil
            $vc->sendListaComponentes($mc->getListaComponentes($id));
            break;
        case "getListaTemplatesAdmin": //Cuando el usuario hace click en modificar su perfil
            $vc->sendListaTemplates($mc->getListaTemplates($id));
            break;
        case "deleteComponente":
            $mc->deleteComponente($id);
            break;
        case "deleteTemplate":
            $mc->deleteTemplate($id);
            break;
        case "getComponente":
            $mc->sendComponente($id);
            break;
        case "getTemplate":
            $mc->sendTemplate($id);
            break;
        case "insertNewComponent":
            $mc->insertNewComponent($id);
            break;
        case "updateComponent":
            $mc->updateComponent($id);
            break;
        case "insertNewTemplate":
            $mc->insertNewTemplate($id);
            break;
        case "updateTemplate":
            $mc->updateTemplate($id);
            break;
    }


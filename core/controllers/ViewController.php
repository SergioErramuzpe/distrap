<?php

include "core/views/View.php";

class ViewController
{

    /**
     * @var null
     */
    private static $instance;
    private  $view;
    private  $sc;

    private function __construct ($sc) {
        $this->sc = $sc;
        $this->view = new View($sc);
    }

    public static function getInstance($sc)
    {
        if (is_null(self::$instance))
            self::$instance = new self($sc);
        return self::$instance;
    }


    public function renderBienvenida() {
        echo $this->view->render([$this->view->getHeader(),$this->view->montarMensajeBienvenida()]);
    }

    public function renderListaComponentes() {
        echo $this->view->render([$this->view->getHeader(),$this->view->montarSidebarComponentes()]);
    }

    public function renderListaTemplates()
    {
        echo $this->view->render([$this->view->getHeader(),$this->view->montarSidebarTemplates()]);
    }

    public function renderLogin()
    {
        echo $this->view->render([$this->view->getHeader(),$this->view->getHtml("login.html")]);
    }

    public function renderRegistro()
    {
        echo $this->view->render([$this->view->getHeader(),$this->view->getHtml("registro.html")]);
    }

    public function renderLogeado($loginStatus)
    {
        switch ($loginStatus) {
            case 0:
                echo $this->view->render([$this->view->getHeader(),$this->view->getHtml("mensajeBienvenida.html")]);
                break;
            case -1:
                echo $this->view->render([$this->view->getHeader(),$this->view->getHtml("login.html"),$this->view->getHtml("errorLoginParametros.html")]);
                break;

            default:
                echo $this->view->render([$this->view->getHeader(),$this->view->getHtml("login.html"),$this->view->getHtml("errorLoginVacio.html")]);
                break;
        }

    }

    public function renderRegistrado($registerStatus)
    {
        switch ($registerStatus) {
            case 0:
                echo $this->view->render([$this->view->getHeader(),$this->view->getHtml("registro.html"),$this->view->getHtml("registroOk.html")]);
                break;
            case -1:
                echo $this->view->render([$this->view->getHeader(),$this->view->getHtml("registro.html"),$this->view->getHtml("errorRegistroParametros.html")]);
                break;
            default:
                echo $this->view->render([$this->view->getHeader(),$this->view->getHtml("registro.html"),$this->view->getHtml("vacio.html")]);
                break;
        }
    }

    public function renderModificado($modifiedStatus)
    {
        switch ($modifiedStatus) {
            case 0:
                echo $this->view->render([$this->view->getHeader(),$this->view->getPerfil(),$this->view->getHtml("registroOk.html")]);
                break;
            case -1:
                echo $this->view->render([$this->view->getHeader(),$this->view->getPerfil(),$this->view->getHtml("errorRegistroParametros.html")]);
                break;
            default:
                echo $this->view->render([$this->view->getHeader(),$this->view->getPerfil(),$this->view->getHtml("errorPerfilUsuarioVacio.html")]);
                break;
        }
    }


    public function renderPerfil()
    {
        echo $this->view->render([$this->view->getHeader(),$this->view->getPerfil()]);
    }


    public function renderComponente($componente) {
        echo $this->view->render([$this->view->getHeader(),$this->view->montarComponente($componente)]);
    }

    public function renderTemplate($template)
    {
        echo $this->view->render([$this->view->getHeader(),$this->view->montarTemplate($template)]);
    }

    public function sendComponentesFiltrados($array)
    {
        echo $this->view->montarListaComponentes($array);
    }

    public function sendTemplatesFiltrados($array)
    {
        echo $this->view->montarListaTemplates($array);
    }

    public function sendListaComponentes($array)
    {
        echo $this->view->montarListaComponentesAdmin($array);
    }

    public function sendListaTemplates($array)
    {
        echo $this->view->montarListaTemplatesAdmin($array);
    }


}

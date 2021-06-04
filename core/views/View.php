<?php

class View
{
    private  $sc;

    public function __construct ($sc) {
        $this->sc = $sc;
    }

    function render($nombresComponentes) : string {
        $nombreEtiqueta = "##separador##";
        $cabecera = file_get_contents("./core/views/templates/index.html");
        $trozos = explode($nombreEtiqueta,$cabecera);
        $cuerpo = "";
        $cuerpo .= $trozos[0];
        for ($i = 0; $i<sizeof($nombresComponentes); $i++) {
            $aux = $nombresComponentes[$i];
            $cuerpo .= $aux;
            if ($i === 0) {
                $cuerpo .= "<main class = container><p>
				<pre>
				</pre>
			   </p>";
            }
        }
        $cuerpo .= $trozos[sizeof($trozos)-1];
        return $cuerpo;
    }

    function montarListaComponentes ($listaComponentes) {
        $unaPortada =  $this->getHtml("portadaComponente.html");
        $conjuntoPortadas = "";
        $portadaAux = $unaPortada;
        foreach ($listaComponentes as $comp) {
            $portadaAux = str_replace("##nombre##", $comp->getName(), $portadaAux);
            $portadaAux = str_replace("##idComponente##", $comp->getId(), $portadaAux);
            $conjuntoPortadas .= $portadaAux;
            $portadaAux = $unaPortada;
        }
        return $conjuntoPortadas;
    }

    function montarListaTemplates ($listaTemplates) {
        $unaPortada =  $this->getHtml("portadaPlantilla.html");
        $conjuntoPortadas = "";
        $portadaAux = $unaPortada;
        foreach ($listaTemplates as $template) {
            $portadaAux = str_replace("##nombre##", $template->getName(), $portadaAux);
            $portadaAux = str_replace("##idTemplate##", $template->getId(), $portadaAux);
            $conjuntoPortadas .= $portadaAux;
            $portadaAux = $unaPortada;
        }
        return $conjuntoPortadas;
    }

    function getPerfil() {
        if ($this->sc->isAdmin()) {
            $perfil = $this->getHtml("panelControl.html");
        } else {
            $perfil = $this->getHtml("perfilUsuario.html");
            $perfil = str_replace("##nombre##", $this->sc->getName(), $perfil);
            $perfil = str_replace("##email##",$this->sc->getEmail() , $perfil);
            $perfil = str_replace("##id##",$this->sc->getId() , $perfil);
        }
        return $perfil;
    }

    function getHeader () {
        $header = $this->getHtml("header.html");
        if ($this->sc->getSession())
            $header = str_replace("##perfilMenu##", file_get_contents("./core/views/templates/loged.html"), $header);
        else
            $header = str_replace("##perfilMenu##", file_get_contents("./core/views/templates/anonymus.html"), $header);
        return $header;
    }

    function montarMensajeBienvenida ()
    {
        $mensaje = $this->getHtml("mensajeBienvenida.html");
        if ($this->sc->getSession()) {
            $mensaje = str_replace("##enlace##", "./public/css/accesible.css", $mensaje);
            $mensaje = str_replace("##enlace1##", "accesible.css", $mensaje);
            $mensaje = str_replace("##tipo##", "", $mensaje);
        }  else {
            $mensaje = str_replace("##enlace##", "", $mensaje);
            $mensaje = str_replace("##enlace1##", "", $mensaje);
            $mensaje = str_replace("##tipo##", "hidden", $mensaje);
        }
        return $mensaje;
    }

    public function getHtml($name) {
        return file_get_contents("./core/views/templates/".$name);
    }

    /*No esta completa*/
    public function montarComponente($componente)
    {
        $unaPortada =  $this->getHtml("componente.html");
        $unaPortada = str_replace("##nombre##", $componente->getName(), $unaPortada);
        $unaPortada = str_replace("##desc##", $componente->getDescription(), $unaPortada);
        if ($this->sc->getSession()) {
            $unaPortada = str_replace("##enlace##", "./public/components/".$componente->getName().".html", $unaPortada);
            $unaPortada = str_replace("##enlace1##", $componente->getName().".html", $unaPortada);
            $unaPortada = str_replace("##tipo##", "", $unaPortada);
        }  else {
            $unaPortada = str_replace("##enlace##", "", $unaPortada);
            $unaPortada = str_replace("##enlace1##", "", $unaPortada);
            $unaPortada = str_replace("##tipo##", "hidden", $unaPortada);
        }
        return $unaPortada;
    }
    public function montarTemplate($template)
    {
        $unaPortada =  $this->getHtml("template.html");
        $unaPortada = str_replace("##nombre##", $template->getName(), $unaPortada);
        $unaPortada = str_replace("##desc##", $template->getDescription(), $unaPortada);
        if ($this->sc->getSession()) {
            $unaPortada = str_replace("##enlace##", "./public/templates/".$template->getName().".html", $unaPortada);
            $unaPortada = str_replace("##enlace1##", $template->getName().".html", $unaPortada);
            $unaPortada = str_replace("##tipo##", "", $unaPortada);
        }  else {
            $unaPortada = str_replace("##enlace##", "", $unaPortada);
            $unaPortada = str_replace("##enlace1##", "", $unaPortada);
            $unaPortada = str_replace("##tipo##", "hidden", $unaPortada);
        }
        return $unaPortada;
    }

    public function montarSidebarComponentes()
    {
        $unaPortada = $this->getHtml("sidebar.html");
        $unaPortada = str_replace("##js##", "listaComponentes", $unaPortada);
        return $unaPortada;
    }

    public function montarSidebarTemplates()
    {
        $unaPortada = $this->getHtml("sidebar.html");
        $unaPortada = str_replace("##js##", "listaTemplates", $unaPortada);
        return $unaPortada;
    }

    public function montarListaComponentesAdmin($listaComponentes)
    {
        $unaPortada =  $this->getHtml("listaComponentesAdmin.html");
        $conjuntoPortadas = "";
        $portadaAux = $unaPortada;
        foreach ($listaComponentes as $comp) {
            $portadaAux = str_replace("##nombre##", $comp->getName(), $portadaAux);
            $portadaAux = str_replace("##idComponente##", $comp->getId(), $portadaAux);
            $conjuntoPortadas .= $portadaAux;
            $portadaAux = $unaPortada;
        }
        return $conjuntoPortadas;
    }

    public function montarListaTemplatesAdmin($listaTemplates)
    {
        $unaPortada =  $this->getHtml("listaTemplatesAdmin.html");
        $conjuntoPortadas = "";
        $portadaAux = $unaPortada;
        foreach ($listaTemplates as $comp) {
            $portadaAux = str_replace("##nombre##", $comp->getName(), $portadaAux);
            $portadaAux = str_replace("##idTemplate##", $comp->getId(), $portadaAux);
            $conjuntoPortadas .= $portadaAux;
            $portadaAux = $unaPortada;
        }
        return $conjuntoPortadas;
    }


}

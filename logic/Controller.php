<?php
namespace Controllers;

class Controller{
    public function render($view, $params = []){
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);

        return str_replace('{{content}}', $viewContent, $layoutContent);
        
    }

    public function layoutContent(){
        ob_start();
        include_once __DIR__."/../resources/views/layouts/main.phtml";
        return ob_get_clean();
    }

    public function renderOnlyView($view){
        ob_start();
        include_once __DIR__."/../resources/views/$view.phtml";
        return ob_get_clean();
    }
}
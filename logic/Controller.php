<?php
namespace Controllers;

class Controller{
    public function render($view, $params = [], $layout = 'main'){
        

        $layoutContent = $this->layoutContent($layout);
        $viewContent = $this->renderOnlyView($view, $params);

        return str_replace('{{content}}', $viewContent, $layoutContent);
        
    }

    public function layoutContent($layout){
        ob_start();
        include_once __DIR__."/../resources/views/layouts/$layout.phtml";
        return ob_get_clean();
    }

    public function renderOnlyView($view, $params=[]){
        ob_start();
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        include_once __DIR__."/../resources/views/$view.phtml";
        return ob_get_clean();
    }
}
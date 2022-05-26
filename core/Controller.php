<?php
namespace app\core;

class Controller{
    public function render($view, $params = [], $layout = 'main'){
        $layout = $this->layoutContent($layout);

        $constants = [
            '{{content}}' => $this->renderOnlyView($view, $params),
            '{{root}}' => Application::$ROOT_DIR
        ];

        foreach ($constants as $constant => $value) {
            $layout = str_replace($constant, $value, $layout);
        }

        return $layout;
    }

    public function layoutContent($layout){
        ob_start();
        include_once Application::$ROOT_DIR."/resources/views/layouts/$layout.phtml";
        return ob_get_clean();
    }

    public function renderOnlyView($view, $params=[]){
        ob_start();
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        include_once Application::$ROOT_DIR."/resources/views/$view.phtml";
        return ob_get_clean();
    }
}
<?php

namespace Lune\View;

class LuneViewEngine implements ViewEngine {
    protected string $viewsDirectory;

    public function __construct(string $viewsDirectory) {
        $this->viewsDirectory = $viewsDirectory;
    }

    public function render(string $view): string {
        $phpFile = "{$this->viewsDirectory}/{$view}.php";
        ob_start();
        require $phpFile;
        return ob_get_clean();
    }
}

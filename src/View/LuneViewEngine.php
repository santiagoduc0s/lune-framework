<?php

namespace Lune\View;

class LuneViewEngine implements ViewEngine {
    protected string $viewsDirectory;
    protected string $defaultLayout = 'main';
    protected string $contentAnnotation = '@content';

    public function __construct(string $viewsDirectory) {
        $this->viewsDirectory = $viewsDirectory;
    }

    public function render(string $view, array $params = [], string $layout = null): string {
        $layoutContent = $this->renderLayout($layout ?? $this->defaultLayout);
        $viewContent = $this->renderView($view, $params);
        return str_replace($this->contentAnnotation, $viewContent, $layoutContent);
    }

    public function renderView(string $view, array $params): string {
        $phpFile = "{$this->viewsDirectory}/{$view}.php";
        return $this->phpFileOutput($phpFile, $params);
    }

    public function renderLayout(string $view): string {
        $phpFile = "{$this->viewsDirectory}/layouts/{$view}.php";
        return $this->phpFileOutput($phpFile);
    }

    public function phpFileOutput(string $phpFile, array $params = []): string {
        ob_start();
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        require $phpFile;
        return ob_get_clean();
    }
}

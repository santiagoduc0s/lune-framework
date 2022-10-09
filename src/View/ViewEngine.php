<?php

namespace Lune\View;

interface ViewEngine {
    public function render(string $view, array $params = [], string $layout = null): string;
}

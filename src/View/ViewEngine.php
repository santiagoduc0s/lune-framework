<?php

namespace Lune\View;

interface ViewEngine {
    public function render(string $view): string;
}

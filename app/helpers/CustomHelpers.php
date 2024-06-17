<?php

use Illuminate\Support\Facades\File;

if (!function_exists('loadCSSFrom')) {
    function loadCSSFrom($path)
    {
        $fullPath = public_path($path);
        $cssFiles = File::files($fullPath);
        $cssContent = '';

        foreach ($cssFiles as $file) {
            $filename = $file->getFilename();
            if (pathinfo($filename, PATHINFO_EXTENSION) == 'css') {
                $cssContent .= file_get_contents($fullPath . '/' . $filename);
            }
        }

        return $cssContent;
    }
}

<?php

ob_start();
session_start();
require __DIR__ . '/generic.php';

spl_autoload_register(function($classname) {
    require __DIR__ . "/$classname.php";
});


register_shutdown_function(function() {
    if (Theme::$template != null) {
        $content = ob_get_clean();
        include __DIR__ . '/../template/' . Theme::$template;
    }
});

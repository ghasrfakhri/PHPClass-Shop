<?php

class FlashMessage {

    const TYPE_INFO = 'info';
    const TYPE_WARNING = 'warning';
    const TYPE_ERROR = 'error';

    static public function add($message, $type) {
        if (!isset($_SESSION['flash-message'])) {
            $_SESSION['flash-message'] = [];
        }
        if (!isset($_SESSION['flash-message'][$type])) {
            $_SESSION['flash-message'][$type] = [];
        }

        $_SESSION['flash-message'][$type][] = $message;
    }

    static public function getMessages($type) {
        if (isset($_SESSION['flash-message']) && $_SESSION['flash-message'][$type]) {
            $messages = $_SESSION['flash-message'][$type];
            $_SESSION['flash-message'][$type] = [];
            return $messages;
        } else {
            return [];
        }
    }

}

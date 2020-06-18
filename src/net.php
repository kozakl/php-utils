<?php
namespace kozakl\utils\net;

function isLocalhost() {
    return in_array(
        $_SERVER['REMOTE_ADDR'],
        ['127.0.0.1', '::1']
    );
}

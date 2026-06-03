<?php
// includes/functions.php
function base_url($path = '') {
    return 'http://localhost/spk-vikor-bansos/' . ltrim($path, '/');
}

function redirect($path) {
    header("Location: " . base_url($path));
    exit;
}

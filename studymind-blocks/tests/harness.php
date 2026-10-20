<?php
// Minimal WordPress stubs so render.php templates can run outside WordPress for screenshot tests.
define('ABSPATH', '/');
define('SM_BLOCKS_DIR', dirname(__DIR__) . '/');
define('SM_BLOCKS_URL', 'file://' . dirname(__DIR__) . '/');
define('SM_BLOCKS_VERSION', 'test');
function get_field($n, $p = false) { global $SM_FIELDS; return $SM_FIELDS[$n] ?? null; }
function esc_html($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function esc_attr($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function esc_url($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function esc_attr__($s, $d = '') { return esc_attr($s); }
function home_url($p = '') { return 'https://example.test' . $p; }
function wp_json_encode($d, $f = 0) { return json_encode($d, $f); }
function wp_parse_url($u, $c = -1) { return parse_url($u, $c); }
function untrailingslashit($s) { return rtrim($s, '/\\'); }
function wp_unslash($s) { return $s; }
function wp_enqueue_script(...$a) {}
function do_shortcode($s) { return $s; }
function wp_get_attachment_image_url($id, $s) { return ''; }
function add_action(...$a) {} function add_filter(...$a) {}
function current_user_can($c) { return false; }
require SM_BLOCKS_DIR . 'inc/helpers.php';
require SM_BLOCKS_DIR . 'inc/chrome.php';
$SM_FIELDS = getenv("SM_FIELDS") ? json_decode(getenv("SM_FIELDS"), true) : array();
$_SERVER['REQUEST_URI'] = $argv[2] ?? '/';
$name = $argv[1];
$block = array('name' => 'sm/' . $name);
ob_start();
include SM_BLOCKS_DIR . "blocks/$name/render.php";
echo ob_get_clean();

<?php

function html($str, $lang_flag = ENT_HTML5)
{
  return htmlspecialchars($str, ENT_QUOTES | $lang_flag);
}

function debug()
{
  ob_start();
  $args = func_get_args();
  $num_args = count($args);
  if (!$num_args)
    die("<pre><b>No arguments passed to debug()!</b></pre>");

  $output = [];
  $die = $args[0] !== "NO_DIE";
  if (!$die) {
    array_shift($args);
    --$num_args;
  }

  // Loop through arguments
  foreach ($args as $i => $arg) {
    $var_log_msg = "<pre><b>" . ($num_args > 1 ? "Argument <i>" . ($i + 1) . "</i> of <i>$num_args</i><br>" : "") . "Type: <i>(" . gettype($arg) . ")</i></b><br>";
    if (is_bool($arg))
      $var_log_msg .= $arg ? "TRUE" : "FALSE";
    else
      $var_log_msg .= html(print_r($arg, 1));
    $var_log_msg .= "</pre>";
    $output[] = $var_log_msg;
  }
  if ($die)
    $output[] = "<pre><b>Ending script execution</b></pre>";
  else
    $output[] = "<pre><b>NO_DIE passed as the first argument to debug(); continuing execution now</b></pre>";

  echo "
			<div style='border:2px dashed red;margin:20px 0;padding:0 10px'>
				<pre style='font-size:18px;font-weight:bold'>debug() output beginning:</pre>
				<hr>
				" . implode("<hr>", $output) . "
				<hr>
				<pre style='font-size:18px;font-weight:bold'>Stack trace:</pre>
				<pre>";
  debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
  echo "
				</pre>
			</div>
		";

  $output = ob_get_clean();
  if (php_sapi_name() === 'cli') {
    $output = strip_tags($output);
  }

  echo $output;
  if ($die)
    die;
}

function redirect($url = false)
{
  header("Location: " . ($url ?: $_SERVER['REDIRECT_URL']));
  die;
}


function print_json($arr)
{
  header("Content-type: application/json");
  echo json_encode($arr, JSON_UNESCAPED_SLASHES);
  die;
}

function cors()
{
  // Allow from any origin
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: $_SERVER[HTTP_ORIGIN]");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
  }

  // Access-Control headers are received during OPTIONS requests
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
      // may also be using PUT, PATCH, HEAD etc
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
      header("Access-Control-Allow-Headers: $_SERVER[HTTP_ACCESS_CONTROL_REQUEST_HEADERS]");

    die;
  }
}


<?php
// Einfache .env-Ladefunktion: KEY=VALUE je Zeile
// Nutzung: $val = env('DB_HOST', 'localhost');

if (!function_exists('env')) {
	function env($key, $default = null) {
		static $vars = null;
		if ($vars === null) {
			$vars = array();
			$envFile = __DIR__ . '/../.env';
			if (file_exists($envFile) && is_readable($envFile)) {
				$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
				foreach ($lines as $line) {
					if (strpos(trim($line), '#') === 0) { continue; }
					$pos = strpos($line, '=');
					if ($pos === false) { continue; }
					$keyName = trim(substr($line, 0, $pos));
					$val = trim(substr($line, $pos + 1));
					$val = trim($val, "\"' ");
					$vars[$keyName] = $val;
				}
			}
		}
		return array_key_exists($key, $vars) ? $vars[$key] : $default;
	}
}



<?php

use Curl\Curl;

function is_vite_dev()
{
	$curl = new Curl();
	$curl->get('http://localhost:5173');
	if ($curl->error) {
		$curl->close();
		return false;
	} else {
		$curl->close();
		return true;
	}
}

function render_vite_dev_assets()
{
	echo '<script type="module">
import RefreshRuntime from "/@react-refresh"
RefreshRuntime.injectIntoGlobalHook(window)
window.$RefreshReg$ = () => {}
window.$RefreshSig$ = () => (type) => type
window.__vite_plugin_react_preamble_installed__ = true
</script> <script type="module" src="/@vite/client"></script>';
}

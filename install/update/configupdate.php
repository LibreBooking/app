<?php

require('../../config/config.php');
$old = $conf;
unset($conf);

require('config.php');

echo "<pre>";
foreach ($conf as $key => $val) {
	foreach ($conf[$key] as $sub => $setting) {
		if (isset($old[$key][$sub])) {
			echo "\$conf[$key][$sub] = ";
			if (is_array($setting)) {
				printConfigArray($setting);
			}
			else {
				printConfigValue($old[$key][$sub]);
			}
		}
		
		//echo "<pre>conf['$key']['$sub'] = '$setting';</pre>";
	}
}

echo "</pre>";

function printConfigValue($value) {
	
	echo "'$value';\n";
}

function printConfigArray($setting) {
	foreach ($setting as $idx => $val) {
		if (is_array($val)) {
			printConfigArray($val);
		}
		else {
			echo "'$val',";
			//printConfigValue($val);
		}
	}
}
//$old_fp = fopen('../../config/config.php', 'r');
//$new_fp = fopen('config.php', 'r');

//$new = file_get_contents('config.php');

$matches = array();

/*
echo '<pre>';
while (!feof($new_fp)) {
	$line = fgets($new_fp);
	foreach ($old as $key => $val) {
		foreach ($old[$key] as $sub => $setting) {
		if (!is_array($setting)) {
			//$result = preg_replace("/^[\$]conf\['$key'\]\['$sub'\][ \t]+=[ \t]+'?[\w\d]+'?/", "\$conf['$key']['$sub'] = 
			//if (strpos($new, "conf['$key']['$sub']") !== false) {
			//	echo "setting old value conf['$key']['$sub']\n";
			//}
			//echo "<pre>conf['$key']['$sub'] = '$setting';</pre>";
			
	
				if (preg_match("/^[\$]conf\['$key']\['$sub']* /i", $line, $matches)) {
					echo "--- $line";
				
					list($setting, $value) = split('=', $line);
					//$setting = preg_replace("/[ \t]+$/", "", $setting);
					//$value = preg_replace("/^[ \t]+/", "", $value);
					echo "$setting = $value";
					//print_r($matches);
				}
			}
		}
	}
}
*/
/*
while (!feof($new_fp)) {
	$line = fgets($new_fp);
	//echo $line;
	if (preg_match("/^[\$]conf.* /i", $line, $matches)) {
		list($setting, $value) = split('=', $line);
		$setting = preg_replace("/[ \t]+$/", "", $setting);
		$value = preg_replace("/^[ \t]+/", "", $value);
		echo "$setting = $value";
		//print_r($matches);
	}
}
*/

echo '</pre>';

/*
include_once('../../config/config.php');

foreach ($conf as $key => $val) {
	foreach ($conf[$key] as $sub => $setting) {
		if (strpos($new, "conf['$key']['$sub']") !== false) {
			
		}
		//echo "<pre>conf['$key']['$sub'] = '$setting';</pre>";
	}
}
*/
?>

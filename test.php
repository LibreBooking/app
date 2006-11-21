<?php
$q = preg_split('/\@[\w\d]+/', "SELECT * FROM sometable WHERE col1 = @parm1 AND col2 = @parm2 AND col3 = @parm3");	

echo '<pre>';
print_r($q);
echo '</pre>';

$parms = array ( 
				array('@parm1' => 'val1'), 
				array('@parm2' => 'val2'), 
				array('@parm3' => 'val3')
				);

// Get index of parameter
// Get number of @'s after index
ereg('', '', )
?>
<?php
/**
 * To update is_email.php from meta.xml
 *
 * If you make changes to meta.xml then this script will regenerate
 * is_email using the new data.
 */
define('ID', 'id');

/*.string.*/ function replace(/*.string.*/ $php, /*.string.*/ $token, /*.string.*/ $generated) {
	$count		= 0;
	$search		= "|/\\*:$token start:\\*/.*?/\\*:$token end:\\*/|s";
	$replace	= <<<PHP
/*:$token start:*/
// This part of the code is generated using data from test/meta.xml. Beware of making manual alterations
$generated// End of generated code
/*:$token end:*/
PHP;

	$php = preg_replace($search, $replace, $php, -1, $count);
	echo "Replaced $count code blocks of type '$token'<br/>";
	return $php;
}

// Strings to insert into PHP scripts
$constants_categories_define	= '';
$constants_diagnoses_define	= '';

$prior_category			= '';
$categories			= array();

$document = new DOMDocument;
$document->load('../test/meta.xml');

$sections = $document->getElementsByTagName('meta')->item(0)->childNodes;

// Loop through sections
foreach ($sections as $node) {
	if ($node->nodeType === XML_ELEMENT_NODE) {
		$section	= /*.(DOMElement).*/ $node;
//		$section_id	= ($section->hasAttribute(ID)) ? $section->getAttribute(ID) : '';
		$section_id	= $node->nodeName;
		echo "Processing $section_id<br/>";
		$php		= "\t// $section_id\r\n";

		switch($section_id) {
			case 'Categories':
				$constants_categories_define	.= $php;
				break;
			case 'Diagnoses':
				$constants_diagnoses_define	.= $php;
				break;
			default:
		}

		// Loop through items
		$items		= $section->getElementsByTagName('item');

		foreach ($items as $node) {
			if ($node->nodeType === XML_ELEMENT_NODE) {
				$item		= /*.(DOMElement).*/ $node;
				$item_id	= ($item->hasAttribute(ID)) ? $item->getAttribute(ID) : '';

				// Loop through elements
				$nodes		= $item->childNodes;

				$value		= '';
				$category	= '';
				$description	= '';
				$smtp		= '';
				$reference	= '';

				foreach ($nodes as $node) {
					if ($node->nodeType === XML_ELEMENT_NODE) {
						$name	= $node->nodeName;
						$$name	= $node->nodeValue;
					}
				}
			}

			$description_safe	= addslashes($description);

			switch($section_id) {
				case 'Categories':
					$categories[$item_id]		= $description;
					$constants_categories_define	.= "\tdefine('$item_id', $value);\r\n";

					break;
				case 'Diagnoses':
					if (($category !== $prior_category) && array_key_exists($category, $categories)) {
						$comment			= "\t// " . $categories[$category] . "\r\n";
						$prior_category			= $category;
						$constants_diagnoses_define	.= $comment;
					}

					$constants_diagnoses_define	.= "\tdefine('$item_id', $value);\r\n";

					break;
				default:
			}
		}
	}
}

// Put the generated PHP into the script
$filename	= '../is_email.php';
$php		= file_get_contents($filename);
$php		= replace($php, 'diagnostic constants',	$constants_categories_define . PHP_EOL . $constants_diagnoses_define);

//echo $constants_categories_define; // debug
//echo $constants_diagnoses_define; // debug
file_put_contents($filename, $php);
?>
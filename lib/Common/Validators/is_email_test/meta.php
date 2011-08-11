<?php
/**
 * To validate an email address according to RFCs 5321, 5322 and others
 * 
 * Copyright © 2008-2011, Dominic Sayers					<br>
 * Test schema documentation Copyright © 2011, Daniel Marschall			<br>
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 * 
 *     - Redistributions of source code must retain the above copyright notice,
 *       this list of conditions and the following disclaimer.
 *     - Redistributions in binary form must reproduce the above copyright notice,
 *       this list of conditions and the following disclaimer in the documentation
 *       and/or other materials provided with the distribution.
 *     - Neither the name of Dominic Sayers nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * @package	is_email
 * @author	Dominic Sayers <dominic@sayers.cc>
 * @copyright	2008-2011 Dominic Sayers
 * @license	http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link	http://www.dominicsayers.com/isemail
 * @version	3.01.1 - Fixed examples and readme.txt
 */

/*.
	require_module 'dom';
.*/

// What type of analysis data to return
if (!defined('ISEMAIL_META_DESC')) {
	define('ISEMAIL_META_DESC'	, 1);		// Explanatory description of this diagnosis or category
	define('ISEMAIL_META_CONSTANT'	, 2);		// The name of the constant for this diagnosis or category
	define('ISEMAIL_META_SMTP'	, 4);		// The SMTP enhanced status message for this diagnosis (the bounce message)
	define('ISEMAIL_META_CATEGORY'	, 8);		// The category name for this diagnosis
	define('ISEMAIL_META_CAT_VALUE'	, 16);		// The category value for this diagnosis
	define('ISEMAIL_META_CAT_DESC'	, 32);		// The category description for this diagnosis
	define('ISEMAIL_META_REF_TEXT'	, 64);		// Any supporting text associated with the diagnosis or category
	define('ISEMAIL_META_REF_CITE'	, 128);		// Document cited to support this diagnosis or category
	define('ISEMAIL_META_REF_LINK'	, 256);		// Link to any supporting material associated with the diagnosis or category
	define('ISEMAIL_META_REF_HTML'	, 512);		// Complete HTML for any supporting material associated with the diagnosis or category
	define('ISEMAIL_META_REF_ALT'	, 1024);	// Complete HTML for any supporting material associated with the diagnosis or category
	define('ISEMAIL_META_VALUE'	, 2048);	// Numeric value of the diagnosis or category
	define('ISEMAIL_META_USEFUL'	, 1071);	// A array containing a useful set of analysis data
	define('ISEMAIL_META_ALL'	, 4095);	// An array containing all available analysis of this dignosis

	define('ISEMAIL_STRING_UNKNOWN'	, '(unknown)');
}

/*
 * Return analysis of the is_email() return status
 */
/*.mixed.*/ function is_email_analysis(/*.mixed.*/ $result, $type = ISEMAIL_META_DESC) {
	$status = array();

	// Grab the metadata
	$document = new DOMDocument();
	$document->load(dirname(__FILE__) . '/meta.xml');
	$document->schemaValidate(dirname(__FILE__) . '/meta.xsd');
        $XPath = new DOMXPath($document);

	// If we received a value, need to find the associated constant name
	if (is_int($result)) {
	        $nodes		= $XPath->query("/meta/*/item/value[. = '$result']/../@id");

		$value		= $result;
		$constant	= ($nodes->length === 0) ? ISEMAIL_STRING_UNKNOWN : $nodes->item(0)->nodeValue;
	} elseif (is_string($result)) {
		$value		= constant((string) $result);
		$constant	= (string) $result;
	} else {
		return ISEMAIL_STRING_UNKNOWN;
	}

	// Grab the element we need
//	$element = $document->getElementById($constant);	// Doesn't work on my host's installation (Siteground)
	$nodes = $XPath->query("/meta/*/item[@id = '$constant']");

	if ($nodes->length === 0) return ISEMAIL_STRING_UNKNOWN; else $element = $nodes->item(0);

	// Extract the bits we need
	if ((bool) ($type & ISEMAIL_META_DESC)) {
		$nodes = $XPath->query('description', $element);
		$status[ISEMAIL_META_DESC] = ($nodes->length === 0) ? ISEMAIL_STRING_UNKNOWN : $nodes->item(0)->nodeValue;
	}

	if ((bool) ($type & ISEMAIL_META_CONSTANT)) {
		$status[ISEMAIL_META_CONSTANT] = $constant;
	}


	if ((bool) ($type & (ISEMAIL_META_SMTP))) {
		$nodes		= $XPath->query('smtp', $element);
		$smtp		= ($nodes->length === 0) ? ISEMAIL_STRING_UNKNOWN : $nodes->item(0)->nodeValue;
		$element_smtp	= $XPath->query("/meta/*/item[@id = '$smtp']")->item(0);
		$nodes		= $XPath->query('text', $element_smtp);

		$status[ISEMAIL_META_SMTP] = ($nodes->length === 0) ? ISEMAIL_STRING_UNKNOWN : $nodes->item(0)->nodeValue;
	}

	if ((bool) ($type & (ISEMAIL_META_CATEGORY|ISEMAIL_META_CAT_VALUE|ISEMAIL_META_CAT_DESC))) {
		$nodes		= $XPath->query('category', $element);
		$category	= ($nodes->length === 0) ? ISEMAIL_STRING_UNKNOWN : $nodes->item(0)->nodeValue;

		if ((bool) ($type & ISEMAIL_META_CATEGORY))
			$status[ISEMAIL_META_CATEGORY] = $category;

		if ((bool) ($type & ISEMAIL_META_CAT_VALUE))
			$status[ISEMAIL_META_CAT_VALUE] = (string) constant($category);

		if ((bool) ($type & ISEMAIL_META_CAT_DESC)) {
			$element_category	= $XPath->query("/meta/*/item[@id = '$category']")->item(0);
			$nodes			= $XPath->query('description', $element_category);

			$status[ISEMAIL_META_CAT_DESC] = ($nodes->length === 0) ? ISEMAIL_STRING_UNKNOWN : $nodes->item(0)->nodeValue;
		}
	}

	if ((bool) ($type & (ISEMAIL_META_REF_TEXT|ISEMAIL_META_REF_CITE|ISEMAIL_META_REF_LINK|ISEMAIL_META_REF_HTML|ISEMAIL_META_REF_ALT))) {
		$references	= $XPath->query('reference', $element);
		$separator_text	= '';
		$separator_cite	= '';
		$separator_link	= '';

		// Revision 3.1: changed behaviour. These array members are now populated
		// even if there are no refer3ences to include.
		if (!array_key_exists(ISEMAIL_META_REF_TEXT, $status)) $status[ISEMAIL_META_REF_TEXT] = '';
		if (!array_key_exists(ISEMAIL_META_REF_CITE, $status)) $status[ISEMAIL_META_REF_CITE] = '';
		if (!array_key_exists(ISEMAIL_META_REF_LINK, $status)) $status[ISEMAIL_META_REF_LINK] = '';
		if (!array_key_exists(ISEMAIL_META_REF_HTML, $status)) $status[ISEMAIL_META_REF_HTML] = '';
		if (!array_key_exists(ISEMAIL_META_REF_ALT,  $status)) $status[ISEMAIL_META_REF_ALT]  = '';

		foreach ($references as $reference_node) {
			$reference	= $reference_node->nodeValue;
			$element_ref	= $XPath->query("/meta/*/item[@id = '$reference']")->item(0);

			if ((bool) ($type & ISEMAIL_META_REF_TEXT)) {
				$nodes					= $XPath->query('blockquote', $element_ref);
				$status[ISEMAIL_META_REF_TEXT]		.= $separator_text . ($nodes->length === 0) ? ISEMAIL_STRING_UNKNOWN : $nodes->item(0)->nodeValue;
				$separator_text				= PHP_EOL;	// Separate blocks of text with CRLFs
			}

			if ((bool) ($type & ISEMAIL_META_REF_CITE)) {
				$nodes					= $XPath->query('cite', $element_ref);
				$status[ISEMAIL_META_REF_CITE]		.= $separator_cite . ($nodes->length === 0) ? ISEMAIL_STRING_UNKNOWN : $nodes->item(0)->nodeValue;
				$separator_cite				= ', ';	// comma-separated list of reference citations
			}

			if ((bool) ($type & ISEMAIL_META_REF_LINK)) {
				$nodes					= $XPath->query('blockquote/@cite', $element_ref);
				$status[ISEMAIL_META_REF_LINK]		.= $separator_link . ($nodes->length === 0) ? ISEMAIL_STRING_UNKNOWN : $nodes->item(0)->nodeValue;
				$separator_link				.= chr(9);	// tab-separated list of URLs.
			}

			if ((bool) ($type & ISEMAIL_META_REF_HTML)) {
				// Just pass back the XML we find - it is correct HTML
				foreach ($element_ref->childNodes as $childNode) $status[ISEMAIL_META_REF_HTML] .= $document->saveXML($childNode);
			}

			if ((bool) ($type & ISEMAIL_META_REF_ALT)) {
				// The "correct" HTML in the XML file doesn't do anything useful with current browsers
				// So we can transform it into useful but less semantic HTML
				$xsl = <<<XSL
<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="UTF-8" indent="yes" />
	<xsl:template match="item">
		<xsl:copy-of select="blockquote" />
		<xsl:text>
</xsl:text>	<a>
			<xsl:attribute name="href"><xsl:value-of select="blockquote/@cite" /></xsl:attribute>
			<xsl:attribute name="target">_blank</xsl:attribute>
			<xsl:copy-of select="cite" />
		</a>
	</xsl:template>
</xsl:stylesheet>
XSL;

				$xsldoc	= new DOMDocument();
				$xsldoc->loadXML($xsl);
				$xsl = new XSLTProcessor();
				$xsl->importStyleSheet($xsldoc);
				$newdoc = new DOMDocument();
				$newdoc->appendChild($newdoc->importNode($element_ref, true));

				$status[ISEMAIL_META_REF_ALT] .= $xsl->transformToXML($newdoc);
			}
		}
	}

	// Revision 3.1: BUGFIX This array member gets populated even when there is no reference
	// material (above)
	if ((bool) ($type & ISEMAIL_META_VALUE)) {
		$status[ISEMAIL_META_VALUE] = $value;
	}

	return (count($status) === 1) ? array_pop($status) : $status;
}


/*
 * Return a list of valid values
 */
/*.array[int]mixed.*/ function is_email_list($type = ISEMAIL_META_VALUE) {
	$status = array();

	// Grab the metadata
	$document = new DOMDocument();
	$document->load('./meta.xml');
        $XPath = new DOMXPath($document);

	switch ($type) {
	case ISEMAIL_META_DESC:		$tag = 'description';	break;
	case ISEMAIL_META_CONSTANT:	$tag = 'id';		break;
	case ISEMAIL_META_CATEGORY:	$tag = 'category';	break;
	case ISEMAIL_META_VALUE:	$tag = 'value';		break;
	default:
		die("Unrecognised type: $type");
	}

	if ($type === ISEMAIL_META_CONSTANT) {
		$nodeList	= $XPath->query("/meta/Diagnoses/item/@$tag");
	} else {
		$nodeList	= $XPath->query("/meta/Diagnoses/item/$tag");
	}

	foreach ($nodeList as $node) $status[] = $node->nodeValue;

	return $status;
}
?>
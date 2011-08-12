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

$is_email_dir = dirname(__FILE__);
require_once $is_email_dir . '/../is_email.php';
require_once $is_email_dir . '/meta.php';

class is_email_test_item {
	private	/*.is_email_test.*/	$mommy;
	public	/*.string.*/		$id;		// Test id
	public	/*.string.*/		$address;	// Raw email address from data file
	public	/*.string.*/		$address_html;	// Raw address in HTML-friendly form
	public	/*.string.*/		$email;		// With Unicode tokens transformed into actual characters
	public	/*.string.*/		$category;	// Expected category
	public	/*.string.*/		$diagnosis;	// Expected diagnosis
	public	/*.string.*/		$comment;	// Comment from data file


	public /*.void.*/ function __construct(/*.DOMNode.*/ $node, /*.is_email_test.*/ $mommy) {
		$this->mommy	= $mommy;
		$this->id	= $node->hasAttribute('id') ? $node->getAttribute('id') : '';
		$tagList	= $node->childNodes;
		$address	= '';
		$category	= '';
		$diagnosis	= '';
		$comment	= '';

		for ($j = 0; $j < $tagList->length; $j++) {
			$node = $tagList->item($j);

			if ($node->nodeType === XML_ELEMENT_NODE) {
				$name	= $node->nodeName;
				$$name	= $mommy->innerHTML($node);
			}
		}

		$this->address		= $address;
		$this->category		= $category;
		$this->diagnosis	= $diagnosis;
		$this->comment		= $comment;
		$this->email		= str_replace($mommy->needles, $mommy->substitutes,		$this->address);
		$this->address_html	= str_replace($mommy->needles, $mommy->substitutes_html,	$this->address);
		$this->comment		= str_replace($mommy->needles, $mommy->substitutes,		$this->comment);
	}
}

class is_email_test {
	private	/*.DOMDocument.*/	$document;
	private	/*.DOMNodeList.*/	$tests;
	private	/*.int.*/		$count;
	public	/*.array[int]string.*/	$needles		= array();
	public	/*.array[int]string.*/	$substitutes		= array();
	public	/*.array[int]string.*/	$substitutes_html	= array();

	public /*.string.*/ function innerHTML($node) {
		if ($node->childNodes->length > 1) {
			$html = '';
			foreach ($node->childNodes as $childNode) $html .= $this->document->saveXML($childNode); // May need LIBXML_NOEMPTYTAG
		} else {
			$html = $node->nodeValue;
		}

		return $html;
	}

	public /*.string.*/ function version() {
		// Get version
		$suite = $this->document->getElementsByTagName('tests')->item(0);
		return ($suite->hasAttribute('version')) ? $suite->getAttribute('version') : '';
	}

	public /*.string.*/ function description() {
		// Get description
		$nodeList = $this->document->getElementsByTagName('description');
		return ($nodeList->length === 0) ? '' : "\t" . '<div class="rubric">' . $this->innerHTML($nodeList->item(0)) . '</div>';
	}

	public /*.int.*/ function count() {
		// Get count
		return $this->count;
	}

	public /*.is_email_test_item.*/ function item(/*.int.*/ $i) {
		return new is_email_test_item($this->tests->item($i), $this);
	}

	public /*.void.*/ function __construct($testset = '') {
		if ($testset === '') return;

		$document = new DOMDocument();
		$document->load($testset);
		$document->schemaValidate(dirname(__FILE__) . '/tests.xsd');

		$this->document = $document;
		$this->tests	= $document->getElementsByTagName('test');
		$this->count	= $this->tests->length;

		// Can't store ASCII or Unicode characters below U+0020 in XML file so we put a token in the XML
		// (except for HTAB, CR & LF)
		// The tokens we have chosen are the Unicode Characters 'SYMBOL FOR xxx' (U+2400 onwards)
		// Here we convert the symbol to the actual character.
		$span_start		= '<span class="controlcharacter">';
		$span_end		= '</span>';

		$needles		= array(' ', mb_convert_encoding('&#9229;&#9226;', 'UTF-8', 'HTML-ENTITIES'));
		$substitutes		= array(' ', chr(13).chr(10));
		$substitutes_html	= array("$span_start&#x2420;$span_end", "$span_start&#x240D;&#x240A;$span_end<br/>");

		for ($i = 0; $i < 32; $i++) {
			$entity			= mb_convert_encoding('&#' . (string) (9216 + $i) . ';', 'UTF-8', 'HTML-ENTITIES');	// PHP bug doesn't allow us to use hex notation (http://bugs.php.net/48645)
			$entity_html		= '&#x24' . substr('0'.dechex($i), -2) . ';';
			$needles[]		= $entity;
			$substitutes[]		= chr($i);
			$substitutes_html[]	= "$span_start$entity_html$span_end";
		}

		// Additional output modifications
		$substitutes_html[12]		.= '<br/>';	// Add a visible line break to LF
		$substitutes_html[15]		.= '<br/>';	// Add a visible line break to CR

		$this->needles		= $needles;
		$this->substitutes	= $substitutes;
		$this->substitutes_html	= $substitutes_html;
	}

	public static /*.array[string]mixed.*/ function test ($email, $expected_category_test = '', $expected_diagnosis = '') {
		$result			= /*.(array[string]mixed).*/ array('actual' => array());
		$parsedata		= /*.(array[string]string).*/ array();

		$diagnosis_value		= is_email($email, true, true, &$parsedata);

		$result['actual']['diagnosis']	= $diagnosis_value;
		$result['actual']['parsedata']	= $parsedata;
		$result['actual']['analysis']	= is_email_analysis($diagnosis_value, ISEMAIL_META_ALL);

		if ($expected_diagnosis === '') {
			$result['actual']['alert_category']	= false;
			$result['actual']['alert_diagnosis']	= false;
		} else {
			$result['expected']			= array();
			$result['expected']['diagnosis']	= $expected_diagnosis;
			$result['expected']['analysis']		= is_email_analysis($expected_diagnosis, ISEMAIL_META_ALL);

			$category				= $result['actual']['analysis'][ISEMAIL_META_CATEGORY];
			$expected_category			= $result['expected']['analysis'][ISEMAIL_META_CATEGORY];
			$diagnosis				= $result['actual']['analysis'][ISEMAIL_META_CONSTANT];

			$result['actual']['alert_category']	= ($category	!== $expected_category);
			$result['actual']['alert_diagnosis']	= ($diagnosis	!== $expected_diagnosis);
		}

		// Sanity check expected category
		// (this is necessary because we decided to keep both category
		// and diagnosis in the test data)
		if (($expected_category_test !== '') && ($expected_category_test !== $expected_category))
			die("The expected category $expected_category_test from the test data for '$email' does not match the true expected category $expected_category");

		return $result;
	}
}
?>
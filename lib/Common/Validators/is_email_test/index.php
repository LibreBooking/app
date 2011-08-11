<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="chrome=1"/>
	<title>Testing is_email()</title>
	<link rel="stylesheet" href="tests.css"/>
</head>

<body>
	<h2 id="top">RFC-compliant email address validation</h2>
<?php
// Incorporates formatting suggestions from Daniel Marschall
require_once './tests.php';

/*string.*/ function alternate_diagnoses(/*.array[int]int.*/ $diagnoses, /*.int.*/ $diagnosis) {
		// Other diagnoses
		$alternates	= '';
		$separator	= '';

		foreach ($diagnoses as $alternate) {
			if ($alternate !== $diagnosis) {
				$alternates	.= $separator . is_email_analysis($alternate, ISEMAIL_META_CONSTANT);
				$separator	= ', ';
			}
		}

		return ($alternates !== '') ? "Other diagnoses: $alternates" : '';
}

/*.string.*/ function all_tests($testset = 'tests.xml') {
	$tests		= new is_email_test($testset);
	$version	= $tests->version();
	$description	= $tests->description();
	$test_count	= $tests->count();

	echo <<<PHP
	<h3>Test package version $version</h3>
$description

PHP;

	$coverage_actual		= array();	// List of diagnoses returned by the test set
	$statistics_count		= 0;
	$statistics_alert_category	= 0;
	$statistics_alert_diagnosis	= 0;
	$html				= '';

	for ($i = 0; $i < $test_count; $i++) {
		$test		= $tests->item($i);

		$id		= $test->id;
		$address	= $test->address;
		$category	= $test->category;
		$diagnosis	= $test->diagnosis;
		$email		= $test->email;
		$address_html	= $test->address_html;
		$comment	= $test->comment;

		$result		= $tests->test($email, $category, $diagnosis);	// This is why we're here

		$category_result	= $result['actual']['analysis'][ISEMAIL_META_CAT_VALUE];
		$diagnosis_result	= $result['actual']['diagnosis'];
		$constant_category	= $result['actual']['analysis'][ISEMAIL_META_CATEGORY];
		$constant_diagnosis	= $result['actual']['analysis'][ISEMAIL_META_CONSTANT];
		$text			= $result['actual']['analysis'][ISEMAIL_META_DESC];
		$references		= (array_key_exists(ISEMAIL_META_REF_ALT, $result['actual']['analysis'])) ? '<span>' . $result['actual']['analysis'][ISEMAIL_META_REF_ALT] . '</span>' : '';

		$comments		= /*.(array[int]string).*/ array();

		if (strlen($comment) !== 0)	$comments[] = '<em>' . stripslashes($comment) . '</em>';
		if ($text !== '')		$comments[] = stripslashes($text);

		if ($result['actual']['alert_category']) {
			$class_category	= ' unexpected';
			$rag_category	= ' red';
			$comments[]	= 'Expected category was ' . $result['expected']['analysis'][ISEMAIL_META_CATEGORY];
		} else {
			$class_category	= '';
			$rag_category	= '';
		}

		if ($result['actual']['alert_diagnosis']) {
			$class_diagnosis= ' unexpected';
			$rag_diagnosis	= ' amber';
			$comments[]	= 'Expected diagnosis was ' . $result['expected']['analysis'][ISEMAIL_META_CONSTANT];
		} else {
			$class_diagnosis= '';
			$rag_diagnosis	= '';
		}

		// Validity
		$validity	= ($diagnosis_result < ISEMAIL_THRESHOLD);
		$valid		= ($validity) ? 'valid' : 'invalid';
		$validity_rag	= '';
//		if ($validity === $result['actual']['simple']) $validity_rag = ' red';

		// Other diagnoses
		$alternates = alternate_diagnoses($result['actual']['parsedata']['status'], $diagnosis_result);
		if ($alternates !== '') $comments[] = $alternates;

		$comments_html	= implode('<br/>', $comments);
		$address_length = strlen($address);
		$address_class	= ($address_length > 39) ? 'small' : (($address_length < 29) ? 'large' : 'medium');

		$html .= <<<HTML
			<tr id="$id">
				<td><p class="address $address_class">$address_html</p></td>
				<td>
					<div class="infoblock">
						<div class="validity"><p class="$valid $address_class$validity_rag"/></div>
						<div>
							<div class="label">Test #</div>		<div class="id">$id</div><br/>
							<div class="label">Category</div>	<div class="category$class_category$rag_category">$constant_category</div><br/>
							<div class="label">Diagnosis</div>	<div class="diagnosis$class_diagnosis$rag_diagnosis">$constant_diagnosis</div><br/>
$references
						</div>
					</div>
				</td>
				<td><div class="comment">$comments_html</div></td>
			</tr>

HTML;

		// Update statistics for this test
		$coverage_actual[]		= $diagnosis_result;

		$statistics_count++;
		$statistics_alert_category	+= ($result['actual']['alert_category'])	? 1 : 0;
		$statistics_alert_diagnosis	+= ($result['actual']['alert_diagnosis'])	? 1 : 0;
	}

	// Revision 2.7: Added test run statistics
	if	($statistics_alert_category	!== 0)	$statistics_class = 'red';
	else if	($statistics_alert_diagnosis	!== 0)	$statistics_class = 'amber';
	else						$statistics_class = 'green';

	$statistics_plural_count	= ($statistics_count		=== 1)	? '' : 's';
	$statistics_plural_category	= ($statistics_alert_category	=== 1)	? 'y' : 'ies';
	$statistics_plural_diagnosis	= ($statistics_alert_diagnosis	=== 1)	? 'is' : 'es';

	// Coverage
	$coverage_actual	= array_unique($coverage_actual, SORT_NUMERIC);
	$coverage_theory	= is_email_list(ISEMAIL_META_VALUE);
	$coverage_count_actual	= count($coverage_actual);
	$coverage_count_theory	= count($coverage_theory);
	$coverage_percent	= sprintf('%d', 100 * $coverage_count_actual / $coverage_count_theory);
	$coverage_diff		= array_diff($coverage_theory, $coverage_actual);
	$coverage_missing	= '';
	$separator		= '';

	foreach($coverage_diff as $value) {
		$constant		= is_email_analysis((int) $value, ISEMAIL_META_CONSTANT);
		$coverage_missing	.= $separator . $constant;
		$separator		= ', ';
	}

	if ($coverage_missing !== '') $coverage_missing = " Missing outcomes: $coverage_missing";

	echo <<<PHP
	<p class="rubric">Coverage: $coverage_percent% ($coverage_count_actual outcomes recorded / $coverage_count_theory defined).$coverage_missing</p>
	<p class="statistics $statistics_class">$statistics_count test$statistics_plural_count: $statistics_alert_category unexpected categor$statistics_plural_category, $statistics_alert_diagnosis unexpected diagnos$statistics_plural_diagnosis</p>
	<table>
		<thead>
			<tr>
				<th><p class="heading address">Address</p></th>
				<th class="heading infoblock">Results</th>
				<th class="heading comment">Comments</th>
			</tr>
		</thead>
		<tbody>
$html		</tbody>
	</table>
	<a id="bottom" href="#top">&laquo; back to top</a>
PHP;
}

/*.string.*/ function test_single_address(/*.string.*/ $email) {
	$tests			= new is_email_test();
	$result			= $tests->test($email);

	$constant_category	= $result['actual']['analysis'][ISEMAIL_META_CATEGORY];
	$constant_diagnosis	= $result['actual']['analysis'][ISEMAIL_META_CONSTANT];
	$text_category		= $result['actual']['analysis'][ISEMAIL_META_CAT_DESC];
	$text_diagnosis		= $result['actual']['analysis'][ISEMAIL_META_DESC];
	$smtpcode		= $result['actual']['analysis'][ISEMAIL_META_SMTP];
	$reference		= (array_key_exists(ISEMAIL_META_REF_ALT, $result['actual']['analysis'])) ? "\t\t<p>The following reference is relevant:</p>\r\n" . $result['actual']['analysis'][ISEMAIL_META_REF_ALT] : '';
	$validity		= ($result['actual']['diagnosis'] < ISEMAIL_THRESHOLD);
	$valid			= ($validity) ? 'valid' : 'invalid';

	// Other diagnoses
	$alternates = alternate_diagnoses($result['actual']['parsedata']['status'], $result['actual']['diagnosis']);
	if ($alternates !== '') $alternates = "<p>$alternates</p>";

	echo <<<HTML
	<div class="results">
		<p>Email address tested was <em>$email</em></p>
		<p>Short story: the address is <strong>$valid</strong> for common use cases (such as an online registration form)</p>
		<p>Category: $text_category [$constant_category]<br/>
		Diagnosis: $text_diagnosis [$constant_diagnosis]</p>
$alternates		<p>The SMTP enhanced status code would be <em>$smtpcode</em></p>
$reference	</div>

HTML;
}

/*.string.*/ function forms_html(/*.string.*/ $email = '') {
	$value = ($email === '') ? '' : ' value="' . htmlspecialchars($email) . '"';

	return <<<PHP
	<form>
		<input type="submit" value="Test this" class="menu"/>
		<input type="text"$value name="address" class="text"/>
	</form>
	<a class="menu" href="?all" >Run all tests</a>
	<a class="menu" href="?set=tests-original.xml" >Run original test set</a>
	<a class="menu" href="http://www.dominicsayers.com/isemail" target="_blank">Read more...</a>
	<a class="menu" href="mailto:dominic@sayers.cc?subject=is_email()">Contact</a>
	<br/>

PHP;
}

if (isset($_GET) && is_array($_GET)) {
	if (array_key_exists('address', $_GET)) {
		$email = $_GET['address'];
		if (get_magic_quotes_gpc() !== 0) $email = stripslashes($email); // Version 2.6: BUG: The online test page didn't take account of the magic_quotes_gpc setting that some hosting providers insist on setting. Including mine.
		echo forms_html($email);
		test_single_address($email);
	} else if (array_key_exists('all', $_GET)) {
		echo forms_html();
		all_tests();
	} else if (array_key_exists('set', $_GET)) {	// Revision 2.11: Run any arbitrary test set
		echo forms_html();
		all_tests($_GET['set']);
	} elseif (count($_GET) > 0) {
		$keys	= array_keys($_GET);
		$email	= array_shift($keys);
		if (get_magic_quotes_gpc() !== 0) $email = stripslashes($email); // Version 2.6: BUG: The online test page didn't take account of the magic_quotes_gpc setting that some hosting providers insist on setting. Including mine.
		echo forms_html($email);
		test_single_address($email);
	} else {
		echo forms_html();
	}
}
?>

</body>
</html>

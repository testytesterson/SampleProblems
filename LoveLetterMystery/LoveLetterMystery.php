<?php

/**
 * Assumptions
 *     - Input strings don't contain anything except for alpha chars
 *     - Input strings are case insensitive
 *
 */

define('INPUT_COUNT_MIN', 1);
define('INPUT_COUNT_MAX', 10);
define('TEST_CASE_LEN_MIN', 1);
define('TEST_CASE_LEN_MAX', pow(10, 4));


function letterDiff($a, $b) {
	return ord($a) - ord($b);
}

function removePivot($string) {
	$count = strlen($string);
	if ($count % 2 == 0) return $string;
	$pivotPos = ($count - 1) / 2;
	return substr_replace($string, '', $pivotPos, 1);
}

function calculateMinOps($string) {

	$string = strtolower($string);

	// We don't care about the very middle character, remove it
	$string = removePivot($string);

	$count = strlen($string);
	$half = $count / 2;

	// Split down the middle for mirror images
	$sideA = substr($string, 0, $half);
	$sideB = strrev(substr($string, $half));

	$totalOperations = 0;
	for($checkPos=0; $checkPos < $half; $checkPos++) {
		$diff = letterDiff($sideA[$checkPos], $sideB[$checkPos]);
		$totalOperations += abs($diff);
	}

	return $totalOperations;
}


// Validation
function isInputCountValid($count) {
    if (!is_numeric($count)) return false;
    if ($count > INPUT_COUNT_MAX) return false;
    if ($count < INPUT_COUNT_MIN) return false;
    return true;
}

function isTestCaseValid($string) {
	if (!is_string($string)) return false;
	$length = strlen($string);
    if ($length < TEST_CASE_LEN_MIN) return false;
    if ($length > TEST_CASE_LEN_MAX) return false;
    return true;
}


// Input
function askAndFetchElements() {
    // Get the total expected count first
    echo "Enter the number of test cases you'd like evaluated:", PHP_EOL;
    while($value = fgets(STDIN)) {
        $value = trim($value);
        if (!isInputCountValid($value)) {
            echo "Invalid input count, please re-enter:", PHP_EOL;
            continue;
        }
        break;
    }
    $count = (int) $value;

    // Get (and validate) each expected string
    $validElements = array();
    echo "Enter the $count test case(s) line-by-line:", PHP_EOL;
    while(count($validElements) < $count) {
        $string = trim(fgets(STDIN));
        if (!isTestCaseValid($string)) {
            echo "Invalid Test Case, try again:", PHP_EOL;
            continue;
        }
        $validElements[] = $string;
    }

    return $validElements;
}

$strings = askAndFetchElements();
echo "Results: ", PHP_EOL;
foreach($strings as $string) {
	$result = calculateMinOps($string);
	echo $result, PHP_EOL;
}




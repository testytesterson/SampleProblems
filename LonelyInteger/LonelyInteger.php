<?php

/**
 * Lonely Integer
 *
 * Constraints
 *     - Number of elements in the array:
 *         - Greater than or equal to 1
 *         - Less than 100
 *         - Odd number
 *     - Each element in the array:
 *         - integer
 *         - Greater than or equal to 0
 *         - Less than or equal to 100
 *
 * Assumptions
 *     - If inputs don't conform to constraints, ask user to correct
 *         - This includes input 2. The number of elements
 *           given by the user should match what the user
 *           specified in input 1.
 *     - If the user input is invalid, don't worry about telling them the exact problem
 *     - If the input elements have more than 1 lonely integer, just show any of them
 *     - If there are no lonely integers, just return null
 *
 *
 */

// Input
function askAndFetchNumberOfElements() {
	echo "Number of Integers:", PHP_EOL;
	while($value = fgets(STDIN)) {
		$value = trim($value);
		if (!isNumberOfElementsValid($value)) {
			echo "Invalid input, please re-enter:", PHP_EOL;
			continue;
		}
		break;
	}
	return (int) $value;
}

function askAndFetchElements($numberOfElements) {
	echo "Integers (separated by space):", PHP_EOL;
	while($string = fgets(STDIN)) {
		$string = trim($string);
		if (!isElementStringValid($string, $numberOfElements)) {
			echo "Invalid input, please re-enter:", PHP_EOL;
			continue;
		}
		break;
	}
	return $string;
}


// Validation
function isNumberOfElementsValid($number) {
	if (!is_numeric($number)) return false;
	if ($number >= 100) return false;
	if ($number < 1) return false;
	if ($number % 2 == 0) return false;
	return true;
}

function isElementStringValid($string, $countConstraint) {
	$elements = convertElementStringToArray($string);
	if (count($elements) != $countConstraint) return false;
	$validElements = array_filter($elements, 'isElementValid');
	if (count($elements) != count($validElements)) return false;
	return true;
}

function isElementValid($element) {
	if ($element > 100) return false;
	if ($element < 0) return false;
	return true;
}


// Composition
function convertElementStringToArray($string) {
	$elements = explode(' ', $string);
	$elements = array_map('trim', $elements);
	return $elements;
}

// Start
$expectedCount = askAndFetchNumberOfElements();
$elementsInput = askAndFetchElements($expectedCount);

// Parse and Sort
$elements = convertElementStringToArray($elementsInput);
sort($elements, SORT_NUMERIC);

$lonelyElement = null;
$firstInPair = null;
foreach($elements as $element) {
	if (is_null($firstInPair)) {
		// On the next pair, assign this element as 'first'
		$firstInPair = $element;
		continue;
	}
	if ($firstInPair == $element) {
		// This element, which is 'second' in the pair, is the same as the 'first'
		$firstInPair = null;
		continue;
	}
	// The last element was lonely, save it and break
	$lonelyElement = $firstInPair;
	break;
}

// If lonely element wasn't detected above, it was last in the list
if (is_null($lonelyElement) && !is_null($firstInPair)) {
	$lonelyElement = $element;
}

echo "", PHP_EOL;
echo $lonelyElement, PHP_EOL;


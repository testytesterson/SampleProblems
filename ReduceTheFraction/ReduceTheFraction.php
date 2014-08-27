<?php

define('NUMERATOR_MIN', 1);
define('DENOMINATOR_MAX', 2000);
define('INPUT_COUNT_MIN', 1);
define('INPUT_COUNT_MAX', 500);

function largestDivisor($one, $two) {

	// Sort
	sort($sorted = array($one, $two), SORT_NUMERIC);
	list($low, $high) = $sorted;

	// Zero check
	if ($low == 0) return $high;

	// Initial Divide, get remainder
	$remainder = $high % $low;

	// Now that we have a starting point, loop and reduce while we can
	while($remainder > 0) {
		// Still have room to reduce, try the next level lower
		$high = $low;
		$low = $remainder;
		// Divide, get remainder
		$remainder = $high % $low;
	}

	// Return the lowest of the two numbers
	return $low;
}

function fractionReduce($numerator, $denominator) {

	// Find the largest number both are evenly divisible by
	$divisor = largestDivisor($numerator, $denominator);

	// Divide each number by the found divisor
	$numerator /= $divisor;
	$denominator /= $divisor;

	return implode('/', array($numerator, $denominator));
}

function getReducedFractionFromString($fractionString) {
	list($numerator, $denominator) = explode('/', $fractionString);
	return fractionReduce($numerator, $denominator);
}



// Validation
function isInputCountValid($count) {
	if (!is_numeric($count)) return false;
	if ($count > INPUT_COUNT_MAX) return false;
	if ($count < INPUT_COUNT_MIN) return false;
	return true;
}

function isFractionValid($string) {
	if (count(explode('/', $string)) != 2) return false;
	list($numerator, $denominator) = explode('/', $string);
	if ($numerator < NUMERATOR_MIN) return false;
	if ($denominator > DENOMINATOR_MAX) return false;
	return true;
}


// Input
function askAndFetchElements() {
	// Get the total expected count first
	echo "Enter the number of fractions you'd like to reduce:", PHP_EOL;
	while($value = fgets(STDIN)) {
		$value = trim($value);
		if (!isInputCountValid($value)) {
			echo "Invalid input count, please re-enter:", PHP_EOL;
			continue;
		}
		break;
	}
	$count = (int) $value;

	echo "Enter the $count fraction(s) line-by-line:", PHP_EOL;

	// Get (and validate) each expected fraction
	$validElements = array();
	while(count($validElements) < $count) {
		$fraction = trim(fgets(STDIN));
		if (!isFractionValid($fraction)) {
			echo "Invalid Fraction, try again:", PHP_EOL;
			continue;
		}
		$validElements[] = $fraction;
	}

	return $validElements;
}





$fractions = askAndFetchElements();

echo "Results:", PHP_EOL;
foreach($fractions as $fraction) {
	$reduced = getReducedFractionFromString($fraction);
	echo $reduced, PHP_EOL;
}

echo "", PHP_EOL;




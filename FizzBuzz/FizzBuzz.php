<?php

define('LINE_COUNT_MAX', pow(10,7));

echo "How many numbers in the sequence would you like to see?",PHP_EOL;
while($lineCountInput = fgets(STDIN)) {

	$lineCountInput = trim($lineCountInput);

	if (!is_numeric($lineCountInput)) {
		echo "Invalid Input, please enter a number:", PHP_EOL;
		continue;
	}

	$lineCount = (int) $lineCountInput;

	if ($lineCount > LINE_COUNT_MAX) {
		echo "Max line count is: ".LINE_COUNT_MAX.", please enter another number:", PHP_EOL;
		continue;
	}

	break;
}

echo "",PHP_EOL;
echo "The FizzBuzz Sequence from 1 - $lineCount:",PHP_EOL;

for($line = 1; $line <= $lineCount; $line++) {

	if ($line % 3 != 0 && $line % 5 != 0) {
		echo $line;
	}

	if ($line % 3 == 0) {
		echo 'Fizz';
	}

	if ($line % 5 == 0) {
		echo 'Buzz';
	}

	echo PHP_EOL;
}



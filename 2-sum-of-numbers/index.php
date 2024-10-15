<?php

function add_numbers(...$numbers)
{
  $sum = 0;

  foreach ($numbers as $number) {
    $sum += $number;
  }

  return $sum;
}

function main()
{
  $numbers = readline("Type the numbers you want to add separated by spaces: ");
  $numbers = explode(' ', $numbers);

  foreach ($numbers as $number) {
    if (!is_numeric($number)) {
      echo "$number is not a number\n";
      return 1;
    }
  }

  echo "The sum of the numbers " . implode(" + ", $numbers) . " is => " . add_numbers(...$numbers) . "\n";
}

main();

<?php
// Search out how many ways there are for going from the store number 1 to another one

//   2---4---6---8
//  / \ / \ / \ / \
// 1---3---5---7---9

// From 1 to 2 there is 1 way
// 1,2
// From 1 to 3 there are 2 ways
// 1,2 1,3
// From 1 to 4 there are 3 ways
// 1,2,3,4 1,2,4 1,3,4
// From 1 to 5 there are 5 ways
// 1,2,3,4,5 1,2,3,5 1,2,4,5 1,3,4,5 1,3,5
// From 1 to 6 there are 8 ways
// So on...
// From 1 to 7 there are 13 ways
// So on...

function get_fibonacci_number($number)
{
  if ($number <= 0) return -1;

  $a = 0;
  $b = 1;
  $temporary = 0;

  if ($number == 1) return $a;
  if ($number == 2) return $b;

  for ($i = 2; $i < $number; $i++) {
    $temporary = $a;
    $a = $b;
    $b += $temporary;
  }

  return $b;
}

function get_user_number()
{
  $number_of_store = 0;
  do {
    // passthru("clear");
    echo "\033[H"; // For moving the cursor to position 0, 0
    echo "\033[2J"; // For clear the console screen from current cursor's position to end console screen
    $number_of_store = (int) readline("Enter a number greater than 1: ");
    if ($number_of_store <= 1) {
      echo "\033[H";
      echo "\033[2J";
      echo "It is not a number greater than 1\n";
      readline();
    }
  } while ($number_of_store <= 1);

  return $number_of_store;
}

function main()
{
  $number_of_store = get_user_number();
  $ways_to_go = get_fibonacci_number($number_of_store + 1);

  if ($ways_to_go == -1) {
    echo "\033[H";
    echo "\033[2J";
    echo "There was a problem getting the fibonacci number :(\n";
  } else {
    echo "\033[H";
    echo "\033[2J";
    echo "There are $ways_to_go ways to going from store 1 to store $number_of_store\n";
  }
}

main();

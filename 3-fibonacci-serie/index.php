<?php

function get_fibo_serie_to($number)
{
  $serie = [];

  if ($number < 0) return -1;

  $a = 0;
  $b = 1;
  $temp = 0;

  while ($a <= $number) {
    array_push($serie, $a);
    $temp = $a;
    $a = $b;
    $b += $temp;
  }

  return $serie;
}

function get_n_fibo_numbers($number)
{
  if ($number < 1) return -1;

  $serie = [];

  $a = 0;
  $b = 1;
  $temp = 0;

  for ($i = 0; $i < $number; $i++) {
    array_push($serie, $a);
    $temp = $a;
    $a = $b;
    $b += $temp;
  }

  return $serie;
}

function print_header()
{
  // $size = strlen($title);
  echo "\033[H";
  echo "\033[2J";
  echo "\e(0";

  echo PHP_EOL;
  echo "\t";
  echo "\x6C";
  echo str_repeat("\x71", 51);
  echo "\x6B";

  echo PHP_EOL;
  echo "\t";
  echo "\x78";
  echo str_repeat(" ", 51);
  echo "\x78";

  echo PHP_EOL;
  echo "\t";
  echo "\x78";
  echo str_repeat(" ", 21);
  echo "FIBONACCI";
  echo str_repeat(" ", 21);
  echo "\x78";

  echo PHP_EOL;
  echo "\t";
  echo "\x78";
  echo str_repeat(" ", 51);
  echo "\x78";

  echo PHP_EOL;
  echo "\t";
  echo "\x6D";
  echo str_repeat("\x71", 51);
  echo "\x6A";

  echo "\t\e(B";
  echo PHP_EOL;
  echo PHP_EOL;
}

function print_menu()
{
  print_header();
  echo "\t1. Get the Fibonacci serie until N";
  echo PHP_EOL;
  echo "\t2. Get the first N numbers of the Fibonacci serie";
  echo PHP_EOL;
  echo "\t0. Exit";
  echo PHP_EOL;
  echo PHP_EOL;
}

function main()
{
  $user_option = 0;

  do {
    print_menu();
    echo "\t";
    $user_option = readline("Select what you want to do: ");
    print_header();

    echo "\t";
    switch ($user_option) {
      case "1":
        $number = (int) readline("Enter the max numer: ");
        $serie = get_fibo_serie_to($number);
        echo PHP_EOL;
        echo "\tThe serie is" . PHP_EOL . "\t";
        foreach ($serie as $value) {
          echo $value . " ";
        }
        break;
      case "2":
        $number = (int) readline("Enter the quantity of numbers of the serie: ");
        $serie = get_n_fibo_numbers($number);
        echo PHP_EOL;
        echo "\tThe serie is" . PHP_EOL . "\t";
        foreach ($serie as $value) {
          echo $value . " ";
        }
        break;
      case "0":
        echo "BYE!" . PHP_EOL;
        exit(0);
      default:
        echo "\t$user_option is not a valid option";
        break;
    }
    echo PHP_EOL;
    readline();
  } while (true);
}

main();

<?php

/**
 * 1. Random word
 * 2. Read user input
 * 3. Verify if the letter is in the correct place
 * 4. Verify if the letter is in the word
 */

// Colors
define("RED", "\033[1;31m");
define("GREEN", "\033[1;32m");
define("YELLOW", "\033[1;33m");
define("CYAN", "\033[1;36m");
define("WHITE", "\033[1;37m");

define("MAX_ATTEMPTS", 6);
$words = [];
$player_words = [];

function load_words($word_length)
{
  global $words;

  $file_name = "{$word_length}_letter_words";

  $file = fopen($file_name, "r", true)
    or die("Unable to open the file {$file_name}\n");

  while (!feof($file)) {
    array_push($words, fgets($file));
  }

  fclose($file);
}

function get_wordle_word()
{
  global $words;
  $words_len = count($words);
  $random_word_position = rand(0, $words_len - 1);
  $word = $words[$random_word_position];
  $word = str_replace("\n", "", $word);
  $word = str_split($word);
  return $word;
}

function print_header($title)
{
  $title_length = strlen($title);

  if ($title_length > 50) {
    echo "The title is too large..." . PHP_EOL;
    exit(1);
  }

  $header_length = ($title_length % 2) === 0 ? 52 : 51;
  $padding_length = ($header_length - $title_length) / 2;
  // Clear console screen
  echo "\033[H";
  echo "\033[2J";

  // Start graphic mode
  echo "\e(0";

  // First line
  echo PHP_EOL;
  echo GREEN;
  echo "\t";
  echo "\x6C";
  echo str_repeat("\x71", $header_length);
  echo "\x6B";

  // Second line
  echo PHP_EOL;
  echo "\t";
  echo "\x78";
  echo str_repeat(" ", $header_length);
  echo "\x78";

  // Third line
  echo PHP_EOL;
  echo "\t";
  echo "\x78";
  echo str_repeat(" ", $padding_length);
  echo WHITE;
  echo $title;
  echo GREEN;
  echo str_repeat(" ", $padding_length);
  echo "\x78";

  // Fourth line
  echo PHP_EOL;
  echo "\t";
  echo "\x78";
  echo str_repeat(" ", $header_length);
  echo "\x78";

  // Last line
  echo PHP_EOL;
  echo "\t";
  echo "\x6D";
  echo str_repeat("\x71", $header_length);
  echo "\x6A";

  // End graphic mode
  echo "\t\e(B";
  echo PHP_EOL;
  echo PHP_EOL;
  echo WHITE;
}

function print_wordle()
{
  global $player_words;
  echo PHP_EOL;
  foreach ($player_words as $player_word) {
    echo "\t";
    echo implode("\t", $player_word);
    echo PHP_EOL;
  }
  echo PHP_EOL;
}

function is_allowed_word($word)
{
  $pattern = "/^[a-zA-z]{6}$/";
  return preg_match($pattern, $word);
}

function set_wordle_word($word, $user_word, $attempt)
{
  $hits = 0;
  global $player_words;
  $user_word = str_split($user_word);
  $wordle_word = [];
  $wordle_letter = "";

  foreach ($user_word as $index => $letter) {
    if ($letter === $word[$index]) {
      $wordle_letter = (GREEN . strtoupper($letter) . WHITE);
      array_push($wordle_word, $wordle_letter);
      $hits++;
    } else if (in_array($letter, $word)) {
      $wordle_letter = (YELLOW . strtoupper($letter) . WHITE);
      array_push($wordle_word, $wordle_letter);
    } else {
      $wordle_letter = (WHITE . strtoupper($letter));
      array_push($wordle_word, $wordle_letter);
    }
  }

  $player_words[$attempt] = $wordle_word;

  return $hits;
}

function start_wordle_game($word)
{
  $tries = 0;
  $user_word = "";
  $has_win = false;

  while ($tries <= MAX_ATTEMPTS) {
    print_header("WORDLE GAME");
    echo CYAN;
    echo "\tAttempts: " . WHITE . $tries;
    print_wordle();
    echo "\t";

    if (($tries >= MAX_ATTEMPTS) || $has_win) break;
    $user_word = readline("Word: ");

    if (!is_allowed_word($user_word)) continue;
    $hits = set_wordle_word($word, $user_word, $tries);

    if ($hits === count($word)) $has_win = true;
    $tries++;
  }

  echo PHP_EOL . "\t";
  if ($has_win) echo GREEN . "You have win!!!";
  else echo RED . "You have lose :(";
  echo PHP_EOL;
}

function main()
{
  global $argc, $argv;
  $pattern = "/^((1[0-5])|[3-9])$/";

  if ($argc < 2) {
    echo "\nYou must set the number of words..." . PHP_EOL;
    exit(1);
  }

  if (preg_match($pattern, $argv[1]) === 0) {
    echo "\nYou have to enter a valid number..." . PHP_EOL;
    exit(1);
  }

  $word_length = (int) $argv[1];
  load_words($word_length);

  global $player_words;

  for ($i = 0; $i < MAX_ATTEMPTS; $i++) {
    $player_words[$i] = [];
    for ($j = 0; $j < $word_length; $j++) {
      array_push($player_words[$i], "_");
    }
  }

  $wordle_word = get_wordle_word();
  start_wordle_game($wordle_word);
}

main();

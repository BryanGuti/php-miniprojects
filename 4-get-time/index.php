<?php

date_default_timezone_set("America/La_Paz");

function main()
{
  while (true) {
    echo "\033[H";
    echo "\033[2J";
    echo "\n\t" . date("h:i:s a") . PHP_EOL;
    sleep(1);
  }
}

main();

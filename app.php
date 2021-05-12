<?php

require_once "Game.php";


$game = new Game();

while ($game->isTheGameStillOpen()) {

    $game->viewFrameAndChance();
    echo "Ile kręgli chcesz strącić?\n";
    fscanf(STDIN, "%d", $pins);
    $game->roll($pins);

    $score = $game->getScore();
    fprintf(STDOUT, "\nWynik: %d\n", $score);
}
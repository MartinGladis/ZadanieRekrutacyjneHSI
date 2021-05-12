<?php

class Game {
    private $score = 0;
    private $pinsLeft = 10;
    private $strike = false;
    private $doubleStrike = false;
    private $spare = false;
    private $frame = 1;
    private $chance = 1;
    private $gameOpen = true;
    private $thirdRollAllow = false;


    public function roll(int $pins) {

        if ($this->frame > 10) {
            echo "Gra się skończyła!!!\n";
            return;
        }

        if ($pins > $this->pinsLeft || $this->pinsLeft < 0) {
            echo "Liczba nie jest z zakresu!!!\n";
            return;
        }

        $this->addPoints($pins);
        $this->setStrikesAndSpares();
        $this->nextRoll();
    }

    


    private function addPoints($pins) {
        $this->pinsLeft -= $pins;
        $this->score += $pins;

        if ($this->spare && $this->chance != 3) {
            $this->score += $pins;
            $this->spare = false;
        }

        if ($this->strike && $this->chance != 3) {
            $this->score += $pins;
            if ($this->chance == 2) {
                $this->strike = false;
            }

            if ($this->doubleStrike) {
                $this->score += $pins;
                $this->doubleStrike = false;
            }
        }
    }

    private function setStrikesAndSpares() {
        if ($this->strike && $this->pinsLeft == 0 && $this->frame != 10)
            $this->doubleStrike = true;

        if ($this->chance == 1 && $this->pinsLeft == 0 && $this->frame != 10)
            $this->strike = true;

        if ($this->chance == 2 && $this->pinsLeft == 0 && $this->frame != 10)
            $this->spare = true;
    }

    private function nextRoll() {
        if (($this->frame == 10) && $this->pinsLeft == 0 ) {
            $this->thirdRollAllow = true;
            $this->pinsLeft = 10;
            $this->chance++;
        } else {
            if ($this->pinsLeft == 0) {
                $this->frame++;
                $this->pinsLeft = 10;
                $this->chance = 1;
            } elseif ($this->chance >= 2 && !($this->thirdRollAllow)) {
                $this->chance = 1;
                $this->frame++;
                $this->pinsLeft = 10;
            } else {
                $this->chance++;
                $this->thirdRollAllow = false;
            }
        }

        if ($this->frame > 10 || $this->chance > 3) {
            $this->gameOpen = false;
        }
    }


    
    public function getScore() {
        return $this->score;
    }

    public function isTheGameStillOpen() {
        return $this->gameOpen;
    }

    public function viewFrameAndChance() {
        echo "\nFrames: " . $this->frame . "\nChance: " . $this->chance . "\n";
    }
}
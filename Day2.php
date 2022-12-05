<?php

require "vendor/autoload.php";

/*
For example, suppose you were given the following strategy guide:

A Y
B X
C Z

This strategy guide predicts and recommends the following:

    In the first round, your opponent will choose Rock (A), and you should choose Paper (Y). This ends in a win for you with a score of 8 (2 because you chose Paper + 6 because you won).
    In the second round, your opponent will choose Paper (B), and you should choose Rock (X). This ends in a loss for you with a score of 1 (1 + 0).
    The third round is a draw with both players choosing Scissors, giving you a score of 3 + 3 = 6.

In this example, if you were to follow the strategy guide, you would get a total score of 15 (8 + 1 + 6).

 */
$input = file_get_contents("data/day2");;
$lines = explode("\n", $input);
$totalScore = 0;
foreach($lines as $line) {
    $parts = explode(' ', $line);
    switch($parts[1]) {
        case 'X':
            $totalScore += 1;
            if($parts[0] === 'A') {
                $totalScore += 3;
            } else if($parts[0] === 'B') {
                $totalScore += 0;
            } else if($parts[0] === 'C') {
                $totalScore += 6;
            }
            break;
        case 'Y':
            $totalScore += 2;
            if($parts[0] === 'A') {
                $totalScore += 6;
            } else if($parts[0] === 'B') {
                $totalScore += 3;
            } else if($parts[0] === 'C') {
                $totalScore += 0;
            }
            break;
        case 'Z':
            $totalScore += 3;
            if($parts[0] === 'A') {
                $totalScore += 0;
            } else if($parts[0] === 'B') {
                $totalScore += 6;
            } else if($parts[0] === 'C') {
                $totalScore += 3;
            }
            break;
    }
}
echo $totalScore;
echo "\n";

/*
The Elf finishes helping with the tent and sneaks back over to you. "Anyway, the second column says how the round needs to end: X means you need to lose, Y means you need to end the round in a draw, and Z means you need to win. Good luck!"

The total score is still calculated in the same way, but now you need to figure out what shape to choose so the round ends as indicated. The example above now goes like this:

In the first round, your opponent will choose Rock (A), and you need the round to end in a draw (Y), so you also choose Rock. This gives you a score of 1 + 3 = 4.
In the second round, your opponent will choose Paper (B), and you choose Rock so you lose (X) with a score of 1 + 0 = 1.
In the third round, you will defeat your opponent's Scissors with Rock for a score of 1 + 6 = 7.

Now that you're correctly decrypting the ultra top secret strategy guide, you would get a total score of 12.

Following the Elf's instructions for the second column, what would your total score be if everything goes exactly according to your strategy guide?
 */

$totalScore = 0;
foreach($lines as $line) {
    $parts = explode(' ', $line);
    switch($parts[1]) {
        case 'X': // lose
            $totalScore += 0;
            if($parts[0] === 'A') {
                $totalScore += 3;
            } else if($parts[0] === 'B') {
                $totalScore += 1;
            } else if($parts[0] === 'C') {
                $totalScore += 2;
            }
            break;
        case 'Y': // draw
            $totalScore += 3;
            if($parts[0] === 'A') {
                $totalScore += 1;
            } else if($parts[0] === 'B') {
                $totalScore += 2;
            } else if($parts[0] === 'C') {
                $totalScore += 3;
            }
            break;
        case 'Z': // win
            $totalScore += 6;
            if($parts[0] === 'A') {
                $totalScore += 2;
            } else if($parts[0] === 'B') {
                $totalScore += 3;
            } else if($parts[0] === 'C') {
                $totalScore += 1;
            }
            break;
    }
}
echo $totalScore;
echo "\n";
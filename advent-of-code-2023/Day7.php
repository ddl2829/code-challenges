<?php


namespace AdventOfCode2023;

use PHPUnit\Framework\TestCase;

class Day7 extends TestCase
{
    public function solve($input, $partTwo = false) {
        $lines = explode("\n", $input);

        $fiveOfAKind = [];
        $fourOfAKind = [];
        $fullHouse = [];
        $threeOfAKind = [];
        $twoPair = [];
        $onePair = [];
        $highCard = [];
        foreach($lines as $line) {
            [$hand, $bid] = explode(" ", $line);
            $bid = intval($bid);
            $cards = str_split($hand);
            $cardCount = [];
            foreach($cards as $card) {
                if(!isset($cardCount[$card])) {
                    $cardCount[$card] = 0;
                }
                $cardCount[$card]++;
            }
            // analyze the card count to determine the hand's type
            $cardCount = array_values($cardCount);
            rsort($cardCount);
            if($cardCount[0] === 5) {
                $fiveOfAKind[$hand] = $bid;
            } else if($cardCount[0] === 4) {
                $fourOfAKind[$hand] = $bid;
            } else if($cardCount[0] === 3) {
                if($cardCount[1] === 2) {
                    $fullHouse[$hand] = $bid;
                } else {
                    $threeOfAKind[$hand] = $bid;
                }
            } else if($cardCount[0] === 2) {
                if($cardCount[1] === 2) {
                    $twoPair[$hand] = $bid;
                } else {
                    $onePair[$hand] = $bid;
                }
            } else {
                $highCard[$hand] = $bid;
            }
        }

        $cardRanks = [
            '2' => 1,
            '3' => 2,
            '4' => 3,
            '5' => 4,
            '6' => 5,
            '7' => 6,
            '8' => 7,
            '9' => 8,
            'T' => 9,
            'J' => 10,
            'Q' => 11,
            'K' => 12,
            'A' => 13,
        ];

        $rankSort = function($key1, $key2) use($cardRanks) {
            $cards1 = str_split($key1);
            $cards2 = str_split($key2);
            foreach($cards1 as $card1) {
                foreach($cards2 as $card2) {
                    if($card1 !== $card2) {
                        return $cardRanks[$card2] <=> $cardRanks[$card1];
                    }
                }
            }
        };

        uksort($fiveOfAKind, $rankSort);
        uksort($fourOfAKind, $rankSort);
        uksort($fullHouse, $rankSort);
        uksort($threeOfAKind, $rankSort);
        uksort($twoPair, $rankSort);
        uksort($onePair, $rankSort);
        uksort($highCard, $rankSort);

        $finalRanking = [];
        // sort each group by the strength of the cards in the hand
        foreach([$fiveOfAKind, $fourOfAKind, $fullHouse, $threeOfAKind, $twoPair, $onePair, $highCard] as $group) {
            foreach($group as $hand => $bid) {
                $finalRanking[] = $bid;
            }
        }

        $finalRanking = array_reverse($finalRanking);
        $score = 0;
        foreach($finalRanking as $i => $bid) {
            $score += ($i + 1) * $bid;
        }
        return $score;
    }

    public function test_first_part_example() {
        $input = <<<HERE
32T3K 765
T55J5 684
KK677 28
KTJJT 220
QQQJA 483
HERE;
        $this->assertEquals(6440, $this->solve($input));
    }

    public function test_first_part() {
        $input = file_get_contents('data/day7');
        $this->assertEquals("", $this->solve($input));
    }

    public function test_second_part_example() {
        $input = <<<HERE
32T3K 765
T55J5 684
KK677 28
KTJJT 220
QQQJA 483
HERE;
        $this->assertEquals("", $this->solve($input, true));
    }

    public function test_second_part() {
        $input = file_get_contents('data/day7');
        $this->assertEquals("", $this->solve($input, true));
    }
}
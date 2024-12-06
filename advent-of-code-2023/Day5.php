<?php


namespace AdventOfCode2023;

use PHPUnit\Framework\TestCase;

class Day5 extends TestCase
{
    public function getOutput($map, $input) {
        foreach($map as $line) {
            [$destinationStart, $sourceStart, $range] = $line;
            if($input >= $sourceStart && $input < $sourceStart + $range) {
                return $destinationStart + ($input - $sourceStart);
            }
        }
        return $input;
    }

    public function getInput($map, $output) {
        foreach($map as $line) {
            [$destinationStart, $sourceStart, $range] = $line;
            if($output >= $destinationStart && $output < $destinationStart + $range) {
                return $sourceStart + ($output - $destinationStart);
            }
        }
        return $output;
    }

    public function buildMap($lines) {
        $output = [];
        foreach($lines as $line) {
            $output[] = array_map('intval', explode(" ", $line));
        }
        return $output;
    }

    public function solve($input, $partTwo = false) {
        // seeds are specific numbers

        // maps are a range
        // destination start, source start, range length
        $seeds = [];
        $seedsToSoil = [];
        $soilToFertilizer = [];
        $fertilizerToWater = [];
        $waterToLight = [];
        $lightToTemperature = [];
        $temperatureToHumidity = [];
        $humidityToLocation = [];

        // theres a line break between each section
        $sections = explode("\n\n", $input);
        //print_r($sections);
        foreach($sections as $section) {
            // identify the section
            if(str_starts_with($section, 'seeds:')) {
                // seeds
                $seeds = array_map('intval', explode(" ", str_replace("seeds: ", "", $section)));
                if($partTwo) {
                    $seeds = array_chunk($seeds, 2);
                }
            } else if(str_starts_with($section, 'seed-to-soil map:')) {
                // seed-to-soil map
                echo "found seed-to-soil map\n";
                $lines = explode("\n", $section);
                array_shift($lines);
                $seedsToSoil = $this->buildMap($lines);
            } else if(str_starts_with($section, 'soil-to-fertilizer map:')) {
                // soil-to-fertilizer map
                echo "found soil-to-fertilizer map\n";
                $lines = explode("\n", $section);
                array_shift($lines);
                $soilToFertilizer = $this->buildMap($lines);
            } else if(str_starts_with($section, 'fertilizer-to-water map:')) {
                // fertilizer-to-water map
                echo "found fertilizer-to-water map\n";
                $lines = explode("\n", $section);
                array_shift($lines);
                $fertilizerToWater = $this->buildMap($lines);
            } else if(str_starts_with($section, 'water-to-light map:')) {
                // water-to-light map
                echo "found water-to-light map\n";
                $lines = explode("\n", $section);
                array_shift($lines);
                $waterToLight = $this->buildMap($lines);
            } else if(str_starts_with($section, 'light-to-temperature map:')) {
                // light-to-temperature map
                echo "found light-to-temperature map\n";
                $lines = explode("\n", $section);
                array_shift($lines);
                $lightToTemperature = $this->buildMap($lines);
            } else if(str_starts_with($section, 'temperature-to-humidity map:')) {
                // temperature-to-humidity map
                echo "found temperature-to-humidity map\n";
                $lines = explode("\n", $section);
                array_shift($lines);
                $temperatureToHumidity = $this->buildMap($lines);
            } else if(str_starts_with($section, 'humidity-to-location map:')) {
                // humidity-to-location map
                echo "found humidity-to-location map\n";
                $lines = explode("\n", $section);
                array_shift($lines);
                $humidityToLocation = $this->buildMap($lines);
            }
        }

        // the final values are going to be "low"
        // cheat a little by looping through locations up to 1bn
        // go through the map backwards to find out what seed that would have to be
        // if we have that seed, hooray we found the location
        for($i = 0; $i < 1_000_000_000;) {
            $seed = $this->getSeedFromLocation($seedsToSoil, $i, $soilToFertilizer, $fertilizerToWater, $waterToLight, $lightToTemperature, $temperatureToHumidity, $humidityToLocation);
            // do we have this seed?
            if($partTwo) {
                $phaseSize = 1000;
                if(count($seeds) === 2) { // test data, small phases
                    $phaseSize = 10;
                }
                foreach($seeds as $chunk) {
                    if($seed >= $chunk[0] && $seed < $chunk[0]+$chunk[1]) {
                        // broad phase check passed, double check all the locations between here
                        // and the previous $i value to find the exact lowest we have a seed for
                        for($j = $i - $phaseSize; $j < $i; $j++) {
                            $seed = $this->getSeedFromLocation($seedsToSoil, $j, $soilToFertilizer, $fertilizerToWater, $waterToLight, $lightToTemperature, $temperatureToHumidity, $humidityToLocation);
                            foreach($seeds as $chunk) {
                                if ($seed >= $chunk[0] && $seed < $chunk[0] + $chunk[1]) {
                                    return $j;
                                }
                            }
                        }

                        return $i;
                    }
                }
                $i += $phaseSize; // we have a shitload of values to iterate through, go through more than one at a time so we arent here all day
            } else {
                $phaseSize = 1000;
                if(count($seeds) === 4) { // test data, small phases
                    $phaseSize = 10;
                }
                if(in_array($seed, $seeds)) {
                    for($j = $i - $phaseSize; $j < $i; $j++) {
                        $seed = $this->getSeedFromLocation($seedsToSoil, $j, $soilToFertilizer, $fertilizerToWater, $waterToLight, $lightToTemperature, $temperatureToHumidity, $humidityToLocation);
                        if(in_array($seed, $seeds)) {
                            return $j;
                        }
                    }
                    return $i;
                }
                $i += $phaseSize;
            }
        }

        //// now that all of the maps have been created, get the final location of each seed
        //$bestLocation = PHP_INT_MAX;
        //foreach($this->nextSeed($seeds, $partTwo) as $seed) {
        //    $location = $this->getLocation($seedsToSoil, $seed, $soilToFertilizer, $fertilizerToWater, $waterToLight, $lightToTemperature, $temperatureToHumidity, $humidityToLocation);
        //    if($location < $bestLocation) {
        //        $bestLocation = $location;
        //        echo "\tbest location is now $bestLocation\n";
        //    }
        //}
        //
        //// return the lowest location
        //return $bestLocation;
    }

    public function nextSeed($seeds, $partTwo = false) {
        if($partTwo) {
            $chunks = array_chunk($seeds, 2);
            foreach ($chunks as $index => $chunk) {
                echo "starting chunk $index\n";
                for ($i = 0; $i < $chunk[1]; $i++) {
                    yield $chunk[0] + $i;
                }
                echo "ending chunk $index\n";
            }
        } else {
            foreach($seeds as $seed) {
                yield $seed;
            }
        }
    }

    public $sampleInput = <<<HERE
seeds: 79 14 55 13

seed-to-soil map:
50 98 2
52 50 48

soil-to-fertilizer map:
0 15 37
37 52 2
39 0 15

fertilizer-to-water map:
49 53 8
0 11 42
42 0 7
57 7 4

water-to-light map:
88 18 7
18 25 70

light-to-temperature map:
45 77 23
81 45 19
68 64 13

temperature-to-humidity map:
0 69 1
1 0 69

humidity-to-location map:
60 56 37
56 93 4
HERE;

    public function test_first_part_example() {

        $this->assertEquals(35, $this->solve($this->sampleInput));
    }

    public function test_first_part() {
        $input = file_get_contents(__DIR__ . '/data/day5');
        $this->assertEquals(218_513_636, $this->solve($input));
    }

    public function test_second_part_example() {
        $this->assertEquals(46, $this->solve($this->sampleInput, true));
    }

    public function test_second_part() {
        $input = file_get_contents(__DIR__ . '/data/day5');
        $this->assertEquals(81956384, $this->solve($input, true));
    }

    /**
     * @param array $seedsToSoil
     * @param mixed $seed
     * @param array $soilToFertilizer
     * @param array $fertilizerToWater
     * @param array $waterToLight
     * @param array $lightToTemperature
     * @param array $temperatureToHumidity
     * @param array $humidityToLocation
     * @return mixed
     */
    private function getLocation(
        array $seedsToSoil,
        mixed $seed,
        array $soilToFertilizer,
        array $fertilizerToWater,
        array $waterToLight,
        array $lightToTemperature,
        array $temperatureToHumidity,
        array $humidityToLocation
    ) {
        $location = $this->getOutput($seedsToSoil, $seed);
        //echo "seed $seed goes to soil $location\n";

        $location = $this->getOutput($soilToFertilizer, $location);
        //echo "\tgoes to fertilizer $location\n";
        $location = $this->getOutput($fertilizerToWater, $location);
        //echo "\tgoes to water $location\n";

        $location = $this->getOutput($waterToLight, $location);
        //echo "\tgoes to light $location\n";

        $location = $this->getOutput($lightToTemperature, $location);
        //echo "\tgoes to temperature $location\n";

        $location = $this->getOutput($temperatureToHumidity, $location);
        //echo "\tgoes to humidity $location\n";

        $location = $this->getOutput($humidityToLocation, $location);
        //echo "\tgoes to location $location\n";
        return $location;
    }

    /**
     * @param array $seedsToSoil
     * @param mixed $seed
     * @param array $soilToFertilizer
     * @param array $fertilizerToWater
     * @param array $waterToLight
     * @param array $lightToTemperature
     * @param array $temperatureToHumidity
     * @param array $humidityToLocation
     * @return mixed
     */
    private function getSeedFromLocation(
        array $seedsToSoil,
        mixed $location,
        array $soilToFertilizer,
        array $fertilizerToWater,
        array $waterToLight,
        array $lightToTemperature,
        array $temperatureToHumidity,
        array $humidityToLocation
    ) {
        $seed = $this->getInput($humidityToLocation, $location);
        $seed = $this->getInput($temperatureToHumidity, $seed);
        $seed = $this->getInput($lightToTemperature, $seed);
        $seed = $this->getInput($waterToLight, $seed);
        $seed = $this->getInput($fertilizerToWater, $seed);
        $seed = $this->getInput($soilToFertilizer, $seed);
        $seed = $this->getInput($seedsToSoil, $seed);
        return $seed;
        //
        //
        //$location = $this->getOutput($seedsToSoil, $seed);
        ////echo "seed $seed goes to soil $location\n";
        //
        //$location = $this->getOutput($soilToFertilizer, $location);
        ////echo "\tgoes to fertilizer $location\n";
        //$location = $this->getOutput($fertilizerToWater, $location);
        ////echo "\tgoes to water $location\n";
        //
        //$location = $this->getOutput($waterToLight, $location);
        ////echo "\tgoes to light $location\n";
        //
        //$location = $this->getOutput($lightToTemperature, $location);
        ////echo "\tgoes to temperature $location\n";
        //
        //$location = $this->getOutput($temperatureToHumidity, $location);
        ////echo "\tgoes to humidity $location\n";
        //
        //$location = $this->getOutput($humidityToLocation, $location);
        ////echo "\tgoes to location $location\n";
        //return $location;
    }
}
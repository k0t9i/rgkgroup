<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'id' => $index + 1,
    'userId' => 2,
    'senderId' => 1,
    'title' => $faker->sentence(3, true),
    'body' => $faker->sentence(10, true),
    'createdAt' => $faker->dateTimeBetween('-10 day')->format('Y-m-d H:i:s')
];

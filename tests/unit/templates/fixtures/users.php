<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    'id' => $index + 1,
    'username' => $faker->unique()->userName,
    'passwordHash' => Yii::$app->security->generatePasswordHash('password_' . $index),
    'lastname' => $faker->lastName,
    'firstname' => $faker->firstName,
    'email' => $faker->email,
    'createdAt' => $faker->dateTimeBetween('-10 day')->format('Y-m-d H:i:s')
];

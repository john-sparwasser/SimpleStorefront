<?php

namespace NoInc\SimpleStorefrontBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

class LoadLemonadeData extends LoadProductData
{
    public function load(ObjectManager $manager)
    {
        parent::load($manager);
    }

    public function getImageUrl()
    {
        return 'https://s3.amazonaws.com/simplestorefront/71cc5e7213dd5e40864d8acc3effed8d.jpeg';
    }

    public function ingredientArray()
    {
        return [
            [
                "name" => "Lemon",
                "price" => 0.10,
                "measure" => "Juice"
            ],
            [
                "name" => "Sugar",
                "price" => 0.10,
                "measure" => "Cup"
            ],
            [
                "name" => "Water",
                "price" => 0.00,
                "measure" => "Cup"
            ]
        ];
    }

    public function recipeArray()
    {
        return [
            "name" => "Lemonade",
            "price" => 1.00,
            "ingredients" => [
                [
                    "name" => "Lemon",
                    "quantity" => 2
                ],
                [
                    "name" => "Sugar",
                    "quantity" => 0.5
                ],
                [
                    "name" => "Water",
                    "quantity" => 4
                ],
            ]
        ];
    }

    public function getOrder()
    {
        return 3;
    }
}

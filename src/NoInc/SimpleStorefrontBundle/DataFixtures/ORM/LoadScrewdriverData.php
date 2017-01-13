<?php

namespace NoInc\SimpleStorefrontBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

class LoadScrewDriverData extends LoadProductData
{
    public function load(ObjectManager $manager)
    {
        parent::load($manager);
    }

    public function getImageUrl()
    {
        return 'https://s3.amazonaws.com/simplestorefront/881a46cbb2e8735cc370dd1e65d5f711.jpeg';
    }

    public function ingredientArray()
    {
        return [
            [
                "name" => "Vodka",
                "price" => 1,
                "measure" => "Ounce"
            ],
            [
                "name" => "Orange Juice",
                "price" => 0.25,
                "measure" => "Ounce"
            ]
        ];
    }

    public function recipeArray()
    {
        return [
            "name" => "Screwdriver",
            "price" => 5.00,
            "ingredients" => [
                [
                    "name" => "Vodka",
                    "quantity" => 1.75
                ],
                [
                    "name" => "Orange Juice",
                    "quantity" => 3.50
                ],
            ]
        ];
    }

    public function getOrder()
    {
        return 7;
    }
}



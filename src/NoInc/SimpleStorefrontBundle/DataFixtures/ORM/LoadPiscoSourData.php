<?php

namespace NoInc\SimpleStorefrontBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

class LoadOldPiscoSour extends LoadProductData
{
    public function load(ObjectManager $manager)
    {
        parent::load($manager);
    }

    public function getImageUrl()
    {
        return 'https://s3.amazonaws.com/simplestorefront/3c493cde4fa651d61b295cd5a7322f3d.jpeg';
    }

    public function ingredientArray()
    {
        return [
            [
                "name" => "Lemon Juice",
                "price" => 0.25,
                "measure" => "Ounce"
            ],
            [
                "name" => "Egg White",
                "price" => 1.00,
                "measure" => "Count"
            ],
            [
                "name" => "Pisco",
                "price" => 2.25,
                "measure" => "Ounce"
            ],
        ];
    }

    public function recipeArray()
    {
        return [
            "name" => "Pisco Sour",
            "price" => 7.00,
            "ingredients" => [
                [
                    "name" => "Lemon Juice",
                    "quantity" => 1
                ],
                [
                    "name" => "Egg White",
                    "quantity" => 1
                ],
                [
                    "name" => "Pisco",
                    "quantity" => 1.5,
                ],
                [
                    "name" => "Simple Syrup",
                    "quantity" => 0.75,
                ],
            ]
        ];
    }

    public function getOrder()
    {
        return 6;
    }
}

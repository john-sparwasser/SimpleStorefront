<?php

namespace NoInc\SimpleStorefrontBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

class LoadOldFashionedData extends LoadProductData
{
    public function load(ObjectManager $manager)
    {
        parent::load($manager);
    }

    public function getImageUrl()
    {
        return 'https://s3.amazonaws.com/simplestorefront/d338f396007b0400b17a5170a8bb1eb7.jpeg';
    }

    public function ingredientArray()
    {
        return [
            [
                "name" => "Simple Syrup",
                "price" => 0.25,
                "measure" => "Teaspoon"
            ],
            [
                "name" => "Bitters",
                "price" => 1.00,
                "measure" => "Dash"
            ],
            [
                "name" => "Orange Peel",
                "price" => 0.25,
                "measure" => "Count"
            ],
            [
                "name" => "Bourbon",
                "price" => 2.50,
                "measure" => "Ounce"
            ],
            [
                "name" => "Macaschino cherry",
                "price" => 0.25,
                "measure" => "Count"
            ]
        ];
    }

    public function recipeArray()
    {
        return [
            "name" => "Old Fashioned",
            "price" => 7.00,
            "ingredients" => [
                [
                    "name" => "Simple Syrup",
                    "quantity" => 1
                ],
                [
                    "name" => "Bitters",
                    "quantity" => 2
                ],
                [
                    "name" => "Orange Peel",
                    "quantity" => 1,
                ],
                [
                    "name" => "Bourbon",
                    "quantity" => 2,
                ],
                [
                    "name" => "Macaschino cherry",
                    "quantity" => 1,
                ]
            ]
        ];
    }

    public function getOrder()
    {
        return 5;
    }
}

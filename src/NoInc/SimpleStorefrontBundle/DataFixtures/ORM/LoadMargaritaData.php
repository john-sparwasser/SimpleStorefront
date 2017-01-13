<?php

namespace NoInc\SimpleStorefrontBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

class LoadMargaritaData extends LoadProductData
{
    public function load(ObjectManager $manager)
    {
        parent::load($manager);
    }

    public function getImageUrl()
    {
        return 'https://s3.amazonaws.com/simplestorefront/3d3b33479ece1fd24a5e824f6e436efc.jpeg';
    }

    public function ingredientArray()
    {
        return [
            [
                "name" => "Tequila",
                "price" => 2.00,
                "measure" => "Ounce"
            ],
            [
                "name" => "Lime Juice",
                "price" => 0.50,
                "measure" => "Ounce"
            ],
            [
                "name" => "Cointreau",
                "price" => 1.00,
                "measure" => "Ounce"
            ],
            [
                "name" => "Salt",
                "price" => 0.10,
                "measure" => "Teaspoon"
            ]
        ];
    }

    public function recipeArray()
    {
        return [
            "name" => "Margarita",
            "price" => 9.00,
            "ingredients" => [
                [
                    "name" => "Tequila",
                    "quantity" => 2
                ],
                [
                    "name" => "Lime Juice",
                    "quantity" => 1
                ],
                [
                    "name" => "Cointreau",
                    "quantity" => 1
                ],
                [
                    "name" => "Salt",
                    "quantity" => 2,
                ]
            ]
        ];
    }

    public function getOrder()
    {
        return 4;
    }
}

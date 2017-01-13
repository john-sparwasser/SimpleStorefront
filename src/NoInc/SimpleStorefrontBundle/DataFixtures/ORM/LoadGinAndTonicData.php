<?php

namespace NoInc\SimpleStorefrontBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

class LoadGinAndTonicData extends LoadProductData
{
    public function load(ObjectManager $manager)
    {
        parent::load($manager);
    }

    public function getImageUrl()
    {
        return 'https://s3.amazonaws.com/simplestorefront/be49d7fd0215f8d357a42a73d4b21283.jpeg';
    }

    public function ingredientArray()
    {
        return [
            [
                "name" => "Gin",
                "price" => 1.25,
                "measure" => "Ounce"
            ],
            [
                "name" => "Tonic",
                "price" => 0.75,
                "measure" => "Ounce"
            ],
        ];
    }

    public function recipeArray()
    {
        return [
            "name" => "Gin & Tonic",
            "price" => 6.00,
            "ingredients" => [
                [
                    "name" => "Gin",
                    "quantity" => 2
                ],
                [
                    "name" => "Tonic",
                    "quantity" => 3
                ],
            ]
        ];
    }

    public function getOrder()
    {
        return 2;
    }
}


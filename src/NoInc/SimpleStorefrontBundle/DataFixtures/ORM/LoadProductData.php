<?php

namespace NoInc\SimpleStorefrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NoInc\SimpleStorefrontBundle\Entity\User;
use NoInc\SimpleStorefrontBundle\Entity\Ingredient;
use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use NoInc\SimpleStorefrontBundle\Entity\RecipeIngredient;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class LoadProductData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;
    protected abstract function ingredientArray();
    protected abstract function recipeArray();

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function load(ObjectManager $manager)
    {
        $ingredients = [];
        foreach ( $this->ingredientArray() as $ingredientData )
        {
            $ingredient = new Ingredient();

            $ingredient->setName($ingredientData["name"]);
            $ingredient->setPrice($ingredientData["price"]);
            $ingredient->setMeasure($ingredientData["measure"]);
            $ingredient->setStock(100);

            $manager->persist($ingredient);

            $ingredients[$ingredient->getName()] = $ingredient;
        }
        $manager->flush();

        $recipeData = $this->recipeArray();

        $recipe = new Recipe();
        $recipe->setName($recipeData["name"]);
        $recipe->setPrice($recipeData["price"]);
        $recipe->setImageUrl($this->getImageUrl());
        $manager->persist($recipe);
        $manager->flush();

        $repo = $this->getContainer()->get('doctrine')->getRepository('NoIncSimpleStorefrontBundle:Ingredient');

        foreach( $recipeData["ingredients"] as $recipeIngredientData )
        {
            $recipeIngredient = new RecipeIngredient();

            if (isset($ingredients[$recipeIngredientData["name"]])) {
                $recipeIngredient->setIngredient($ingredients[$recipeIngredientData["name"]]);
            } else {
                $ingredient = $repo->getIngredientByName($recipeIngredientData["name"]);
                $recipeIngredient->setIngredient($ingredient);
            }
            $recipeIngredient->setRecipe($recipe);
            $recipeIngredient->setQuantity($recipeIngredientData["quantity"]);
            $manager->persist($recipeIngredient);
        }
        $manager->flush();
    }
}

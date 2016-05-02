<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 3.0.2 (doctrine2-annotation) on 2016-05-02 04:02:02.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace NoInc\SimpleStorefrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoInc\SimpleStorefrontBundle\Entity\RecipeIngredient
 *
 * @ORM\Entity(repositoryClass="NoInc\SimpleStorefrontBundle\Repository\RecipeIngredientRepository")
 * @ORM\Table(name="recipe_ingredient", indexes={@ORM\Index(name="fk_recipe_inventory_recipe_idx", columns={"recipe_id"}), @ORM\Index(name="fk_recipe_inventory_inventory_idx", columns={"ingredient_id"})})
 */
class RecipeIngredient
{
    /**
     * ID of the Recipe's Ingredient
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * ID of the Recipe associated with the Recipe Igredient
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $recipe_id;

    /**
     * ID of the Inventory associated with the Recipe Ingredient
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $ingredient_id;

    /**
     * Amount of the Ingredient the Recipe requires
     *
     * @ORM\Column(type="float", nullable=false)
     */
    protected $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="recipeIngredients")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id", nullable=false)
     */
    protected $recipe;

    /**
     * @ORM\ManyToOne(targetEntity="Ingredient", inversedBy="recipeIngredients")
     * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id", nullable=false)
     */
    protected $ingredient;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \NoInc\SimpleStorefrontBundle\Entity\RecipeIngredient
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of recipe_id.
     *
     * @param integer $recipe_id
     * @return \NoInc\SimpleStorefrontBundle\Entity\RecipeIngredient
     */
    public function setRecipeId($recipe_id)
    {
        $this->recipe_id = $recipe_id;

        return $this;
    }

    /**
     * Get the value of recipe_id.
     *
     * @return integer
     */
    public function getRecipeId()
    {
        return $this->recipe_id;
    }

    /**
     * Set the value of ingredient_id.
     *
     * @param integer $ingredient_id
     * @return \NoInc\SimpleStorefrontBundle\Entity\RecipeIngredient
     */
    public function setIngredientId($ingredient_id)
    {
        $this->ingredient_id = $ingredient_id;

        return $this;
    }

    /**
     * Get the value of ingredient_id.
     *
     * @return integer
     */
    public function getIngredientId()
    {
        return $this->ingredient_id;
    }

    /**
     * Set the value of quantity.
     *
     * @param float $quantity
     * @return \NoInc\SimpleStorefrontBundle\Entity\RecipeIngredient
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of quantity.
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set Recipe entity (many to one).
     *
     * @param \NoInc\SimpleStorefrontBundle\Entity\Recipe $recipe
     * @return \NoInc\SimpleStorefrontBundle\Entity\RecipeIngredient
     */
    public function setRecipe(Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get Recipe entity (many to one).
     *
     * @return \NoInc\SimpleStorefrontBundle\Entity\Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set Ingredient entity (many to one).
     *
     * @param \NoInc\SimpleStorefrontBundle\Entity\Ingredient $ingredient
     * @return \NoInc\SimpleStorefrontBundle\Entity\RecipeIngredient
     */
    public function setIngredient(Ingredient $ingredient = null)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get Ingredient entity (many to one).
     *
     * @return \NoInc\SimpleStorefrontBundle\Entity\Ingredient
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    public function __sleep()
    {
        return array('id', 'recipe_id', 'ingredient_id', 'quantity');
    }
}
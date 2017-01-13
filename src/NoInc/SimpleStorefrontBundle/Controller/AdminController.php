<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NoInc\SimpleStorefrontBundle\Entity\Ingredient;
use NoInc\SimpleStorefrontBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use NoInc\SimpleStorefrontBundle\Objects\AWSImageUploader;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin")
 */
class AdminController extends BaseController
{
    /**
     * @Route("/", name="admin_home")
     * @Method("GET")
     */
    public function getAction()
    {
        $orm = $this->getDoctrine();
        $recipes = $orm->getRepository('NoIncSimpleStorefrontBundle:Recipe')->getRecipesAndIngredients();
        $ingredients = $orm->getRepository('NoIncSimpleStorefrontBundle:Ingredient')->getAll();

        $renderData = [];

        $renderData['title'] = 'A Simple Storefront';
        $renderData['recipes'] = $recipes;
        $renderData['ingredients'] = $ingredients;
        $renderData['header'] = $this->getHeaderHelper();
        $renderData['header']->hideDashboardButton();
        $renderData['cart_helper'] = false;

        return $this->render('NoIncSimpleStorefrontBundle:Default:admin.html.twig', $renderData);
    }

    /**
     * @Route("/make/{recipe_id}", name="make_recipe")
     * @Method("POST")
     * @ParamConverter("recipe", class="NoIncSimpleStorefrontBundle:Recipe", options={"mapping": {"recipe_id": "id"}})
     */
    public function postMakeRecipeAction(Recipe $recipe)
    {
        $enoughIngredients = true;
        $recipeIngredients = $recipe->getRecipeIngredients();
        $ingredientsToSave = [];

        // Loop through the recipe ingredients and subtract the amounts from our ingredient stock
        // If one of our amounts goes below zero we don't have enough and we break early
        foreach($recipeIngredients as $recipeIngredient) {
            $ingredient = $recipeIngredient->getIngredient();
            $ingredient->setStock($ingredient->getStock() - $recipeIngredient->getQuantity());
            if ($ingredient->getStock() < 0) {
                $enoughIngredients = false;
                break;
            }
            $ingredientsToSave[] = $ingredient;
        }
        // If we don't have enough ingredients we redirect to admin home
        if (!$enoughIngredients) {
            return $this->redirectToRoute('admin_home');
        }

        // We pass each ingredient to the entity manager to be saved.
        foreach($ingredientsToSave as $ingredient) {
            $this->getDoctrine()->getEntityManager()->persist($ingredient);
        }
        $product = new Product();
        $product->setCreatedAt(time());
        $product->setRecipe($recipe);
        $this->getDoctrine()->getEntityManager()->persist($product);
        $this->getDoctrine()->getEntityManager()->flush();

        return $this->redirectToRoute('admin_home');
    }

    /**
     * @Route("/upload_image/{recipe_id}", name="upload_image")
     * @Method("POST")
     * @ParamConverter("recipe", class="NoIncSimpleStorefrontBundle:Recipe", options={"mapping": {"recipe_id": "id"}})

     */
    public function postMakeUploadAction(Recipe $recipe, Request $request)
    {
        $file = $request->files->get('image_file');
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $uploader = new AWSImageUploader($this->container->getParameter('aws_config'));
        $filename = $uploader->upload(file_get_contents($file->getPathname()), $fileName);

        if ($filename) {
            $recipe->setImageUrl($filename);
            $this->getDoctrine()->getEntityManager()->persist($recipe);
            $this->getDoctrine()->getEntityManager()->flush();
        }

        return $this->redirectToRoute('admin_home');
    }
}

<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use NoInc\SimpleStorefrontBundle\Objects\AWSImageUploader;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class AdminImageController extends BaseController
{
    /**
     * @Route("/admin/upload_image/{recipe_id}", name="upload_image")
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


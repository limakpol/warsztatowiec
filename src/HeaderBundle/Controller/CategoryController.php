<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/24/17
 * Time: 5:53 AM
 */

namespace HeaderBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $categoryHelper = $this->get('header.helper.category');

        $categories = $categoryHelper->getCategories();

        return $this->render('HeaderBundle::category.html.twig', [
            'categories' => $categories,
        ]);
    }

    public function addAction()
    {
        $categoryHelper = $this->get('header.helper.category');

        if(!$categoryHelper->isRequestCorrect())
        {
            return $categoryHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$categoryHelper->isValid())
        {
            return $categoryHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if($categoryHelper->categoryExists())
        {
            return $categoryHelper->getErrorMessage('Taka kategoria już istnieje');
        }

        if(null !== ($category = $categoryHelper->categoryExistsRemoved()))
        {
            $categoryHelper->restore($category);

            return $this->indexAction();
        }

        $categoryHelper->write();

        return $this->indexAction();
    }

    public function editAction()
    {
        $categoryHelper = $this->get('header.helper.category');

        if(!$categoryHelper->isRequestCorrect())
        {
            return $categoryHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($category = $categoryHelper->getOne()))
        {
            return $categoryHelper->getErrorMessage('Wybrana kategoria nie istnieje');
        }

        $categoryHelper->edit($category);

        return $categoryHelper->getSuccessMessage();
    }

    public function removeAction()
    {
        $categoryHelper = $this->get('header.helper.category');

        if(!$categoryHelper->isRequestCorrect())
        {
            return $categoryHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($category = $categoryHelper->getOne()))
        {
            return $categoryHelper->getErrorMessage('Wybrana kategoria nie istnieje');
        }

        $categoryHelper->remove($category);

        return $this->indexAction();
    }
}
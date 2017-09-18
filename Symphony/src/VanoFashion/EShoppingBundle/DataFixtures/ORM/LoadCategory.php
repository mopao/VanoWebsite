<?php 

namespace VanoFashion\EShoppingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VanoFashion\EShoppingBundle\Entity\itemCategory;


class LoadCategory implements FixtureInterface
{
  
  public function load(ObjectManager $manager)
  {
    // List of category names
    $names = array(
      'clothings',
      'shoes',
      'others'
    );

    foreach ($names as $name) {
      // On crée la catégorie
      $category = new itemCategory();
      $category->setName($name);

      // On la persiste
      $manager->persist($category);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}
<?php

namespace VanoFashion\EShoppingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VanoFashion\EShoppingBundle\Entity\itemType;


class LoaditemType implements FixtureInterface
{
  
  public function load(ObjectManager $manager)
  {
    // List of category names
    $types = array(
      'men',
      'women',
      'unisex'
    );

    foreach ($types as $type) {
      // On crée la catégorie
      $itemType = new itemType();
      $itemType->settype($type);

      // On la persiste
      $manager->persist($itemType);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}
<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    Const CATEGORIES =[
        'Action',
        'Actualité',
        'Anime',
        'Animation',
        'Arts martiaux',
        'Aventure',
        'Comédie',
        'Comédie musicale',
        'Crime',
        'Cuisine ',
        'Documentaire',
        'Drame',
        'Enfant',
        'Famille',
        'Fantistique',
        'Game Show',
        'Guerre',
        'Histoire',
        'Indie',
        'Intérêt particulier',
        'Maison et jardinange',
        'Mini-série',
        'Mystère',
        'Podcast',
        'Romance',
        'Science-fiction',
        'Soap',
        'Sport',
        'Suspense',
        'Talk Show',
        'Thriller',
        'Télé-réalité',
        'Voyage',
        'Western',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key =>$categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('categorie_' . $key, $category);
        }
        $manager->flush();
    }


}

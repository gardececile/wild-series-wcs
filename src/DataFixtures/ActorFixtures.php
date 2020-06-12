<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture
{
    Const ACTORS =[
        'Calley Fleming',
        'Noah Emmerich',
        'Adam Minarovich',
        'Paola Lazaro',
        'Madison Lintz',
        'Jeryl Prescott Sales',
        'Alycia Debnam-Carey',
    ];

//    public function getDependencies()
//    {
//        return [ProgramFixtures::class];
//    }

    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $key =>$name) {
            $actor = new Actor();
            $actor->setName($name);
            $manager->persist($actor);
            $this->addReference('acteur_' . $key, $actor);
        }
        $manager->flush();
    }


}

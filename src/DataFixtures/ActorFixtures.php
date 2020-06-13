<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    Const ACTORS =[
        'Calley Fleming',
        'Noah Emmerich',
        'Adam Minarovich',
        'Paola Lazaro',
        'Madison Lintz',
        'Jeryl Prescott Sales',
    ];

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

    public function load(ObjectManager $manager)
    {

        foreach (self::ACTORS as $key => $name) {
                $actor = new Actor();
                $actor->setName($name);
                $manager->persist($actor);
                $actor->addProgram($this->getReference('program' .$key));
            }
        $faker = Faker\Factory::create('fr_FR');
        $i=0;
        for ($i=0;$i<50;$i++) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $manager->persist($actor);
            $this->addReference('acteur_'.$i, $actor);
            $actor->addProgram($this->getReference('program' . $i%6));
            }
        $manager->flush();
    }


}

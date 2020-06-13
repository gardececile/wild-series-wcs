<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
       $faker = Faker\Factory::create('fr_FR');

        for ($i=0;$i<50;$i++) {
            $season = new Season();
            $season->setNumber($faker->randomDigitNotNull);
            $season->setYear($faker->year);
            $season->setDescription(($faker->paragraph($nbSentences = 3, $variableNbSentences = true)));
            $manager->persist($season);
            $this->addReference('season_'.$i, $season);
            $season->setProgram($this->getReference('program' . $i%6));
            }
        $manager->flush();
    }


}

<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
       $faker = Faker\Factory::create('fr_FR');

        for ($i=0;$i<500;$i++) {
            $episode = new Episode();
            $episode->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true));
            $episode->setNumber($faker->randomDigitNotNull);
            $episode->setSynopsis($faker->paragraph($nbSentences = 3, $variableNbSentences = true));
            $manager->persist($episode);
            $episode->setSeason($this->getReference('season_'. $i%50));
            }
        $manager->flush();
    }


}

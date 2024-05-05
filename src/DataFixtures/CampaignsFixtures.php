<?php
// src/DataFixtures/CampaignsFixtures.php

namespace App\DataFixtures;

use App\Entity\Campaigns;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampaignsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {   
        $user1 = new User();
        $user1->setFullname('RoumaissaFezai');
        $user1->setEmail('rou@gmail.com');
        $user1->setPassword("111");
        $manager->persist($user1);
        $user2 = new User();
        $user2->setFullname('RoumaissaFezai2');
        $user2->setEmail('rou2@gmail.com');
        $user2->setPassword("112");
        $manager->persist($user2);

        
        $campaign1 = new Campaigns();
        $campaign1->setCampaignName("Help the people of Gaza");
        $campaign1->setDescription('Civilians are paying a horrific price for the ongoing war.');
        $imageUrl = 'Campaign1.jpg';
        $campaign1->setImage($imageUrl);
        $campaign1->setOwnerID($user1);
        $campaign1->setBudget(1000);
        $manager->persist($campaign1);

        $campaign2 = new Campaigns();
        $campaign2->setCampaignName("Raising funds to evacuate civilians from Gaza");
        $campaign2->setDescription("Here are directions and tips if you want to raise money for those trying to leave Gaza.");
        $imageUrl ='Campaign2.jpg';
        $campaign2->setImage($imageUrl);
        $campaign2->setBudget(2000);
        $campaign2->setOwnerID($user2);
        $manager->persist($campaign2);



        $manager->flush();
    }
}

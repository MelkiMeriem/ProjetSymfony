<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;



class UserFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $admin1 = new User();
        $admin1->setFullname("Admin1");
        $admin1->setEmail("admin1@admin1.com");
        $admin1->setPassword(password_hash("admin1", PASSWORD_DEFAULT));
        $admin1->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin1);

        for ($i=0; $i < 5; $i++) {
            $user=new User();

            $user->setFullname("user".$i);
            $user->setEmail("user".$i."@gmail.com");
            $user->setPassword(password_hash("user".$i, PASSWORD_DEFAULT));
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);

        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return  ['user'];
    }
}

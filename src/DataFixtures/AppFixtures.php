<?php

	namespace App\DataFixtures;

	use App\Entity\User;
	use Doctrine\Bundle\FixturesBundle\Fixture;
	use Doctrine\Persistence\ObjectManager;

	class AppFixtures extends Fixture
	{
		const DEFULT_PASS='$2y$13$k5baGNSL1yrUP/0pMp/KGe5GifV/QkzZQj5Xm6T9i8l9s9SP2/Nmy'; //123456
		public function load(ObjectManager $manager)
		{
			// create 20 products! Bam!
			for ($i = 0; $i < 20; $i++) {
				$user = new User("User$i");
				$user->setUsername("User$i");
				$user->setPassword(self::DEFULT_PASS);
				$user->setEmail("email_user$i@gmail.com");
				$manager->persist($user);
			}

			$manager->flush();
		}
	}

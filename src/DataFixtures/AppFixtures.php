<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setEmail('gillard.cecile@ltpdampierre.fr');
        $user->setNom('Gillard');
        $user->setPrenom('Cécile');
        $user->setPassword($this->hasher->hashPassword($user, 'password'));

        $manager->persist($user);

        $categories = ["Cuisine", "Sport", "Symfony", "PHP"];
        $objsCat = [];
        foreach ($categories as $cat) {

            $categorie = new Categorie();
            $categorie->setNom($cat);
            $manager->persist($categorie);
            $objsCat[] = $categorie;
        }

        $article = new Article();
        $article->setTitre('Mon premier article');
        $article->setContenu('Ceci est mon premier article');
        $article->setAuteur($user);
        $article->setCategorie($objsCat[1]);
        $article->setImage("mvc-6ad07e89b43a9.png");
        $manager->persist($article);


        $manager->flush();
    }
}

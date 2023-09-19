<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\User;
use DateTimeImmutable;
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
        // User
        $user_admin = new User();
        $user_admin->setEmail('admin@example.com');
        $password = $this->hasher->hashPassword($user_admin, 'password');
        $user_admin->setPassword($password);
        $user_admin->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user_admin);

        $users = [];

        for($i = 1; $i < 4; $i++) {
            $u = new User();
            $u->setEmail("user_$i@example.com");
            $password = $this->hasher->hashPassword($u, 'password');
            $u->setPassword($password);

            $manager->persist($u);
            $users[] = $u;
        }
        
        // Category
        $category_data = [
            'Sport',
            'Science-fiction',
            'Aventure',
            'Action',
            'Documentaire',
            'Horreur',
            'Jeunes',
            'Voiture'
        ];

        $categories = [];

        foreach($category_data as $category) {
            $c = new Category();
            $c->setLabel($category);

            $manager->persist($c);
            $categories[$category] = $c;
        }

        // Movies
        $movies_data = [
            [
                'name' => 'Fast and Furious 1',
                'description' => "Dominic Toretto est un ex-prisonnier de la prison de Lompoc qui est désormais pilote de courses de rue. Il est entouré d'une bande, qu'il considère comme sa famille, composée de Letty, Vince, Jesse, Leon et de sa sœur Mia Toretto.",
                'age_restriction' => 12,
                'publication_date' => "01/01/2001",
                'categories' => ['Action','Voiture']
            ],
            [
                'name' => 'Le Parrain',
                'description' => "À la fin de l’été 1945, dans sa résidence de Long Island dans l’État de New York, Don Vito Corleone, surnommé « le Parrain », est le chef de la famille Corleone, une organisation criminelle appartenant à la mafia américaine. Entouré de toute sa famille et d'invités, le Don organise chez lui le mariage de sa fille Constanzia (dite « Connie ») à Carlo Rizzi, un des bookmaker (organisateur de paris sportifs clandestins) faisant partie de la « famille » Corleone.",
                'age_restriction' => 15,
                'publication_date' => "01/10/1972",
                'categories' => ['Action','Aventure']
            ],
            [
                'name' => 'Saw 1',
                'description' => "À la fin de l’été 1945, dans sa résidence de Long Island dans l’État de New York, Don Vito Corleone, surnommé « le Parrain », est le chef de la famille Corleone, une organisation criminelle appartenant à la mafia américaine. Entouré de toute sa famille et d'invités, le Don organise chez lui le mariage de sa fille Constanzia (dite « Connie ») à Carlo Rizzi, un des bookmaker (organisateur de paris sportifs clandestins) faisant partie de la « famille » Corleone.",
                'age_restriction' => 16,
                'publication_date' => "01/10/2004",
                'categories' => ['Horreur']
            ],
            [
                'name' => 'Interstellar',
                'description' => "En 2067, la Terre est devenue de moins en moins accueillante pour l'humanité plongée dans une grave crise alimentaire. Une humanité tellement résignée sur son destin que les écoles enseignent que les missions Apollo n'eurent pas lieu et n'étaient que des impostures destinées à ruiner l'URSS. Cooper, ancien pilote de la NASA devenu agriculteur, vit dans une ferme avec sa famille.",
                'age_restriction' => 10,
                'publication_date' => "16/05/2014",
                'categories' => ['Science-fiction']
            ]
        ];

        $movies = [];

        foreach($movies_data as $movie) {
            $m = new Movie();
            $m->setName($movie['name']);
            $m->setDescription($movie['description']);
            $m->setAgeRestriction($movie['age_restriction']);
            $m->setPublicationDate(DateTimeImmutable::createFromFormat('j/m/Y', $movie['publication_date']));
        
            foreach($movie['categories'] as $c_label) {
                if(!isset($categories[$c_label])) {
                    continue;
                }

                $m->addCategory($categories[$c_label]);
            }

            $manager->persist($m);
            $movies[$movie['name']] = $m;
        }

        $manager->flush();
    }
}

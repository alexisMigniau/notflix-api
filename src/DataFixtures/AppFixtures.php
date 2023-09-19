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
        
        $categories = [];

        // Movies - Merci chatgpt pour la génération
        $movies_data = [
            [
                'name' => "Les Secrets de l'Univers",
                'description' => "Un film captivant qui explore les mystères de l'espace et de la cosmologie.",
                'publication_date' => '15-01-2023',
                'age_restriction' => 12,
                'categories' => ['Science-fiction', 'Documentaire', 'Aventure']
            ],
            [
                'name' => "Le Mystère du Manoir Hanté",
                'description' => "Un film d'horreur palpitant mettant en scène des phénomènes paranormaux dans un vieux manoir isolé.",
                'publication_date' => '22-03-2023',
                'age_restriction' => 18,
                'categories' => ['Horreur', 'Suspense']
            ],
            [
                'name' => "L'Évasion de l'Île Maudite",
                'description' => "Un thriller palpitant où un groupe de naufragés doit trouver un moyen de quitter une île dangereuse.",
                'publication_date' => '10-05-2023',
                'age_restriction' => 14,
                'categories' => ['Action', 'Aventure', 'Suspense']
            ],
            [
                'name' => "La Quête du Trésor Perdu",
                'description' => "Un film d'aventure palpitant où des explorateurs partent à la recherche d'un trésor légendaire.",
                'publication_date' => '28-06-2023',
                'age_restriction' => 10,
                'categories' => ['Aventure']
            ],
            [
                'name' => "Complot Politique",
                'description' => "Un thriller politique où un journaliste découvre un complot dangereux au plus haut niveau du gouvernement.",
                'publication_date' => '17-08-2023',
                'age_restriction' => 16,
                'categories' => ['Suspense', 'Drame']
            ],
            [
                'name' => "Le Retour des Dinosaures",
                'description' => "Un film de science-fiction où des dinosaures reviennent à la vie et menacent l'humanité.",
                'publication_date' => '05-11-2023',
                'age_restriction' => 12,
                'categories' => ['Science-fiction', 'Action']
            ],
            [
                'name' => "L'Énigme du Sphinx",
                'description' => "Un mystère historique où un archéologue tente de résoudre les secrets du Sphinx en Égypte ancienne.",
                'publication_date' => '12-02-2023',
                'age_restriction' => 14,
                'categories' => ['Mystère', 'Aventure']
            ],
            [
                'name' => "Chasse à l'Homme",
                'description' => "Un thriller haletant où un fugitif traqué par la police tente de prouver son innocence.",
                'publication_date' => '30-04-2023',
                'age_restriction' => 16,
                'categories' => ['Action', 'Suspense']
            ],
            [
                'name' => "Le Secret du Monde Sous-Marin",
                'description' => "Un documentaire fascinant qui explore les profondeurs des océans et la vie marine.",
                'publication_date' => '08-07-2023',
                'age_restriction' => 8,
                'categories' => ['Documentaire']
            ],
            [
                'name' => "L'Évasion de la Prison",
                'description' => "Un film de prison tendu où un groupe de détenus planifie une évasion audacieuse.",
                'publication_date' => '19-09-2023',
                'age_restriction' => 16,
                'categories' => ['Action', 'Suspense']
            ],
            [
                'name' => "Odyssée dans l'Espace",
                'description' => "Un voyage épique à travers le cosmos à la découverte de nouvelles frontières de l'humanité.",
                'publication_date' => '21-10-2023',
                'age_restriction' => 10,
                'categories' => ['Science-fiction', 'Aventure']
            ],
            [
                'name' => "Le Dernier Survivant",
                'description' => "Un film post-apocalyptique où un homme lutte pour sa survie dans un monde dévasté par une pandémie.",
                'publication_date' => '14-12-2023',
                'age_restriction' => 18,
                'categories' => ['Science-fiction', 'Drame', 'Action']
            ],
            [
                'name' => "L'Art du Cambriolage",
                'description' => "Un film de braquage sophistiqué où une équipe de voleurs tente de voler une collection d'œuvres d'art précieuses.",
                'publication_date' => '09-02-2023',
                'age_restriction' => 14,
                'categories' => ['Suspense', 'Action']
            ],
            [
                'name' => "L'Explorateur Solitaire",
                'description' => "Un aventurier solitaire se lance dans une expédition périlleuse à travers les jungles inexplorées.",
                'publication_date' => '27-06-2023',
                'age_restriction' => 12,
                'categories' => ['Aventure']
            ],
            [
                'name' => "Le Fantôme de la Forêt",
                'description' => "Un film d'horreur où un groupe de campeurs est traqué par une entité maléfique dans une forêt isolée.",
                'publication_date' => '03-04-2023',
                'age_restriction' => 16,
                'categories' => ['Horreur', 'Suspense']
            ],
            [
                'name' => "L'Intrigue Politique",
                'description' => "Un drame politique complexe où les jeux de pouvoir et de manipulation sont à leur comble.",
                'publication_date' => '19-11-2023',
                'age_restriction' => 16,
                'categories' => ['Drame', 'Suspense']
            ],
            [
                'name' => "La Planète Perdue",
                'description' => "Un film de science-fiction où une expédition spatiale découvre une planète étrange et hostile.",
                'publication_date' => '10-09-2023',
                'age_restriction' => 12,
                'categories' => ['Science-fiction', 'Aventure']
            ]
        ];

        $movies = [];

        foreach($movies_data as $movie) {
            $m = new Movie();
            $m->setName($movie['name']);
            $m->setDescription($movie['description']);
            $m->setAgeRestriction($movie['age_restriction']);
            $m->setPublicationDate(DateTimeImmutable::createFromFormat('j-m-Y', $movie['publication_date']));
        
            foreach($movie['categories'] as $c_label) {
                if(!isset($categories[$c_label])) {
                    // Création de la catégorie à la volée
                    $c = new Category();
                    $c->setLabel($c_label);
                    $manager->persist($c);

                    $categories[$c_label] = $c;
                }

                $m->addCategory($categories[$c_label]);
            }

            $manager->persist($m);
            $movies[$movie['name']] = $m;
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Serie;
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
                'name' => "Inception",
                'description' => "Dom Cobb est un voleur expérimenté qui vole les secrets les plus intimes enfouis dans l'esprit des gens pendant qu'ils rêvent.",
                'publication_date' => "22-07-2010",
                'age_restriction' => 12,
                'categories' => ["Sci-Fi", "Action", "Thriller"]
            ],
            [
                'name' => "Les Évadés",
                'description' => "Deux prisonniers, Andy Dufresne et Ellis Redding, développent une amitié profonde alors qu'ils passent des années derrière les barreaux à Shawshank.",
                'publication_date' => "20-10-1995",
                'age_restriction' => 16,
                'categories' => ["Drame", "Crime"]
            ],
            [
                'name' => "Le Parrain",
                'description' => "L'histoire épique de la famille mafieuse Corleone et de son patriarche, Don Vito Corleone, qui tente de léguer son empire à son fils, Michael.",
                'publication_date' => "26-09-1972",
                'age_restriction' => 18,
                'categories' => ["Drame", "Crime"]
            ],
            [
                'name' => "Pulp Fiction",
                'description' => "Les histoires entremêlées de gangsters, de boxeurs, de tueurs à gages et d'autres personnages sombres à Los Angeles.",
                'publication_date' => "14-10-1994",
                'age_restriction' => 18,
                'categories' => ["Crime", "Drame"]
            ],
            [
                'name' => "The Dark Knight",
                'description' => "Batman affronte le Joker, un criminel psychotique, tandis que Gotham City sombre dans le chaos.",
                'publication_date' => "18-07-2008",
                'age_restriction' => 12,
                'categories' => ["Action", "Crime", "Thriller"]
            ],
            [
                'name' => "Interstellar",
                'description' => "Un groupe d'explorateurs entreprend un voyage interstellaire pour trouver une nouvelle planète habitable pour l'humanité.",
                'publication_date' => "05-11-2014",
                'age_restriction' => 12,
                'categories' => ["Sci-Fi", "Drame"]
            ],
            [
                'name' => "La La Land",
                'description' => "L'histoire d'amour entre un pianiste de jazz passionné et une actrice débutante à Los Angeles.",
                'publication_date' => "25-12-2016",
                'age_restriction' => 0,
                'categories' => ["Comédie musicale", "Drame", "Romance"]
            ],
            [
                'name' => "Le Seigneur des Anneaux",
                'description' => "Un groupe de neuf compagnons se lance dans une quête pour détruire un anneau magique maléfique et sauver la Terre du Milieu.",
                'publication_date' => "19-12-2001",
                'age_restriction' => 12,
                'categories' => ["Fantasy", "Aventure"]
            ],
            [
                'name' => "Forrest Gump",
                'description' => "L'histoire de Forrest Gump, un homme simple d'esprit qui se retrouve impliqué dans des événements marquants de l'histoire américaine.",
                'publication_date' => "05-10-1994",
                'age_restriction' => 12,
                'categories' => ["Drame", "Romance"]
            ],
            [
                'name' => "Avatar",
                'description' => "Un ancien marine paraplégique est envoyé sur la planète Pandora, où il devient impliqué dans un conflit entre les habitants locaux et les colons humains.",
                'publication_date' => "16-12-2009",
                'age_restriction' => 12,
                'categories' => ["Sci-Fi", "Action", "Aventure"]
            ],
            [
                'name' => "Le Roi Lion",
                'description' => "Simba, un jeune lionceau, doit affronter son destin et reprendre sa place légitime en tant que roi de la Terre des Lions.",
                'publication_date' => "15-06-1994",
                'age_restriction' => 0,
                'categories' => ["Animation", "Aventure", "Famille"]
            ],
            [
                'name' => "Gladiator",
                'description' => "Le général romain Maximus est trahi et forcé de devenir un gladiateur, cherchant à se venger de l'empereur qui a assassiné sa famille.",
                'publication_date' => "05-05-2000",
                'age_restriction' => 16,
                'categories' => ["Action", "Drame"]
            ],
            [
                'name' => "Le Loup de Wall Street",
                'description' => "L'histoire vraie de Jordan Belfort, un courtier en bourse qui devient impliqué dans la fraude massive à Wall Street dans les années 90.",
                'publication_date' => "25-12-2013",
                'age_restriction' => 18,
                'categories' => ["Biographie", "Comédie", "Crime"]
            ],
            [
                'name' => "Avengers: Endgame",
                'description' => "Les super-héros de l'univers Marvel s'unissent pour affronter Thanos et tenter de restaurer l'équilibre de l'univers après le claquement de doigts.",
                'publication_date' => "24-04-2019",
                'age_restriction' => 12,
                'categories' => ["Action", "Aventure", "Fantasy"]
            ],
            [
                'name' => "Inglourious Basterds",
                'description' => "Pendant la Seconde Guerre mondiale, un groupe de soldats juifs américains est chargé de semer la terreur parmi les troupes allemandes.",
                'publication_date' => "20-08-2009",
                'age_restriction' => 16,
                'categories' => ["Guerre", "Drame"]
            ],
            [
                'name' => "Le Cinquième Élément",
                'description' => "Dans un futur lointain, un chauffeur de taxi et une jeune femme mystérieuse sont les clés pour sauver la Terre d'une menace imminente.",
                'publication_date' => "07-05-1997",
                'age_restriction' => 12,
                'categories' => ["Sci-Fi", "Action"]
            ],
            [
                'name' => "Fight Club",
                'description' => "Un homme sans nom et un vendeur de savon créent un club secret où les hommes peuvent se battre pour se sentir vivants.",
                'publication_date' => "15-10-1999",
                'age_restriction' => 18,
                'categories' => ["Drame", "Thriller"]
            ],
            [
                'name' => "Les Indestructibles",
                'description' => "Une famille de super-héros retirés est forcée de reprendre du service pour sauver le monde d'un nouveau méchant redoutable.",
                'publication_date' => "05-11-2004",
                'age_restriction' => 0,
                'categories' => ["Animation", "Action", "Aventure"]
            ]
        ];

        $movies = [];

        foreach($movies_data as $movie) {
            $m = new Movie();
            $m->setName($movie['name']);
            $m->setDescription($movie['description']);
            $m->setAgeRestriction($movie['age_restriction']);
            $m->setPublicationDate(DateTimeImmutable::createFromFormat('j-m-Y', $movie['publication_date']));

            if(isset($movie['image'])) {
               $m->setImage($movie['image']); 
            }
        
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

        // Series - Merci chatgpt pour la génération
        $series_data = [
            [
                'name' => "Breaking Bad",
                'description' => "Un professeur de chimie se tourne vers la fabrication de méthamphétamine pour subvenir aux besoins de sa famille après un diagnostic de cancer.",
                'age_restriction' => 18,
                'categories' => ["Drame", "Crime", "Thriller"]
            ],
            [
                'name' => "Game of Thrones",
                'description' => "Dans un royaume fictif, des familles nobles luttent pour le contrôle du Trône de Fer et du royaume des Sept Couronnes.",
                'age_restriction' => 18,
                'categories' => ["Fantasy", "Drame", "Aventure"]
            ],
            [
                'name' => "Stranger Things",
                'description' => "À Hawkins, dans l'Indiana, un groupe d'enfants se heurte à des phénomènes surnaturels et à un laboratoire secret.",
                'age_restriction' => 12,
                'categories' => ["Sci-Fi", "Horreur", "Drame"]
            ],
            [
                'name' => "Sherlock",
                'description' => "Le célèbre détective Sherlock Holmes résout des crimes complexes à Londres avec l'aide de son ami, le Dr. John Watson.",
                'age_restriction' => 16,
                'categories' => ["Drame", "Mystère", "Crime"]
            ],
            [
                'name' => "Friends",
                'description' => "Un groupe d'amis vit ensemble à New York et partage les joies et les défis de la vie quotidienne.",
                'age_restriction' => 0,
                'categories' => ["Comédie", "Romance"]
            ],
            [
                'name' => "The Office",
                'description' => "Une série de style documentaire qui suit le quotidien hilarant des employés d'un bureau à Scranton, en Pennsylvanie.",
                'age_restriction' => 12,
                'categories' => ["Comédie"]
            ],
            [
                'name' => "Black Mirror",
                'description' => "Une anthologie de contes de science-fiction sombres explorant les implications de la technologie moderne sur la société.",
                'age_restriction' => 16,
                'categories' => ["Sci-Fi", "Drame", "Thriller"]
            ],
            [
                'name' => "The Crown",
                'description' => "L'histoire de la reine Elizabeth II et des événements qui ont façonné la seconde moitié du 20e siècle.",
                'age_restriction' => 12,
                'categories' => ["Drame", "Biographie", "Histoire"]
            ],
            [
                'name' => "Narcos",
                'description' => "L'histoire des cartels de drogue colombiens et de l'effort pour les arrêter mené par les forces de l'ordre et la DEA.",
                'age_restriction' => 18,
                'categories' => ["Drame", "Crime"]
            ],
            [
                'name' => "Westworld",
                'description' => "Un parc d'attractions futuriste permet aux visiteurs d'interagir avec des hôtes robotiques, mais tout ne se passe pas comme prévu.",
                'age_restriction' => 16,
                'categories' => ["Sci-Fi", "Drame", "Western"]
            ],
            [
                'name' => "The Witcher",
                'description' => "Geralt de Riv, un chasseur de monstres surnaturels, navigue dans un monde dangereux et magique rempli de créatures maléfiques.",
                'age_restriction' => 16,
                'categories' => ["Fantasy", "Drame", "Action"]
            ],
            [
                'name' => "Peaky Blinders",
                'description' => "La famille Shelby dirige un gang criminel à Birmingham après la Première Guerre mondiale, cherchant à étendre leur empire.",
                'age_restriction' => 18,
                'categories' => ["Drame", "Crime"]
            ],
            [
                'name' => "Vikings",
                'description' => "L'histoire des guerriers Vikings légendaires et de leurs conquêtes à travers l'Europe et au-delà.",
                'age_restriction' => 16,
                'categories' => ["Action", "Drame", "Histoire"]
            ],
            [
                'name' => "Fargo",
                'description' => "Une anthologie noire avec des histoires indépendantes mettant en vedette des personnages uniques et des situations violentes.",
                'age_restriction' => 16,
                'categories' => ["Crime", "Drame", "Thriller"]
            ],
            [
                'name' => "Bojack Horseman",
                'description' => "Bojack Horseman, une ancienne star de sitcom, tente de trouver la rédemption dans une version anthropomorphisée de Hollywood.",
                'age_restriction' => 16,
                'categories' => ["Animation", "Comédie", "Drame"]
            ],
            [
                'name' => "The Mandalorian",
                'description' => "Un chasseur de primes mandalorien navigue à travers la galaxie Star Wars, loin de l'autorité de la Nouvelle République.",
                'age_restriction' => 12,
                'categories' => ["Sci-Fi", "Action"]
            ],
            [
                'name' => "Money Heist",
                'description' => "Un groupe de criminels talentueux planifie et exécute des braquages spectaculaires sous la direction du mystérieux Professeur.",
                'age_restriction' => 16,
                'categories' => ["Drame", "Crime", "Thriller"]
            ],
            [
                'name' => "The Boys",
                'description' => "Un groupe de justiciers lutte contre des super-héros corrompus qui abusent de leur pouvoir et de leur statut de célébrité.",
                'age_restriction' => 18,
                'categories' => ["Action", "Comédie", "Drame"]
            ]
        ];

        $series = [];

        foreach($series_data as $serie) {
            $s = new Serie();
            $s->setName($serie['name']);
            $s->setDescription($serie['description']);
            $s->setAgeRestriction($serie['age_restriction']);
        
            foreach($serie['categories'] as $c_label) {
                if(!isset($categories[$c_label])) {
                    // Création de la catégorie à la volée
                    $c = new Category();
                    $c->setLabel($c_label);
                    $manager->persist($c);

                    $categories[$c_label] = $c;
                }

                $s->addCategory($categories[$c_label]);
            }

            $manager->persist($s);
            $series[$serie['name']] = $s;
        }

        $manager->flush();
    }
}

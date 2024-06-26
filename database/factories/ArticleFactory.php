<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $articles = [
            "Homère" =>  "L'Odyssée",
            "Victor Hugo" =>  "Les Misérables",
            "J.R.R. Tolkien" =>  "Le Seigneur des Anneaux",
            "Fiodor Dostoïevski" =>  "Crime et Châtiment",
            "Jane Austen" =>  "Orgueil et Préjugés",
            "Gabriel García Márquez" =>  "Cent ans de solitude",
            "Saint-Exupéry" =>  "Le Petit Prince",
            "Alexandre Dumas" =>  "Le Comte de Monte-Cristo",
            "J.K. Rowling" =>  "Harry Potter à l'école des sorciers",
            "Harper Lee" =>  "Ne tirez pas sur l'oiseau moqueur",
            "Patrick Süskind" =>  "Le Parfum",
            "Ray Bradbury" =>  "Fahrenheit 451",
            "Alexandre Dumas" =>  "Les Trois Mousquetaires",
            "Ken Follett" =>  "Les Piliers de la Terre",
            "Jules Verne" =>  "Vingt mille lieues sous les mers",
            "Charles Baudelaire" =>  "Les Fleurs du mal",
            "Noir de Stendhal" =>  "Le Rouge et le Noir",
            "Léon Tolstoï" =>  "Anna Karenine",
            "Franz Kafka" =>  "La Métamorphose",
            "Ernest Hemingway" =>  "Le Vieil Homme et la Mer",
            "Bernard Werber" =>  "Les Fourmis",
            "Alain-Fournier" =>  "Le Grand Meaulnes",
            "Oscar Wilde" =>  "Le Portrait de Dorian Gray",
            "Anne Frank" =>  "Le Journal",
            "George Orwell" =>  "1984",
            "Aldous Huxley" =>  "Le Meilleur des mondes",
            "Franz Kafka" =>  "Le Procès",
            "Franz Kafka" =>  "Le Château",
            "George Orwell" =>  "La Ferme des animaux",
            "Mikhaïl Boulgakov" =>  "Le Maître et Marguerite",
            "Léon Tolstoï" =>  "Guerre et Paix",
            "Fiodor Dostoïevski" =>  "Les Frères Karamazov",
            "Herman Melville" =>  "Moby Dick",
            "Mary Shelley" =>  "Frankenstein",
            "Emily Brontë" =>  "Les Hauts de Hurlevent",
            "John Steinbeck" =>  "Les Raisins de la colère",
            "Jules Verne" =>  "Le Tour du monde en quatre-vingts jours",
            "Alexandre Dumas" =>  "Le Comte de Monte-Cristo",
            "Choderlos de Laclos" =>  "Les Liaisons dangereuses",
            "Boris Vian" =>  "L'Écume des jours",
            "Hermann Hesse" =>  "Le Loup des steppes",
            "Jules Verne" =>  "Les Enfants du capitaine Grant",
            "Conan Doyle" =>  "Les Aventures de Sherlock Holmes",
            "Helen Fielding" =>  "Le Journal de Bridget Jones",
            "Stieg Larsson" =>  "Millénium, tome 1 : Les Hommes qui n'aimaient pas les femmes",
            "Umberto Eco" =>  "Le Nom de la rose",
            "J.D. Salinger" =>  "L'Attrape-cœurs",
            "René Barjavel" =>  "La Nuit des temps",
            "Joseph Kessel" =>  "Le Lion",
            "Rabelais Mahugnon Kpechekou" => "Wanilo"
        ];

        $author = $this->faker->randomElement(array_keys($articles));
        $title = $articles[$author];

        $keywords = $this->faker->unique()->randomElements(array : [
            'Algorithmique', 'Structures de données', 'Mathématiques',
            'Finances', 'Comptabilité', 'Logistiques', 'Transport',
            'Réseaux informatiques', 'Sécurité Réseaux', 'Cryptographie',
            'Maintenance Informatique', "Systèmes d'exploitations", 'Anglais',
            'Unified Modelisation Langage', 'Bases de données', 'Apprendre le PHP',
            'Apprendre le Python', 'Apprendre le Javascript', 'Apprendre le C++',
            'Apprendre le Ruby', 'Apprendre le JAVA', 'Découvrir le framework javascript ReactJS',
            'Mathématiques financières', 'Algèbre Linéaire', 'Bases des Réseaux Informatiques'
        ], count : rand(5, 10));
        $keywords = json_encode(array_unique($keywords));

        $formats = $this->faker->randomElements(array : ['pdf', 'mobi', 'epub'/* , 'azw', 'lit', 'fb2' */], count : rand(2, 3));
        $formats = json_encode(value : $formats);
        $available = $this->faker->boolean(chanceOfGettingTrue : 80);

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            /* 'type' => $this->faker->randomElement(['Livre', 'Podcast']), */
            'summary' => $this->faker->paragraph(),
            'author' => $author,
            'editor' => $author,
            'editing_year' => $this->faker->year(),
            'cote' =>  $this->faker->randomNumber(3) . '.' . $this->faker->randomNumber(2),
            'number_pages' =>  $this->faker->numberBetween(int1 : 50, int2 : 500),
            'ISBN' =>  $this->faker->isbn13,
            'available_stock' => $this->faker->numberBetween(int1 : 50, int2 : 500),
            'available' => $available,
            'loaned' => !$available,
            'reserved' => !$available,
            'has_ebooks' => $this->faker->boolean(chanceOfGettingTrue : 50),
            'is_physical' => $this->faker->boolean(chanceOfGettingTrue : 85),
            'has_audios' => $this->faker->boolean(chanceOfGettingTrue : 50),
            /* 'keywords' => $keywords,
            'formats' => $formats, */
            'created_by' => 'APPLICATION'
        ];
    }
}

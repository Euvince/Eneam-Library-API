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
            "Homère" => "L'Odyssée d'Homère",
            "Victor Hugo" => "Les Misérables de Victor Hugo",
            "J.R.R. Tolkien" => "Le Seigneur des Anneaux de J.R.R. Tolkien",
            "Fiodor Dostoïevski" => "Crime et Châtiment de Fiodor Dostoïevski",
            "Jane Austen" => "Orgueil et Préjugés de Jane Austen",
            "Gabriel García Márquez" => "Cent ans de solitude de Gabriel García Márquez",
            "Saint-Exupéry" => "Le Petit Prince d'Antoine de Saint-Exupéry",
            "Alexandre Dumas" => "Le Comte de Monte-Cristo d'Alexandre Dumas",
            "J.K. Rowling" => "Harry Potter à l'école des sorciers de J.K. Rowling",
            "Harper Lee" => "Ne tirez pas sur l'oiseau moqueur de Harper Lee",
            "Patrick Süskind" => "Le Parfum de Patrick Süskind",
            "Ray Bradbury" => "Fahrenheit 451 de Ray Bradbury",
            "Alexandre Dumas" => "Les Trois Mousquetaires d'Alexandre Dumas",
            "Ken Follett" => "Les Piliers de la Terre de Ken Follett",
            "Jules Verne" => "Vingt mille lieues sous les mers de Jules Verne",
            "Charles Baudelaire" => "Les Fleurs du mal de Charles Baudelaire",
            "Noir de Stendhal" => "Le Rouge et le Noir de Stendhal",
            "Léon Tolstoï" => "Anna Karenine de Léon Tolstoï",
            "Franz Kafka" => "La Métamorphose de Franz Kafka",
            "Ernest Hemingway" => "Le Vieil Homme et la Mer d'Ernest Hemingway",
            "Bernard Werber" => "Les Fourmis de Bernard Werber",
            "Alain-Fournier" => "Le Grand Meaulnes d'Alain-Fournier",
            "Oscar Wilde" => "Le Portrait de Dorian Gray d'Oscar Wilde",
            "Anne Frank" => "Le Journal d'Anne Frank",
            "George Orwell" => "1984 de George Orwell",
            "Aldous Huxley" => "Le Meilleur des mondes d'Aldous Huxley",
            "Franz Kafka" => "Le Procès de Franz Kafka",
            "Franz Kafka" => "Le Château de Franz Kafka",
            "George Orwell" => "La Ferme des animaux de George Orwell",
            "Mikhaïl Boulgakov" => "Le Maître et Marguerite de Mikhaïl Boulgakov",
            "Léon Tolstoï" => "Guerre et Paix de Léon Tolstoï",
            "Fiodor Dostoïevski" => "Les Frères Karamazov de Fiodor Dostoïevski",
            "Herman Melville" => "Moby Dick d'Herman Melville",
            "Mary Shelley" => "Frankenstein de Mary Shelley",
            "Emily Brontë" => "Les Hauts de Hurlevent d'Emily Brontë",
            "John Steinbeck" => "Les Raisins de la colère de John Steinbeck",
            "Jules Verne" => "Le Tour du monde en quatre-vingts jours de Jules Verne",
            "Alexandre Dumas" => "Le Comte de Monte-Cristo d'Alexandre Dumas",
            "Choderlos de Laclos" => "Les Liaisons dangereuses de Pierre Choderlos de Laclos",
            "Boris Vian" => "L'Écume des jours de Boris Vian",
            "Hermann Hesse" => "Le Loup des steppes de Hermann Hesse",
            "Jules Verne" => "Les Enfants du capitaine Grant de Jules Verne",
            "Conan Doyle" => "Les Aventures de Sherlock Holmes d'Arthur Conan Doyle",
            "Helen Fielding" => "Le Journal de Bridget Jones d'Helen Fielding",
            "Stieg Larsson" => "Millénium, tome 1 : Les Hommes qui n'aimaient pas les femmes de Stieg Larsson",
            "Umberto Eco" => "Le Nom de la rose d'Umberto Eco",
            "J.D. Salinger" => "L'Attrape-cœurs de J.D. Salinger",
            " René Barjavel" => "La Nuit des temps de René Barjavel",
            "Joseph Kessel" => "Le Lion de Joseph Kessel",
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
        $available = $this->faker->boolean(chanceOfGettingTrue : 90);

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
            'has_ebooks' => $this->faker->boolean(chanceOfGettingTrue : 85),
            'has_audios' => $this->faker->boolean(chanceOfGettingTrue : 50),
            /* 'keywords' => $keywords,
            'formats' => $formats, */
            'created_by' => 'APPLICATION'
        ];
    }
}

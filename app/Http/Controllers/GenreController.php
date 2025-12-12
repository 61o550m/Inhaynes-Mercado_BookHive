<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class GenreController extends Controller
{
    public function show(Request $request, $genre)
    {
        
        $genreFormatted = ucwords(str_replace('-', ' ', $genre));


        
        $query = Book::where('genre', $genreFormatted);

        
        
        
        if ($request->condition) {
            $query->where('condition', $request->condition);
        }

        
        
        
        if ($request->sort === 'low-high') {
            $query->orderBy('price', 'asc');
        }

        if ($request->sort === 'high-low') {
            $query->orderBy('price', 'desc');
        }

        if ($request->sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        }

        
        $books = $query->get();

        
        $descriptions = [
            'Fiction' => 'Fiction is a form of storytelling that comes from imagination, creating worlds,
                characters, and events that may or may not exist in real life. It lets readers
                escape reality and explore endless possibilities, from magical kingdoms to futuristic
                worlds. Through fiction, authors express ideas, emotions, and adventures in creative
                ways. It entertains, inspires, and sometimes even teaches lessons. Fiction reminds
                us that imagination has no limits.',

            'Fantasy' => 'Fantasy is a genre of fiction that brings readers into magical worlds filled with mythical creatures, powerful heroes, and extraordinary adventures. It often features magic, enchanted lands, and legends that break the rules of reality. Fantasy lets the imagination roam free, creating stories where anything is possible. Whether epic or whimsical, it inspires wonder and excitement. It’s a journey into the impossible made beautifully real.',

            'Romance' => 'Romance is a genre that centers on love, connection, and emotional journeys between characters. It explores heartfelt moments, growing attraction, and the challenges that bring people closer together. Whether sweet, dramatic, or passionate, romance highlights the beauty of relationships and the power of affection. It makes readers feel the spark of love and hope. In every story, romance reminds us how meaningful it is to find someone who understands our heart.',

            'Horror' => 'Horror is a genre designed to evoke fear, suspense, and a sense of the unknown. It explores dark themes, eerie settings, and frightening encounters that challenge characters’ courage and sanity. Horror stories keep readers on edge, waiting for the next scare or twist. They tap into our deepest fears, from the supernatural to the psychological. In every tale, horror aims to thrill, unsettle, and leave a lingering chill.',

            'Thriller' => 'Thriller is a genre filled with suspense, tension, and unexpected twists that keep readers on the edge of their seats. It often follows characters in dangerous, high-stakes situations where every decision matters. Thrillers create an atmosphere of mystery and urgency, making the audience feel the danger unfold. With fast-paced action and shocking reveals, the genre keeps hearts racing from start to finish. It’s all about excitement, fear, and the thrill of the unknown.',

            'Mystery' => 'Mystery is a genre centered on uncovering secrets, solving puzzles, and discovering the truth behind intriguing events. It often follows detectives or curious characters as they piece together clues and chase leads. Mystery stories build suspense, keeping readers guessing about what really happened. Every twist adds excitement as the answers slowly come to light. This genre captures the thrill of solving the unknown.',

            'Science Fiction' => 'Science fiction is a genre that explores futuristic ideas, advanced technology, 
            and imaginative possibilities shaped by science. 
            It often takes readers to distant galaxies, alternate realities, or future worlds 
            where humanity faces new challenges. Sci-fi blends creativity with scientific curiosity, asking “what if?” about space, time, and innovation. 
            Through thrilling adventures and bold concepts, it pushes the limits of what could be real. It invites us to dream about the future and our place in it.',

            'Education' => 'Fantasy is a genre of fiction that brings readers into magical worlds filled with mythical creatures, powerful heroes, and extraordinary adventures. It often features magic, enchanted lands, and legends that break the rules of reality. Fantasy lets the imagination roam free, creating stories where anything is possible. Whether epic or whimsical, it inspires wonder and excitement. It’s a journey into the impossible made beautifully real.',

            'Historical' => 'Historical stories are set in real periods of the past, bringing to life the people, cultures, and events that shaped history. They blend factual details with storytelling to make bygone eras feel vivid and real. Through historical narratives, readers can experience the struggles, victories, and everyday lives of those who came before us. This genre helps us understand how the world has changed over time. It connects us to the past in a meaningful and engaging way.',

            'Manga' => 'Manga is a style of Japanese comic art known for its expressive characters, dynamic storytelling, and diverse genres. It is read from right to left and features unique visual techniques that bring emotions and action to life. Manga offers stories for every age and interest—ranging from adventure and romance to fantasy and slice of life. Its rich artwork and engaging plots make it easy to get absorbed in each chapter. Manga is a vibrant form of storytelling loved by readers around the world.',

            'Non Fiction' => 'Nonfiction is a genre based on real events, true stories, and factual information. It aims to inform, explain, or share real-life experiences with accuracy and clarity. From biographies to history and self-help, nonfiction helps readers understand the world as it truly is. It offers knowledge, insights, and lessons drawn from reality. Nonfiction reminds us that real stories can be just as powerful as imagined ones.',
        ];

        
        $image = "genreimg/" . strtolower(str_replace(' ', '', $genre)) . ".png";

        return view('genres.show', [
            'genre' => $genreFormatted,
            'description' => $descriptions[$genreFormatted] ?? '',
            'image' => $image,
            'books' => $books,
            'request' => $request  
        ]);
    }
}

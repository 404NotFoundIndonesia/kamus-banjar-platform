<?php

namespace App\Enum;

enum PartOfSpeech: string
{
    // n	        Noun	        Refers to a person, place, or thing.
    case NOUN = 'n';
    // v	        Verb	        Indicates actions, processes, or states.
    case VERB = 'v';
    // a	        Adjective	    Describes or qualifies a noun.
    case ADJECTIVE = 'a';
    // pro	        Pronoun	        Replaces a noun.
    case PRONOUN = 'pro';
    // adv	        Adverb	        Modifies a verb, adjective, or sentence.
    case ADVERB = 'adv';
    // num	        Numeral	        Indicates quantity or order.
    case NUMERAL = 'num';
    // p	        Particle	    A function word; does not change form (e.g., "lah", "kah").
    case PARTICLE = 'p';
    // conj	        Conjunction	    Connects clauses, phrases, or words.
    case CONJUNCTION = 'konj';
    // prep	        Preposition	    Indicates relationships between words (e.g., "in", "to").
    case PREPOSITION = 'prep';
    // interj	    Interjection	Expresses emotions or spontaneous reactions.
    case INTERJECTION = 'interj';
    // clit	        Clitic	        A short word attached to another word (e.g., "-'s", "-n't").
    case CLITIC = 'klit';
    // dem	        Demonstrative	Points to something (e.g., "this", "that").
    case DEMONSTRATIVE = 'dem';
    // art	        Article	        Limits a noun (e.g., "the", "a", "an").
    case ARTICLE = 'art';

    public static function abbreviation(): array
    {
        return [
            'n' => 'Nomina',
            'v' => 'Verba',
            'a' => 'Adjektiva',
            'pro' => 'Pronomina',
            'adv' => 'Adverbia',
            'num' => 'Numeralia',
            'p' => 'Partikel',
            'konj' => 'Konjungsi',
            'prep' => 'Preposisi',
            'interj' => 'Interjeksi',
            'klit' => 'Klitika',
            'dem' => 'Demonstrativa',
            'art' => 'Artikel',
        ];
    }
}

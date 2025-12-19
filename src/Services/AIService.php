<?php
namespace App\Services;

class AIService
{
    // Stubbed AI service; replace with real OpenAI call in production
    public static function classify(string $title, string $description, float $lat, float $lng): array
    {
        $text = strtolower($title . ' ' . $description);
        $category = 'Uncategorized';
        if (str_contains($text, 'garbage') || str_contains($text, 'waste')) $category = 'Garbage';
        elseif (str_contains($text, 'pothole') || str_contains($text, 'road')) $category = 'Road/Pothole';
        elseif (str_contains($text, 'water') || str_contains($text, 'leak')) $category = 'Water Leakage';
        elseif (str_contains($text, 'drain') || str_contains($text, 'sewage')) $category = 'Drainage';
        elseif (str_contains($text, 'light') || str_contains($text, 'streetlight')) $category = 'Streetlight';

        $priority = 'Low';
        if (str_contains($text, 'severe') || str_contains($text, 'urgent') || str_contains($text, 'accident')) $priority = 'High';
        elseif (str_contains($text, 'moderate') || str_contains($text, 'danger')) $priority = 'Medium';

        // Dummy duplicate detection policy: returns a flag only; production would query by geo proximity & text similarity
        $duplicate = false;

        return [
            'category' => $category,
            'priority' => $priority,
            'duplicate' => $duplicate,
        ];
    }
}

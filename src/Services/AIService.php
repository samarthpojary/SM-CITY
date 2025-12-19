<?php
namespace App\Services;

class AIService
{
    public static function classify(string $title, string $description, float $lat, float $lng): array
    {
        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            // Fallback to simple keyword matching if no API key
            return self::fallbackClassify($title, $description, $lat, $lng);
        }

        $text = $title . ' ' . $description;
        $prompt = "Analyze this complaint text and classify it into one of these categories: Garbage, Road/Pothole, Water Leakage, Drainage, Streetlight, or Uncategorized. Also assign a priority: Low, Medium, or High based on urgency. Return JSON with keys 'category' and 'priority'. Complaint: \"$text\"";

        $response = self::callOpenAI($prompt, $apiKey);
        if ($response) {
            $data = json_decode($response, true);
            if ($data && isset($data['category'], $data['priority'])) {
                $duplicates = \App\Models\Complaint::duplicates($lat, $lng, $data['category']);
                return [
                    'category' => $data['category'],
                    'priority' => $data['priority'],
                    'duplicate' => count($duplicates) > 0,
                ];
            }
        }

        // Fallback if API fails
        return self::fallbackClassify($title, $description, $lat, $lng);
    }

    private static function callOpenAI(string $prompt, string $apiKey): ?string
    {
        $url = 'https://api.openai.com/v1/chat/completions';
        $data = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant that classifies smart city complaints. Always respond with valid JSON.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'max_tokens' => 100,
            'temperature' => 0.3,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            $result = json_decode($response, true);
            return $result['choices'][0]['message']['content'] ?? null;
        }

        return null;
    }

    private static function fallbackClassify(string $title, string $description, float $lat, float $lng): array
    {
        $text = strtolower($title . ' ' . $description);
        $category = 'Uncategorized';
        if (str_contains($text, 'garbage') || str_contains($text, 'waste') || str_contains($text, 'trash')) $category = 'Garbage';
        elseif (str_contains($text, 'pothole') || str_contains($text, 'road') || str_contains($text, 'street') || str_contains($text, 'crack')) $category = 'Road/Pothole';
        elseif (str_contains($text, 'water') || str_contains($text, 'leak') || str_contains($text, 'pipe')) $category = 'Water Leakage';
        elseif (str_contains($text, 'drain') || str_contains($text, 'sewage') || str_contains($text, 'flood')) $category = 'Drainage';
        elseif (str_contains($text, 'light') || str_contains($text, 'streetlight') || str_contains($text, 'lamp')) $category = 'Streetlight';

        $priority = 'Low';
        if (str_contains($text, 'severe') || str_contains($text, 'urgent') || str_contains($text, 'accident') || str_contains($text, 'danger')) $priority = 'High';
        elseif (str_contains($text, 'moderate') || str_contains($text, 'broken') || str_contains($text, 'damaged')) $priority = 'Medium';

        $duplicates = \App\Models\Complaint::duplicates($lat, $lng, $category);

        return [
            'category' => $category,
            'priority' => $priority,
            'duplicate' => count($duplicates) > 0,
        ];
    }
}

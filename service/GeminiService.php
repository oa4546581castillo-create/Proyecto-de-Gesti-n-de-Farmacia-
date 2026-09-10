<?php
class GeminiService {
    private $apiKey;
    // Endpoint actualizado con la versión activa gemini-3.6-flash
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent';

    public function __construct() {
        // Asegúrate de colocar tu clave API real de Google AI Studio
        $this->apiKey = 'AQ.Ab8RN6J1NH42xfkB08n1azol5NPFg2HNNb44OR0pCADjddlXJw';
    }

    public function consultarAI($prompt) {
        $url = $this->apiUrl . '?key=' . $this->apiKey;

        $payload = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['status' => false, 'error' => $error];
        }

        $result = json_decode($response, true);

        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return [
                'status' => true, 
                'respuesta' => $result['candidates'][0]['content']['parts'][0]['text']
            ];
        }

        return [
            'status' => false, 
            'error' => $result['error']['message'] ?? 'Respuesta no válida del servidor de IA.'
        ];
    }
}
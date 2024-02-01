<?php

namespace App\Services;

class TextFormattingService
{
    public static function renderFormattedText($jsonText)
    {
        $data = json_decode($jsonText, true);
        $htmlOutput = '';

        if (isset($data['ops']) && is_array($data['ops'])) {
            foreach ($data['ops'] as $operation) {
                $attributes = $operation['attributes'] ?? [];
                $text = $operation['insert'] ?? '';

                if (!empty($attributes['bold'])) {
                    $text = '<strong>' . $text . '</strong>';
                }
                if (!empty($attributes['italic'])) {
                    $text = '<em>' . $text . '</em>';
                }
                if (!empty($attributes['underline'])) {
                    $text = '<u>' . $text . '</u>';
                }
                if (!empty($attributes['header'])) {
                    $text = '<h' . $attributes['header'] . '>' . $text . '</h' . $attributes['header'] . '>';
                }
                if (!empty($attributes['link'])) {
                    $text = '<a href="' . $attributes['link'] . '">' . $text . '</a>';
                }

                $htmlOutput .= $text;
            }
        } else {
            $htmlOutput = htmlspecialchars($jsonText);
        }

        return $htmlOutput;
    }
}

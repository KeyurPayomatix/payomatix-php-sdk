<?php


namespace PayomatixSDK\Support;

final class Helpers
{
    /**
     * Convert array keys from camelCase to snake_case recursively.
     *
     * @param  array  $input
     * @return array
     */
    public static function convertToSnakeCase(array $input): array
    {
        $result = [];
        foreach ($input as $key => $value) {
            // Convert camelCase to snake_case
            $snakeKey = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $key));

            // If value is an array, recursively convert keys
            if (is_array($value)) {
                $value = self::convertToSnakeCase($value);
            }

            $result[$snakeKey] = $value;
        }

        return $result;
    }
}

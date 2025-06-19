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

    /**
     * Decode JSON string safely
     *
     * @param mixed $json
     * @return array|null
     */
    public static function decodeJson($json)
    {
        if (!is_string($json)) {
            return null;
        }

        $decoded = json_decode($json, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return null;
    }

    /**
     * Normalize legacy status values
     *
     * @param string|int $status
     * @return string
     */
    public static function mapStatus($status)
    {
        $status = (int) $status;

        switch ($status) {
            case 1:
                return 'success';

            case 0:
            case 2:
            case 3:
            case 4:
                return 'pending';

            case 5:
            case 6:
                return 'blocked';

            case 7:
            case 8:
                return 'declined';

            default:
                return 'unknown';
        }
    }


}

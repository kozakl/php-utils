<?php
namespace kozakl\utils\validate;

function filterValidate(
    mixed $value,
    int $filter,
    array $options = []):mixed {
    if (!\is_scalar($value)) {
        return $options['default'] ?? null;
    } else {
        $unsetOptions = $options;
        unset($unsetOptions['default']);
        $valid = $value !== null && (
            !empty(trim($value)) ||
            $value == 0
        ) ?
            filter_var($value, $filter, [
                'flags' => FILTER_NULL_ON_FAILURE,
                'options' => $unsetOptions
            ]) : null;
        if ($valid !== null) {
            return $valid;
        } else {
            return $options['default'] ?? null;
        }
    }
}

function filterValidateStrict(
    mixed $value,
    int $filter,
    array $options = []
): mixed {

    $default       = $options['default'] ?? null;
    $requiredError = $options['requiredError'] ?? null;
    $invalidError  = $options['invalidError'] ?? null;

    // brak wartości (required)
    if ($value === null || $value === '') {
        if ($requiredError) {
            throw new \Exception($requiredError);
        }
        return $default;
    }

    // tylko skalary są walidowalne przez filter_var
    if (!\is_scalar($value)) {
        if ($invalidError) {
            throw new \Exception($invalidError);
        }
        return $default;
    }

    // przygotowanie opcji dla filter_var
    $filterOptions = $options;
    unset(
        $filterOptions['default'],
        $filterOptions['requiredError'],
        $filterOptions['invalidError']
    );

    $valid = filter_var(
        $value,
        $filter,
        [
            'flags'   => FILTER_NULL_ON_FAILURE,
            'options' => $filterOptions
        ]
    );

    if ($valid === null) {
        if ($invalidError) {
            throw new \Exception($invalidError);
        }
        return $default;
    }

    return $valid;
}

function validateFieldsByWhitelist(
    string|array|null $fields,
    array $whitelist,
    ?string $default,
    bool $implode = true):string|array|null {
    if (!$fields) {
        return $default;
    } else {
        $result = array_filter(
            \is_array($fields) ?
                $fields : explode(',', $fields),
            fn($key):bool =>
                \in_array($key, $whitelist)
        );
        if (empty($result)) {
            return $default;
        } else {
            return $implode ?
                implode(',', $result) :
                $result;
        }
    }
}

function validateFieldsByWhitelistStrict(
    string|array|null $fields,
    array $whitelist,
    array $options = []
): string|array|null {

    $default = $options['default'] ?? null;
    $requiredError = $options['requiredError'] ?? null;
    $invalidError = $options['invalidError'] ?? null;
    $implode = $options['implode'] ?? true;

    // brak parametru
    if ($fields === null || $fields === '') {
        if ($requiredError) {
            throw new \Exception($requiredError);
        }
        return $default;
    }

    // normalizacja inputu
    $values = is_array($fields)
        ? $fields
        : array_map('trim', explode(',', $fields));

    // sprawdzenie whitelisty
    $invalid = array_diff($values, $whitelist);
    if (!empty($invalid)) {
        if ($invalidError) {
            throw new \Exception($invalidError);
        }
        return $default; // <- fallback zawsze, jeśli brak exception
    }

    // wszystko poprawne
    return $implode ? implode(',', $values) : $values;
}

function validateSubObjectFields($fields, $columnNames) {
    return ",json_object(". implode(',', 
        array_map(fn($field) =>
            "'$field', $columnNames[1].$field",
            $fields
        )
    ). ") as {$columnNames[0]}";
}

function validateSearchWords($words) {
    if (!empty($words)) {
        $validated = preg_replace([
            '/[^\p{L}0-9# ]+/u',
            '/(?<!^)#/u',
            '/\s+/u'
        ], ' ', $words);
        return explode(' ', trim($validated));
    }
}

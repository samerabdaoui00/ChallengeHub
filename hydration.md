# Object Hydration Procedure

Hydration is the process of filling an object's properties with data from an external source, typically a database result (an associative array).

## Benefits
- **Consistency**: Centralizes how database rows are converted to objects.
- **Maintainability**: Makes it easier to add new properties or change database column names.
- **Clean Code**: Reduces boilerplate code in getters and static factory methods.

## Implementation Pattern

Each model in the project follows this pattern:

### 1. The `hydrate` Method
A protected method that maps array keys to object properties.

```php
public function hydrate(array $data): void {
    foreach ($data as $key => $value) {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
    }
}
```

### 2. Usage in Static Fetch Methods
Instead of manual assignment, we instantiate the class and call `hydrate()`.

```php
public static function getById(int $id): ?self {
    // ... Database fetch logic ...
    if ($data) {
        $object = new self();
        $object->hydrate($data);
        return $object;
    }
    return null;
}
```

## Hydrated Models
The following models have been refactored to use this procedure:
- `User`
- `Challenge`
- `Comment`
- `Participation`
- `Vote`

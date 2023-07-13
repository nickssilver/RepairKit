# Laravel .env editor

![Tests](https://img.shields.io/github/actions/workflow/status/dacoto/laravel-env-set/ci.yml?labelColor=444D56&label=Tests)
![GitHub](https://img.shields.io/github/license/dacoto/laravel-env-set?labelColor=444D56&label=License)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/dacoto/laravel-env-set?labelColor=444D56&label=Release)


## Installation

```sh
composer require dacoto/laravel-env-set
```

## Usage

### Working with facade

Laravel Set Env has a facade with the name `dacoto\EnvSet\Facades\EnvSet`. You can perform all operations through this facade.

**Example:**

```php
<?php namespace Your\Namespace;

// ...

use dacoto\EnvSet\Facades\EnvSet;

class YourClass
{
    public function yourMethod()
    {
        EnvSet::doSomething();
    }
}
```

### Using dependency injection

This package also supports dependency injection. You can easily inject an instance of the `dacoto\EnvSet` class into your controller or other classes.

**Example:**

```php
<?php namespace App\Http\Controllers;

// ...

use dacoto\EnvSet;

class TestEnvSetController extends Controller
{
    protected $editor;

    public function __construct(EnvSet $editor)
    {
        $this->editor = $editor;
    }

    public function doSomething()
    {
        $editor = $this->editor->doSomething();
    }
}
```

### Reading file content

#### Reading raw content.

**Method syntax:**

```php
/**
 * Get raw content of file
 *
 * @return string
 */
public function getContent();
```

**Example:**

```php
$rawContent = EnvSet::getContent();
```

#### Reading content by lines.

**Method syntax:**

```php
/**
 * Get all lines from file
 *
 * @return array
 */
public function getLines();
```

**Example:**

```php
$lines = EnvSet::getLines();
```

**Note:** This will return an array. Each element in the array consists of the following items:

- Number of the line.
- Raw content of the line.
- Parsed content of the line, including: type of line (empty, comment, setter...), key name of setter, value of setter, comment of setter...

#### Reading content by keys

**Method syntax:**

```php
/**
 * Get all or exists given keys in file content
 *
 * @param  array  $keys
 *
 * @return array
 */
public function getKeys($keys = []);
```

**Example:**

```php
// Get all keys
$keys = EnvSet::getKeys();

// Only get two given keys if exists
$keys = EnvSet::getKeys(['APP_DEBUG', 'APP_URL']);
```

**Note:** This will return an array. Each element in the array consists of the following items:

- Number of the line.
- Key name of the setter.
- Value of the setter.
- Comment of the setter.
- If this key is used for the "export" command or not.

#### Determine if a key exists

**Method syntax:**

```php
/**
 * Check, if a given key is exists in the file content
 *
 * @param  string  $keys
 *
 * @return bool
 */
public function keyExists($key);
```

**Example:**

```php
$keyExists = EnvSet::keyExists('APP_URL');
```

#### Get value of a key

**Method syntax:**

```php
/**
 * Return the value matching to a given key in the file content
 *
 * @param  $key
 *
 * @throws \dacoto\EnvSet\Exceptions\KeyNotFoundException
 *
 * @return string
 */
public function getValue($key);
```

**Example:**

```php
$value = EnvSet::getValue('APP_URL');
```
**Note:** To apply the changes to the file, you have to save it with the save method.

### Writing content into a file

To edit file content, you have two jobs:

- First is writing content into the buffer
- Second is saving the buffer into the file

#### Add an empty line into buffer

**Method syntax:**

```php
/**
 * Add empty line to buffer
 *
 * @return EnvSet
 */
public function addEmpty();
```

**Example:**

```php
$file = EnvSet::addEmpty();
```

#### Add a comment line into buffer

**Method syntax:**

```php
/**
 * Add comment line to buffer
 *
 * @param object
 *
 * @return EnvSet
 */
public function addComment($comment);
```

**Example:**

```php
$file = EnvSet::addComment('This is a comment line');
```

#### Add or update a setter into buffer

**Method syntax:**

```php
/**
 * Set one key to buffer
 *
 * @param string       $key      Key name of setter
 * @param string|null  $value    Value of setter
 * @param string|null  $comment  Comment of setter
 * @param boolean      $export   Leading key name by "export "
 *
 * @return EnvSet
 */
public function setKey($key, $value = null, $comment = null, $export = false);
```

**Example:**

```php
// Set key ENV_KEY with empty value
$file = EnvSet::setKey('ENV_KEY');

// Set key ENV_KEY with none empty value
$file = EnvSet::setKey('ENV_KEY', 'anything-you-want');

// Set key ENV_KEY with a value and comment
$file = EnvSet::setKey('ENV_KEY', 'anything-you-want', 'your-comment');

// Update key ENV_KEY with a new value and keep earlier comment
$file = EnvSet::setKey('ENV_KEY', 'new-value-1');

// Update key ENV_KEY with a new value, keep earlier comment and use 'export ' before key name
$file = EnvSet::setKey('ENV_KEY', 'new-value', null, true);

// Update key ENV_KEY with a new value and clear comment
$file = EnvSet::setKey('ENV_KEY', 'new-value-2', '', false);
```

#### Add or update multi setter into buffer

**Method syntax:**

```php
/**
 * Set many keys to buffer
 *
 * @param  array  $data
 *
 * @return EnvSet
 */
public function setKeys($data);
```

**Example:**

```php
$file = EnvSet::setKeys([
    [
        'key'     => 'ENV_KEY_1',
        'value'   => 'your-value-1',
        'comment' => 'your-comment-1',
        'export'  => true
    ],
    [
        'key'     => 'ENV_KEY_2',
        'value'   => 'your-value-2',
        'export'  => true
    ],
    [
        'key'     => 'ENV_KEY_3',
        'value'   => 'your-value-3',
    ]
]);
```

Alternatively, you can also provide an associative array of keys and values:

```php
$file = EnvSet::setKeys([
    'ENV_KEY_1' => 'your-value-1',
    'ENV_KEY_2' => 'your-value-2',
    'ENV_KEY_3' => 'your-value-3',
]);
```

#### Delete a setter line in buffer

**Method syntax:**

```php
/**
 * Delete on key in buffer
 *
 * @param  string  $key
 *
 * @return EnvSet
 */
public function deleteKey($key);
```

**Example:**

```php
$file = EnvSet::deleteKey('ENV_KEY');
```

#### Delete multi setter lines in buffer

**Method syntax:**

```php
/**
 * Delete many keys in buffer
 *
 * @param  array $keys
 *
 * @return EnvSet
 */
public function deleteKeys($keys = []);
```

**Example:**

```php
// Delete two keys
$file = EnvSet::deleteKeys(['ENV_KEY_1', 'ENV_KEY_2']);
```

#### Save buffer into file

**Method syntax:**

```php
/**
 * Save buffer to file
 *
 * @return EnvSet
 */
public function save();
```

**Example:**

```php
$file = EnvSet::save();

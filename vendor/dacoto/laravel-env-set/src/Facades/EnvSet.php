<?php

declare(strict_types=1);

namespace dacoto\EnvSet\Facades;

use dacoto\EnvSet\EnvSetEditor;
use Illuminate\Support\Facades\Facade;

/**
 * @see EnvSetEditor::addEmpty
 * @method static EnvSetEditor addEmpty()
 * @see EnvSetEditor::deleteKeys
 * @method static EnvSetEditor deleteKeys($keys = [])
 * @see EnvSetEditor::save
 * @method static EnvSetEditor save()
 * @see EnvSetEditor::getContent
 * @method static false|string getContent()
 * @see EnvSetEditor::getLines
 * @method static array getLines()
 * @see EnvSetEditor::deleteKey
 * @method static EnvSetEditor deleteKey($key)
 * @see EnvSetEditor::setKeys
 * @method static EnvSetEditor setKeys($data)
 * @see EnvSetEditor::keyExists
 * @method static bool keyExists($key)
 * @see EnvSetEditor::load
 * @method static EnvSetEditor load($filePath = null)
 * @see EnvSetEditor::addComment
 * @method static EnvSetEditor addComment($comment)
 * @see EnvSetEditor::getValue
 * @method static mixed getValue($key)
 * @see EnvSetEditor::getKeys
 * @method static array getKeys($keys = [])
 * @see EnvSetEditor::setKey
 * @method static EnvSetEditor setKey($key, $value = null, $comment = null, $export = false)
 */
class EnvSet extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EnvSetEditor::class;
    }
}

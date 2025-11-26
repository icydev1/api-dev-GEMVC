<?php
/**
 * this is table layer. what so called Data access layer
 * classes in this layer shall be extended from CRUDTable or Gemvc\Core\Table ;
 * for each column in database table, you must define property in this class with same name and property type;
 */
namespace App\Table;

use Gemvc\Database\Table;
use Gemvc\Database\Schema;

/**
 * Student table class for handling Student database operations
 * 
 * @property int $id Student's unique identifier column id in database table
 * @property string $name Student's name column name in database table
 * @property string $description Student's description column description in database table
 */
class StudentTable extends Table
{
    public int $id;
    public string $name;
    public string $description;
    public string $class;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     * the name of the database table
     */
    public function getTable(): string
    {
        //return the name of the table in database
        return 'students';
    }

    /**
     * Summary of type mapping for properties
     * it is used to map the properties to the database columns
     * it is used in the TableGenerator class to generate the schema for the table
     * @var array
     */
    protected array $_type_map = [
        'id' => 'int',
        'name' => 'string',
        'description' => 'string',
        'class' => 'string'
    ];

    /**
     * @return array
     * the schema of the table in database and its relations
     */
    public function defineSchema(): array
    {
        return [
            Schema::primary('id'),
            Schema::autoIncrement('id'),
            Schema::index('name'),
            Schema::unique('name'),
            Schema::index('description'),
            Schema::index('class')
        ];
    }

    /**
     * @return null|static
     * null or StudentTable Object
     */
    public function selectById(int $id): null|static
    {
        $result = $this->select()->where('id', $id)->limit(1)->run();
        return $result[0] ?? null;
    }

    /**
     * @return null|static[]
     * null or array of StudentTable Objects
     */
    public function selectByName(string $name): null|array
    {
        return $this->select()->whereLike('name', $name)->run();
    }
} 
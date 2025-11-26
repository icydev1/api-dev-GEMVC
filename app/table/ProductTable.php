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
 * Product table class for handling Product database operations
 *
 * @property int $id Product's unique identifier column id in database table
 * @property string $name Product's name column name in database table
 * @property string|null $description Product's description column description in database table
 * @property string|null $color Product color
 * @property float $price Product price
 * @property int $stock Product stock quantity
 * @property string|null $sku Product stock keeping unit
 * @property int|null $category_id Category id (foreign key)
 * @property string|null $created_at Record created timestamp
 * @property string|null $updated_at Record updated timestamp
 */
class ProductTable extends Table
{
    public int $id;
    public string $name;
    public ?string $description = null;
    public ?string $color = null;
    public float $price = 0.0;
    public int $stock = 0;
    public ?string $sku = null;
    public ?int $category_id = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;

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
        return 'products';
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
        'color' => 'string',
        'price' => 'float',
        'stock' => 'int',
        'sku' => 'string',
        'category_id' => 'int',
        'created_at' => 'string',
        'updated_at' => 'string'
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
            Schema::index('color'),
            Schema::index('price'),
            Schema::index('stock'),
            Schema::index('sku'),
            Schema::index('category_id'),
            // if GEMVC supports timestamp helpers you can replace created_at/updated_at with Schema::timestamps()
        ];
    }

    /**
     * @return null|static
     * null or ProductTable Object
     */
    public function selectById(int $id): null|static
    {
        $result = $this->select()->where('id', $id)->limit(1)->run();
        return $result[0] ?? null;
    }

    /**
     * @return null|static[]
     * null or array of ProductTable Objects
     */
    public function selectByName(string $name): null|array
    {
        return $this->select()->whereLike('name', $name)->run();
    }
}

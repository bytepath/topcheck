<?php
namespace Potatoquality\TopCheck\AbstractClasses;

use Illuminate\Database\Schema\Blueprint;
use \Exception;

abstract class CreateDatabaseTable
{
    public $table = null;

    public function __construct(protected $schema)
    {}

    abstract protected function create(Blueprint $table);

    public function up()
    {
        if($this->table === null) {
            throw new Exception("Table name in CreateDatabaseTable is null");
        }

        $this->schema->create($this->table, function(Blueprint $table) {
            $this->create($table);
        });
    }

    public function down()
    {
        if($this->table === null) {
            throw new Exception("Table name in CreateDatabaseTable is null");
        }
        $this->schema->dropIfExists($this->table);
    }
}

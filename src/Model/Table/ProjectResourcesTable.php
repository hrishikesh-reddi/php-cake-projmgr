<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ProjectResourcesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('project_resources_t');
        $this->setPrimaryKey('id');

        $this->belongsTo('Projects', ['foreignKey' => 'project_id_nm']);
        $this->belongsTo('Employees', ['foreignKey' => 'user_id_nm']);
    }
}

<?php

namespace App\CommonBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'task' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.App.CommonBundle.Model.map
 */
class TaskTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.App.CommonBundle.Model.map.TaskTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('task');
        $this->setPhpName('Task');
        $this->setClassname('App\\CommonBundle\\Model\\Task');
        $this->setPackage('src.App.CommonBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('NAME', 'Name', 'VARCHAR', true, 50, null);
        $this->getColumn('NAME', false)->setPrimaryString(true);
        $this->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('DUE_DATE', 'DueDate', 'DATE', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('TaskTag', 'App\\CommonBundle\\Model\\TaskTag', RelationMap::ONE_TO_MANY, array('id' => 'task_id', ), 'CASCADE', null, 'TaskTags');
        $this->addRelation('Tag', 'App\\CommonBundle\\Model\\Tag', RelationMap::MANY_TO_MANY, array(), 'CASCADE', null, 'Tags');
    } // buildRelations()

} // TaskTableMap

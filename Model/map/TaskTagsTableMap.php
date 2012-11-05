<?php

namespace App\CommonBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'task_tags' table.
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
class TaskTagsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.App.CommonBundle.Model.map.TaskTagsTableMap';

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
        $this->setName('task_tags');
        $this->setPhpName('TaskTags');
        $this->setClassname('App\\CommonBundle\\Model\\TaskTags');
        $this->setPackage('src.App.CommonBundle.Model');
        $this->setUseIdGenerator(false);
        $this->setIsCrossRef(true);
        // columns
        $this->addForeignPrimaryKey('TASK_ID', 'TaskId', 'INTEGER' , 'task', 'ID', true, null, null);
        $this->addForeignPrimaryKey('TAG_ID', 'TagId', 'INTEGER' , 'tag', 'ID', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Task', 'App\\CommonBundle\\Model\\Task', RelationMap::MANY_TO_ONE, array('task_id' => 'id', ), null, null);
        $this->addRelation('Tag', 'App\\CommonBundle\\Model\\Tag', RelationMap::MANY_TO_ONE, array('tag_id' => 'id', ), null, null);
    } // buildRelations()

} // TaskTagsTableMap

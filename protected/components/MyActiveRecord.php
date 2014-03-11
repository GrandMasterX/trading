<?php
class MyActiveRecord extends GxActiveRecord
{

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function findByPkAndUser($id, $user_id = 0) {

        if (empty($user_id))
            $user_id = Yii::app()->user->getId();

        return $this->findByPk($id, array('condition' => 'user_id='.((int)$user_id)));
    }

    public function findAllByUser($user_id = 0) {

        if (empty($user_id))
            $user_id = Yii::app()->user->getId();

        return $this->findAllByAttributes(array('user_id' => (int)$user_id));
    }

    public function findByUser($user_id = 0) {

        if (empty($user_id))
            $user_id = Yii::app()->user->getId();

        return $this->findByAttributes(array('user_id' => (int)$user_id));
    }

    public function deleteRelationItems($relation) {

        if (!$rel = $this->getActiveRelation($relation))
            throw new CDbException(Yii::t('yii','Relation "{name}" does not exist.', array('{name}' => $relation)));

        $model = call_user_func(array($rel->className, 'model'));
        $items = $model->findAllByAttributes(array($rel->foreignKey => $this->getPrimaryKey()));

        if (empty($items))
            return false;

        foreach ($items as $item)
            $item->delete();

        return count($items); //$model->deleteByAttributes(array($rel->foreignKey => $this->getPrimaryKey()));
    }

    public function multiInsert($items, $update = true) {

        if (empty($items) || empty($items[0]))
            return false;

        $db = Yii::app()->db;
        $attributes = array_keys(($items[0]));
        sort($attributes);
        $values = array();

        $sql = '
        INSERT INTO
            `'.$this->tableName().'`
            ('.(implode(', ', $attributes)).')
        VALUES
            ';

        foreach ($items as $item) {
            //$model = new static;
            $data = array();

            foreach ($attributes as $attribute) {

                $data[$attribute] = isset($item[$attribute]) ? $item[$attribute] : null;
                //$model->{$attribute} = $data[$attribute];
                $data[$attribute] = $data[$attribute] === null ? 'NULL' : Yii::app()->db->quoteValue($data[$attribute]);
            }

            //if ($model->validate())
            $values[] = '('.implode(', ', $data).')';
        }

        if (empty($values))
            return false;

        $sql .= implode(",\n", $values)."\n";

        if ($update) {
            $tmp = array();
            foreach ($attributes as $attribute)
                $tmp[] = $attribute.'=VALUES('.$attribute.')';
            $sql .= ' ON DUPLICATE KEY UPDATE '.(implode(', ', $tmp));
        }

        $command = $db->createCommand($sql);

        return $command->query();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return self
     */
    public function limit($limit, $offset = 0) {

        $this->getDbCriteria()->mergeWith(array(
            'limit'  => $limit,
            'offset' => $offset
        ));

        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function last($limit = 1) {

        $this->getDbCriteria()->mergeWith(array(
            'limit'  => $limit,
            'order' => 'id DESC'
        ));

        return $this;
    }

    /**
     * @param string $order
     * @return $this
     */
    public function order($order) {

        $this->getDbCriteria()->mergeWith(array(
            'order' => $order
        ));

        return $this;
    }


    /**
     * @param self $items[]
     * @return mixed
     */

    public static function PkAsArrayIndex($items)
    {
        $result = array();

        foreach ($items as $model) {
            $pk = $model->getPrimaryKey();
            if (is_array($pk))
                $pk = implode('_', $pk);
            $result[$pk] = $model;
        }

        return $result;
    }

    /**
     * Compare two models
     * @param self $model
     * @return mixed
     */

    public function compare($model)
    {
        if (!is_object($model))
            return false;

        if (get_class($this) !== get_class($model))
            return false;

        $differences = array();

        foreach ($this->attributes as $key => $value)
        {
            if ($this->$key != $model->$key)
                $differences[$key] = array(
                    'new' => $this->$key,
                    'old' => $model->$key);
        }

        return $differences;
    }
}

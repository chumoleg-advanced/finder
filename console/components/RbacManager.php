<?php

namespace console\components;

use Yii;
use yii\base\Component;
use yii\rbac\Item;
use yii\rbac\DbManager;
use yii\helpers\ArrayHelper;

class RbacManager extends Component
{
    public $authManagerComponent = 'authManager';
    public $itemsFile = '@console/config/auth/items.php';
    public $rulesFile = '@console/config/auth/rules.php';
    public $relationshipsFile = '@console/config/auth/relationships.php';

    private $children = null;
    private $items = null;
    private $rules = null;

    public function generate()
    {
        $this->generateRules();
        $this->generateItems();
        $this->generateRelationships();
    }

    private function generateRules()
    {
        $authManager = $this->getAuthManager();
        $rules = $this->getRules();

        foreach ($rules as $rule) {
            if (!class_exists($rule)) {
                continue;
            }

            $authRule = new $rule;
            $authManager->addRule($authRule);
        }
    }

    private function generateItems()
    {
        $this->generatePermissions();
        $this->generateRoles();
    }

    private function generateRelationships()
    {
        $relationships = $this->getRelationships();
        foreach ($relationships as $parentName => $children) {
            $this->appendChildren($parentName, $children);
        }
    }

    /**
     * @return DbManager
     */
    private function getAuthManager()
    {
        return Yii::$app->{$this->authManagerComponent};
    }

    /**
     * @return array|mixed|null
     */
    private function getRules()
    {
        if ($this->rules === null) {
            $this->rules = $this->loadFromFile(Yii::getAlias($this->rulesFile));
        }

        return $this->rules;
    }

    private function generatePermissions()
    {
        $items = $this->getPermissions();
        foreach ($items as $name => $description) {
            $this->generatePermission($name, $description);
        }
    }

    private function generateRoles()
    {
        $items = $this->getRoles();
        foreach ($items as $name => $description) {
            $this->generateRole($name, $description);
        }
    }

    /**
     * @return array|mixed|null
     */
    private function getRelationships()
    {
        if ($this->children === null) {
            $this->children = $this->loadFromFile(Yii::getAlias($this->relationshipsFile));
        }

        return $this->children;
    }

    private function appendChildren($parentName, $children)
    {
        foreach ($children as $key => $child) {

            if (is_array($child)) {
                $this->appendChild($parentName, $key);
                $this->appendChildren($key, $child);
            } else {
                $this->appendChild($parentName, $child);
            }
        }
    }

    /**
     * @param $filePath
     *
     * @return array|mixed
     */
    private function loadFromFile($filePath)
    {
        if (!file_exists($filePath)) {
            return [];
        }

        return require($filePath);
    }

    /**
     * @return mixed
     */
    private function getPermissions()
    {
        return ArrayHelper::getValue($this->getItems(), Item::TYPE_PERMISSION, []);
    }

    private function generatePermission($name, $description)
    {
        $authManager = $this->getAuthManager();
        $isNew = false;

        if (!$permission = $authManager->getPermission($name)) {
            $permission = $authManager->createPermission($name);
            $isNew = true;
        }

        $this->saveAuthItem($permission, $description, $isNew);
    }

    private function getRoles()
    {
        return ArrayHelper::getValue($this->getItems(), Item::TYPE_ROLE, []);
    }

    private function generateRole($name, $description)
    {
        $authManager = $this->getAuthManager();
        $isNew = false;

        if (!$role = $authManager->getRole($name)) {
            $role = $authManager->createRole($name);
            $isNew = true;
        }

        $this->saveAuthItem($role, $description, $isNew);
    }

    /**
     * @param $parentName
     * @param $childName
     *
     * @return bool
     */
    private function appendChild($parentName, $childName)
    {
        $authManager = $this->getAuthManager();

        if (!$parent = $this->getItem($parentName)) {
            return false;
        }

        if (!$child = $this->getItem($childName)) {
            return false;
        }

        if ($authManager->hasChild($parent, $child)) {
            return false;
        }

        return $authManager->addChild($parent, $child);
    }

    /**
     * @return array|mixed|null
     */
    private function getItems()
    {
        if ($this->items === null) {
            $this->items = $this->loadFromFile(Yii::getAlias($this->itemsFile));
        }

        return $this->items;
    }

    private function saveAuthItem(Item $item, $description, $isNew)
    {
        $authManager = $this->getAuthManager();
        $this->applyOptions($item, array('description' => $description));
        $isNew ? $authManager->add($item) : $authManager->update($item->name, $item);
    }

    private function getItem($name)
    {
        $authManager = $this->getAuthManager();
        return $authManager->getPermission($name) ?: $authManager->getRole($name);
    }

    private function applyOptions(Item $item, array $options)
    {
        foreach ($options as $name => $value) {
            if (property_exists($item, $name)) {
                $item->$name = $value;
            }
        }
    }
}
<?php

namespace ZnTool\Test\Repositories;

use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\FileSystem\Helpers\FileStorageHelper;
use ZnCore\Base\Libs\Store\StoreFile;
use ZnCore\Domain\Base\Repositories\BaseFileCrudRepository;
use ZnCore\Domain\Entities\DynamicEntity;
use ZnCore\Domain\Helpers\FilterHelper;
use ZnCore\Domain\Libs\Query;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;

class DynamicFileRepository extends BaseFileCrudRepository
{

    private $fileName;

//    public function all(Query $query = null)
//    {
//        $items = $this->getItems();
//        if ($query) {
//            $items = FilterHelper::filterItems($items, $query);
//        }
//        $collection = new Collection();
//        $entityClassName = $this->getEntityClass();
//        $items = $this->getItems();
//        $attributes = array_keys($items[0]);
//        foreach ($items as $item) {
//            $entityInstance = new DynamicEntity(null, $attributes);//$this->createEntity($entityClassName, $item);
//            EntityHelper::setAttributes($entityInstance, $item);
//            $collection->add($entityInstance);
//        }
//        return $collection;
//
//       // return $this->getEntityManager()->createEntityCollection($this->getEntityClass(), $items);
//    }

    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function fileName(): string
    {
        return $this->fileName;
    }

    public function getEntityClass(): string
    {
        return DynamicEntity::class;
    }

    public function allData()
    {
        return $this->getItems();
    }

    public function allAsArray(Query $query = null): array
    {
        FileStorageHelper::touch($this->fileName());
        $query = Query::forge($query);
        $items = $this->getBody();
        if ($query) {
            $items = FilterHelper::filterItems($items, $query);
        }
        return $items;
    }

    public function oneByIdAsArray(int $id, Query $query = null): array
    {
        $query = Query::forge($query);
        $query->where('id', $id);
        $items = $this->allAsArray($query);
        if (empty($items)) {
            throw new NotFoundException();
        }
        return ArrayHelper::first($items);
    }

    public function dumpAll(array $items, array $attributes = null)
    {
        if ($attributes) {
            foreach ($items as &$item) {
                $item = ArrayHelper::extractByKeys($item, $attributes);
            }
        }
        $this->setItems($items);
    }

    public function dumpDataProvider(RpcResponseEntity $response, array $attributes = null)
    {
        $items = $response->getResult();
        $this->setItems([]);
        $this->setBody($items, $attributes);
        $this->setTotal($response->getMetaItem('totalCount'));

    }

    public function getBody()
    {
        $data = $this->getItems();
        return ArrayHelper::getValue($data, 'body', []) ?: [];
    }

    public function setBody($items, array $attributes = null)
    {
        if ($attributes) {
            foreach ($items as &$item) {
                $item = ArrayHelper::extractByKeys($item, $attributes);
            }
        }
        $data = $this->getItems();
        $data['body'] = $items ?: [];
        $this->setItems($data);
    }

    public function getTotal(): ?int
    {
        $data = $this->getItems();
        return ArrayHelper::getValue($data, 'meta.totalCount');
    }

    public function setTotal(?int $totalCount)
    {
        $data = $this->getItems();
        ArrayHelper::setValue($data, 'meta.totalCount', $totalCount);
        $this->setItems($data);
    }

    protected function getItems(): array
    {
        $store = new StoreFile($this->fileName());
        $data = $store->load() ?: [];
        return $data;
    }

    protected function setItems(array $items)
    {
        $store = new StoreFile($this->fileName());
        $store->save($items);
    }
}

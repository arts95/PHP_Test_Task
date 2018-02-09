<?php
/**
 * @author: Arsenii Andrieiev
 * Date: 07.02.18
 */

namespace controller;

use entity\AddressEntity;
use repository\BaseRepository;
use service\Response;

class AddressesController extends BaseController
{
    public function create()
    {
        $address = new AddressEntity();
        $address->load($this->post());
        if ($address->validate()) {
            $id = BaseRepository::save($address, $address->getDataForSave());
            if (is_int($id)) {
                return $this->setResponse(BaseRepository::findOne(AddressEntity::getTableName(), AddressEntity::getPrimaryKey(), $id), Response::HTTP_CREATED);
            } else {
                return $this->setResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return $this->setResponse((array)$address->gerErrors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function list()
    {
        /** @todo write pagination */
        return $this->setResponse(BaseRepository::findAll(AddressEntity::getTableName()));
    }

    public function detail(int $id)
    {
        $address = BaseRepository::findOne(AddressEntity::getTableName(), AddressEntity::getPrimaryKey(), $id);
        if ($address) {
            return $this->setResponse($address);
        } else {
            return $this->setResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    public function update($id)
    {
        $row = BaseRepository::findOne(AddressEntity::getTableName(), AddressEntity::getPrimaryKey(), $id);
        if ($row) {
            $address = new AddressEntity();
            $address->loadFromDb($row);
            $address->load($this->post());
            if ($address->validate()) {
                if (BaseRepository::update($address, $address->getAddressID(), $address->getDataForSave())) {
                    return $this->setResponse(BaseRepository::findOne(AddressEntity::getTableName(), AddressEntity::getPrimaryKey(), $id), Response::HTTP_OK);
                } else {
                    return $this->setResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            } else {
                return $this->setResponse((array)$address->gerErrors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
            return $this->setResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    public function delete($id)
    {
        $result = (boolean)BaseRepository::delete(AddressEntity::getTableName(), AddressEntity::getPrimaryKey(), $id);
        if ($result) {
            return $this->setResponse([], Response::HTTP_OK);
        } else {
            return $this->setResponse([], Response::HTTP_NOT_FOUND);
        }
    }
}
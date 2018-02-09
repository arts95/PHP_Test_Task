<?php
/**
 * @author: Arsenii Andrieiev
 * Date: 07.02.18
 */

namespace entity;

class AddressEntity extends BaseEntity
{
    const _TABLE = 'ADDRESS';
    const _PRIMARY_KEY = 'ADDRESSID';
    /**
     * @var integer
     */
    protected $addressID;
    /**
     * @var string
     */
    protected $label;
    /**
     * @var string
     */
    protected $street;
    /**
     * @var string
     */
    protected $houseNumber;
    /**
     * @var string
     */
    protected $postalCode;
    /**
     * @var string
     */
    protected $city;
    /**
     * @var string
     */
    protected $country;

    public static function getTableName(): string
    {
        return 'ADDRESS';
    }

    public static function getPrimaryKey(): string
    {
        return 'ADDRESSID';
    }


    /**
     * @return int
     */
    public function getAddressID(): int
    {
        return $this->addressID;
    }

    /**
     * @param int $addressID
     */
    public function setAddressID(int $addressID)
    {
        $this->addressID = $addressID;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    /**
     * @param string $houseNumber
     */
    public function setHouseNumber(string $houseNumber)
    {
        $this->houseNumber = $houseNumber;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    public function load(array $data): bool
    {
        foreach ($this->getAttributes() as $attribute) {
            if (isset($data[$attribute])) {
                $this->$attribute = $data[$attribute];
            }
        }
        return true;
    }

    public function getAttributes(): array
    {
        return [
            'addressID',
            'label',
            'street',
            'houseNumber',
            'postalCode',
            'city',
            'country',
        ];
    }

    public function loadFromDb(array $data): bool
    {
        foreach ($this->getAttributes() as $attribute) {
            if (isset($data[strtoupper($attribute)])) {
                $this->$attribute = $data[strtoupper($attribute)];
            }
        }
        return true;
    }

    public function gerRules(): array
    {
        return [
            ['attribute' => 'label', 'validator' => 'validator\LengthValidator', 'options' => ['max' => 100, 'min' => 0]],
            ['attribute' => 'street', 'validator' => 'validator\LengthValidator', 'options' => ['max' => 100, 'min' => 0]],
            ['attribute' => 'houseNumber', 'validator' => 'validator\LengthValidator', 'options' => ['max' => 10, 'min' => 0]],
            ['attribute' => 'postalCode', 'validator' => 'validator\LengthValidator', 'options' => ['max' => 6, 'min' => 0]],
            ['attribute' => 'city', 'validator' => 'validator\LengthValidator', 'options' => ['max' => 100, 'min' => 0]],
            ['attribute' => 'country', 'validator' => 'validator\LengthValidator', 'options' => ['max' => 100, 'min' => 0]],
            [
                'attributes' => ['label', 'street', 'houseNumber', 'postalCode', 'city', 'country'],
                'validator' => 'validator\RequiredValidator',
            ],
        ];
    }

    public function getDataForSave(): array
    {
        return [
            'LABEL' => $this->label,
            'STREET' => $this->street,
            'HOUSENUMBER' => $this->houseNumber,
            'POSTALCODE' => $this->postalCode,
            'CITY' => $this->city,
            'COUNTRY' => $this->country,
        ];
    }
}
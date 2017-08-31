<?php


namespace OrmTools\Util\ChipGenerator;


class ChipDescription
{

    /**
     * array of tables to use to create the chip
     */
    private $tables;

    /**
     * array of columns to skip (for instance: id, ...):
     * those columns won't be used to create the chip.
     *
     */
    private $ignoreColumns;

    /**
     *
     * Creates a one to one relationship with another Chip.
     *
     *
     * array of item, each of which being:
     *      - 0: columnName: the column to turn into a link
     *      - 1: propertyName: the new column name (replaces columnName)
     *      - 2: chipClassName:
     *              - either the chip class name to link to (no backslash), and without the Chip suffix.
     *                      If null, defaults to the pascal version of the propertyName.
     *              - or the path to the external class to use (
     *                      for instance Module\Ekom\Chip\Country\CountryChip )
     *                          in which case at least one backslash is required
     *
     *
     * For instance, you want to create a link if you are in an AddressChip
     * and you want to link a CountryChip:
     *      ->addLinkColumn ( country_id, country, Country )
     *
     *
     */
    private $linkColumns;

    /**
     * @var array of oldColumnName to array:
     *                  - 0: newColumnName, the new name of the column
     *                  - 1: defaultValue, the default value for the new column
     *
     *      With oldColumnName being the name of the column to transform
     *
     * You use this in certain cases where you want to defer some logic to the
     * ChipProcessor.
     *
     * ->setTransformerColumn( country_id, country )
     *
     * In the above example, I know that I want to set the country using setCountry( FR )
     * rather than setCountryId( 45 ), and I rely on the processor to later make the
     * relevant conversion if necessary.
     *
     *
     */
    private $transformerColumns;

    /**
     * Creates a one to many relationship with another Chip.
     *
     * @var array of item, each of which being:
     *      - 0: columnName, this can be either:
     *              - string: the plural form of the columnName.
     *                          In this form the singular is guessed by removing the trailing s
     *                          if any.
     *              - array: [singular, plural]
     *              This represents the property to create.
     *              Methods added will be:
     *                  - addXXX (XXX is singular form)
     *                  - getXXXs (XXXs is plural form)
     *
     *
     *      - 1: chipClassName:
     *              - either the chip class name to link to (no backslash), and without the Chip suffix
     *              - or the path to the external class to use (
     *                      for instance Module\Ekom\Chip\Country\CountryChip )
     *                          in which case at least one backslash is required
     *
     */
    private $childrenColumns;

    public function __construct()
    {
        $this->tables = [];
        $this->ignoreColumns = [];
        $this->linkColumns = [];
        $this->transformerColumns = [];
        $this->childrenColumns = [];
    }


    public static function create()
    {
        return new static();
    }

    /**
     * @return array
     */
    public function getTables()
    {
        return $this->tables;
    }

    public function setTables(array $tables)
    {
        $this->tables = $tables;
        return $this;
    }

    /**
     * @return array
     */
    public function getIgnoreColumns()
    {
        return $this->ignoreColumns;
    }

    public function setIgnoreColumns(array $ignoreColumns)
    {
        $this->ignoreColumns = $ignoreColumns;
        return $this;
    }

    /**
     * @return array
     */
    public function getLinkColumns()
    {
        return $this->linkColumns;
    }

    public function addLinkColumn($columnName, $propertyName, $chipClassName = null)
    {
        $this->linkColumns[] = [$columnName, $propertyName, $chipClassName];
        return $this;
    }

    /**
     * @return array
     */
    public function getTransformerColumns()
    {
        return $this->transformerColumns;
    }

    public function setTransformerColumn($oldColumnName, $newColumnName, $defaultValue = null)
    {
        $this->transformerColumns[$oldColumnName] = [$newColumnName, $defaultValue];
        return $this;
    }

    /**
     * @return array
     */
    public function getChildrenColumns()
    {
        return $this->childrenColumns;
    }

    public function addChildrenColumn($columnName, $chipClassName)
    {
        $this->childrenColumns[] = [$columnName, $chipClassName];
        return $this;
    }


}
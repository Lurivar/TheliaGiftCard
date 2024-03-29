<?php

namespace TheliaGiftCard\Model\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use TheliaGiftCard\Model\GiftCard;
use TheliaGiftCard\Model\GiftCardQuery;


/**
 * This class defines the structure of the 'gift_card' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class GiftCardTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'TheliaGiftCard.Model.Map.GiftCardTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'gift_card';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\TheliaGiftCard\\Model\\GiftCard';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'TheliaGiftCard.Model.GiftCard';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the ID field
     */
    const ID = 'gift_card.ID';

    /**
     * the column name for the SPONSOR_CUSTOMER_ID field
     */
    const SPONSOR_CUSTOMER_ID = 'gift_card.SPONSOR_CUSTOMER_ID';

    /**
     * the column name for the ORDER_ID field
     */
    const ORDER_ID = 'gift_card.ORDER_ID';

    /**
     * the column name for the PRODUCT_ID field
     */
    const PRODUCT_ID = 'gift_card.PRODUCT_ID';

    /**
     * the column name for the CODE field
     */
    const CODE = 'gift_card.CODE';

    /**
     * the column name for the TO_NAME field
     */
    const TO_NAME = 'gift_card.TO_NAME';

    /**
     * the column name for the TO_MESSAGE field
     */
    const TO_MESSAGE = 'gift_card.TO_MESSAGE';

    /**
     * the column name for the AMOUNT field
     */
    const AMOUNT = 'gift_card.AMOUNT';

    /**
     * the column name for the STATUS field
     */
    const STATUS = 'gift_card.STATUS';

    /**
     * the column name for the EXPIRATION_DATE field
     */
    const EXPIRATION_DATE = 'gift_card.EXPIRATION_DATE';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'gift_card.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'gift_card.UPDATED_AT';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'SponsorCustomerId', 'OrderId', 'ProductId', 'Code', 'ToName', 'ToMessage', 'Amount', 'Status', 'ExpirationDate', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'sponsorCustomerId', 'orderId', 'productId', 'code', 'toName', 'toMessage', 'amount', 'status', 'expirationDate', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(GiftCardTableMap::ID, GiftCardTableMap::SPONSOR_CUSTOMER_ID, GiftCardTableMap::ORDER_ID, GiftCardTableMap::PRODUCT_ID, GiftCardTableMap::CODE, GiftCardTableMap::TO_NAME, GiftCardTableMap::TO_MESSAGE, GiftCardTableMap::AMOUNT, GiftCardTableMap::STATUS, GiftCardTableMap::EXPIRATION_DATE, GiftCardTableMap::CREATED_AT, GiftCardTableMap::UPDATED_AT, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'SPONSOR_CUSTOMER_ID', 'ORDER_ID', 'PRODUCT_ID', 'CODE', 'TO_NAME', 'TO_MESSAGE', 'AMOUNT', 'STATUS', 'EXPIRATION_DATE', 'CREATED_AT', 'UPDATED_AT', ),
        self::TYPE_FIELDNAME     => array('id', 'sponsor_customer_id', 'order_id', 'product_id', 'code', 'to_name', 'to_message', 'amount', 'status', 'expiration_date', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'SponsorCustomerId' => 1, 'OrderId' => 2, 'ProductId' => 3, 'Code' => 4, 'ToName' => 5, 'ToMessage' => 6, 'Amount' => 7, 'Status' => 8, 'ExpirationDate' => 9, 'CreatedAt' => 10, 'UpdatedAt' => 11, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'sponsorCustomerId' => 1, 'orderId' => 2, 'productId' => 3, 'code' => 4, 'toName' => 5, 'toMessage' => 6, 'amount' => 7, 'status' => 8, 'expirationDate' => 9, 'createdAt' => 10, 'updatedAt' => 11, ),
        self::TYPE_COLNAME       => array(GiftCardTableMap::ID => 0, GiftCardTableMap::SPONSOR_CUSTOMER_ID => 1, GiftCardTableMap::ORDER_ID => 2, GiftCardTableMap::PRODUCT_ID => 3, GiftCardTableMap::CODE => 4, GiftCardTableMap::TO_NAME => 5, GiftCardTableMap::TO_MESSAGE => 6, GiftCardTableMap::AMOUNT => 7, GiftCardTableMap::STATUS => 8, GiftCardTableMap::EXPIRATION_DATE => 9, GiftCardTableMap::CREATED_AT => 10, GiftCardTableMap::UPDATED_AT => 11, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'SPONSOR_CUSTOMER_ID' => 1, 'ORDER_ID' => 2, 'PRODUCT_ID' => 3, 'CODE' => 4, 'TO_NAME' => 5, 'TO_MESSAGE' => 6, 'AMOUNT' => 7, 'STATUS' => 8, 'EXPIRATION_DATE' => 9, 'CREATED_AT' => 10, 'UPDATED_AT' => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'sponsor_customer_id' => 1, 'order_id' => 2, 'product_id' => 3, 'code' => 4, 'to_name' => 5, 'to_message' => 6, 'amount' => 7, 'status' => 8, 'expiration_date' => 9, 'created_at' => 10, 'updated_at' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('gift_card');
        $this->setPhpName('GiftCard');
        $this->setClassName('\\TheliaGiftCard\\Model\\GiftCard');
        $this->setPackage('TheliaGiftCard.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('SPONSOR_CUSTOMER_ID', 'SponsorCustomerId', 'INTEGER', 'customer', 'ID', false, null, null);
        $this->addForeignKey('ORDER_ID', 'OrderId', 'INTEGER', 'order', 'ID', false, null, null);
        $this->addForeignKey('PRODUCT_ID', 'ProductId', 'INTEGER', 'product', 'ID', false, null, null);
        $this->addColumn('CODE', 'Code', 'VARCHAR', true, 100, null);
        $this->addColumn('TO_NAME', 'ToName', 'VARCHAR', false, 100, null);
        $this->addColumn('TO_MESSAGE', 'ToMessage', 'VARCHAR', false, 100, null);
        $this->addColumn('AMOUNT', 'Amount', 'DECIMAL', false, 16, null);
        $this->addColumn('STATUS', 'Status', 'INTEGER', false, 1, null);
        $this->addColumn('EXPIRATION_DATE', 'ExpirationDate', 'DATE', true, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Customer', '\\Thelia\\Model\\Customer', RelationMap::MANY_TO_ONE, array('sponsor_customer_id' => 'id', ), 'CASCADE', 'CASCADE');
        $this->addRelation('Order', '\\Thelia\\Model\\Order', RelationMap::MANY_TO_ONE, array('order_id' => 'id', ), 'CASCADE', 'CASCADE');
        $this->addRelation('Product', '\\Thelia\\Model\\Product', RelationMap::MANY_TO_ONE, array('product_id' => 'id', ), 'RESTRICT', 'RESTRICT');
        $this->addRelation('GiftCardCustomer', '\\TheliaGiftCard\\Model\\GiftCardCustomer', RelationMap::ONE_TO_MANY, array('id' => 'card_id', ), 'CASCADE', 'CASCADE', 'GiftCardCustomers');
        $this->addRelation('GiftCardCart', '\\TheliaGiftCard\\Model\\GiftCardCart', RelationMap::ONE_TO_MANY, array('id' => 'gift_card_id', ), 'CASCADE', 'CASCADE', 'GiftCardCarts');
        $this->addRelation('GiftCardOrder', '\\TheliaGiftCard\\Model\\GiftCardOrder', RelationMap::ONE_TO_MANY, array('id' => 'gift_card_id', ), 'CASCADE', 'CASCADE', 'GiftCardOrders');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to gift_card     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                GiftCardCustomerTableMap::clearInstancePool();
                GiftCardCartTableMap::clearInstancePool();
                GiftCardOrderTableMap::clearInstancePool();
            }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? GiftCardTableMap::CLASS_DEFAULT : GiftCardTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (GiftCard object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = GiftCardTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = GiftCardTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GiftCardTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GiftCardTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GiftCardTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = GiftCardTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = GiftCardTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                GiftCardTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(GiftCardTableMap::ID);
            $criteria->addSelectColumn(GiftCardTableMap::SPONSOR_CUSTOMER_ID);
            $criteria->addSelectColumn(GiftCardTableMap::ORDER_ID);
            $criteria->addSelectColumn(GiftCardTableMap::PRODUCT_ID);
            $criteria->addSelectColumn(GiftCardTableMap::CODE);
            $criteria->addSelectColumn(GiftCardTableMap::TO_NAME);
            $criteria->addSelectColumn(GiftCardTableMap::TO_MESSAGE);
            $criteria->addSelectColumn(GiftCardTableMap::AMOUNT);
            $criteria->addSelectColumn(GiftCardTableMap::STATUS);
            $criteria->addSelectColumn(GiftCardTableMap::EXPIRATION_DATE);
            $criteria->addSelectColumn(GiftCardTableMap::CREATED_AT);
            $criteria->addSelectColumn(GiftCardTableMap::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.SPONSOR_CUSTOMER_ID');
            $criteria->addSelectColumn($alias . '.ORDER_ID');
            $criteria->addSelectColumn($alias . '.PRODUCT_ID');
            $criteria->addSelectColumn($alias . '.CODE');
            $criteria->addSelectColumn($alias . '.TO_NAME');
            $criteria->addSelectColumn($alias . '.TO_MESSAGE');
            $criteria->addSelectColumn($alias . '.AMOUNT');
            $criteria->addSelectColumn($alias . '.STATUS');
            $criteria->addSelectColumn($alias . '.EXPIRATION_DATE');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(GiftCardTableMap::DATABASE_NAME)->getTable(GiftCardTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(GiftCardTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(GiftCardTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new GiftCardTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a GiftCard or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or GiftCard object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GiftCardTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \TheliaGiftCard\Model\GiftCard) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(GiftCardTableMap::DATABASE_NAME);
            $criteria->add(GiftCardTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = GiftCardQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { GiftCardTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { GiftCardTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the gift_card table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return GiftCardQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a GiftCard or Criteria object.
     *
     * @param mixed               $criteria Criteria or GiftCard object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GiftCardTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from GiftCard object
        }

        if ($criteria->containsKey(GiftCardTableMap::ID) && $criteria->keyContainsValue(GiftCardTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.GiftCardTableMap::ID.')');
        }


        // Set the correct dbName
        $query = GiftCardQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // GiftCardTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
GiftCardTableMap::buildTableMap();

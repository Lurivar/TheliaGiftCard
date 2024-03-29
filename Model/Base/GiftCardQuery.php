<?php

namespace TheliaGiftCard\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use TheliaGiftCard\Model\GiftCard as ChildGiftCard;
use TheliaGiftCard\Model\GiftCardQuery as ChildGiftCardQuery;
use TheliaGiftCard\Model\Map\GiftCardTableMap;
use Thelia\Model\Customer;
use Thelia\Model\Order;
use Thelia\Model\Product;

/**
 * Base class that represents a query for the 'gift_card' table.
 *
 *
 *
 * @method     ChildGiftCardQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGiftCardQuery orderBySponsorCustomerId($order = Criteria::ASC) Order by the sponsor_customer_id column
 * @method     ChildGiftCardQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildGiftCardQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildGiftCardQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildGiftCardQuery orderByToName($order = Criteria::ASC) Order by the to_name column
 * @method     ChildGiftCardQuery orderByToMessage($order = Criteria::ASC) Order by the to_message column
 * @method     ChildGiftCardQuery orderByAmount($order = Criteria::ASC) Order by the amount column
 * @method     ChildGiftCardQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildGiftCardQuery orderByExpirationDate($order = Criteria::ASC) Order by the expiration_date column
 * @method     ChildGiftCardQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildGiftCardQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildGiftCardQuery groupById() Group by the id column
 * @method     ChildGiftCardQuery groupBySponsorCustomerId() Group by the sponsor_customer_id column
 * @method     ChildGiftCardQuery groupByOrderId() Group by the order_id column
 * @method     ChildGiftCardQuery groupByProductId() Group by the product_id column
 * @method     ChildGiftCardQuery groupByCode() Group by the code column
 * @method     ChildGiftCardQuery groupByToName() Group by the to_name column
 * @method     ChildGiftCardQuery groupByToMessage() Group by the to_message column
 * @method     ChildGiftCardQuery groupByAmount() Group by the amount column
 * @method     ChildGiftCardQuery groupByStatus() Group by the status column
 * @method     ChildGiftCardQuery groupByExpirationDate() Group by the expiration_date column
 * @method     ChildGiftCardQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildGiftCardQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildGiftCardQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGiftCardQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGiftCardQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGiftCardQuery leftJoinCustomer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Customer relation
 * @method     ChildGiftCardQuery rightJoinCustomer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Customer relation
 * @method     ChildGiftCardQuery innerJoinCustomer($relationAlias = null) Adds a INNER JOIN clause to the query using the Customer relation
 *
 * @method     ChildGiftCardQuery leftJoinOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the Order relation
 * @method     ChildGiftCardQuery rightJoinOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Order relation
 * @method     ChildGiftCardQuery innerJoinOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the Order relation
 *
 * @method     ChildGiftCardQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildGiftCardQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildGiftCardQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildGiftCardQuery leftJoinGiftCardCustomer($relationAlias = null) Adds a LEFT JOIN clause to the query using the GiftCardCustomer relation
 * @method     ChildGiftCardQuery rightJoinGiftCardCustomer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GiftCardCustomer relation
 * @method     ChildGiftCardQuery innerJoinGiftCardCustomer($relationAlias = null) Adds a INNER JOIN clause to the query using the GiftCardCustomer relation
 *
 * @method     ChildGiftCardQuery leftJoinGiftCardCart($relationAlias = null) Adds a LEFT JOIN clause to the query using the GiftCardCart relation
 * @method     ChildGiftCardQuery rightJoinGiftCardCart($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GiftCardCart relation
 * @method     ChildGiftCardQuery innerJoinGiftCardCart($relationAlias = null) Adds a INNER JOIN clause to the query using the GiftCardCart relation
 *
 * @method     ChildGiftCardQuery leftJoinGiftCardOrder($relationAlias = null) Adds a LEFT JOIN clause to the query using the GiftCardOrder relation
 * @method     ChildGiftCardQuery rightJoinGiftCardOrder($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GiftCardOrder relation
 * @method     ChildGiftCardQuery innerJoinGiftCardOrder($relationAlias = null) Adds a INNER JOIN clause to the query using the GiftCardOrder relation
 *
 * @method     ChildGiftCard findOne(ConnectionInterface $con = null) Return the first ChildGiftCard matching the query
 * @method     ChildGiftCard findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGiftCard matching the query, or a new ChildGiftCard object populated from the query conditions when no match is found
 *
 * @method     ChildGiftCard findOneById(int $id) Return the first ChildGiftCard filtered by the id column
 * @method     ChildGiftCard findOneBySponsorCustomerId(int $sponsor_customer_id) Return the first ChildGiftCard filtered by the sponsor_customer_id column
 * @method     ChildGiftCard findOneByOrderId(int $order_id) Return the first ChildGiftCard filtered by the order_id column
 * @method     ChildGiftCard findOneByProductId(int $product_id) Return the first ChildGiftCard filtered by the product_id column
 * @method     ChildGiftCard findOneByCode(string $code) Return the first ChildGiftCard filtered by the code column
 * @method     ChildGiftCard findOneByToName(string $to_name) Return the first ChildGiftCard filtered by the to_name column
 * @method     ChildGiftCard findOneByToMessage(string $to_message) Return the first ChildGiftCard filtered by the to_message column
 * @method     ChildGiftCard findOneByAmount(string $amount) Return the first ChildGiftCard filtered by the amount column
 * @method     ChildGiftCard findOneByStatus(int $status) Return the first ChildGiftCard filtered by the status column
 * @method     ChildGiftCard findOneByExpirationDate(string $expiration_date) Return the first ChildGiftCard filtered by the expiration_date column
 * @method     ChildGiftCard findOneByCreatedAt(string $created_at) Return the first ChildGiftCard filtered by the created_at column
 * @method     ChildGiftCard findOneByUpdatedAt(string $updated_at) Return the first ChildGiftCard filtered by the updated_at column
 *
 * @method     array findById(int $id) Return ChildGiftCard objects filtered by the id column
 * @method     array findBySponsorCustomerId(int $sponsor_customer_id) Return ChildGiftCard objects filtered by the sponsor_customer_id column
 * @method     array findByOrderId(int $order_id) Return ChildGiftCard objects filtered by the order_id column
 * @method     array findByProductId(int $product_id) Return ChildGiftCard objects filtered by the product_id column
 * @method     array findByCode(string $code) Return ChildGiftCard objects filtered by the code column
 * @method     array findByToName(string $to_name) Return ChildGiftCard objects filtered by the to_name column
 * @method     array findByToMessage(string $to_message) Return ChildGiftCard objects filtered by the to_message column
 * @method     array findByAmount(string $amount) Return ChildGiftCard objects filtered by the amount column
 * @method     array findByStatus(int $status) Return ChildGiftCard objects filtered by the status column
 * @method     array findByExpirationDate(string $expiration_date) Return ChildGiftCard objects filtered by the expiration_date column
 * @method     array findByCreatedAt(string $created_at) Return ChildGiftCard objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildGiftCard objects filtered by the updated_at column
 *
 */
abstract class GiftCardQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \TheliaGiftCard\Model\Base\GiftCardQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\TheliaGiftCard\\Model\\GiftCard', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGiftCardQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGiftCardQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \TheliaGiftCard\Model\GiftCardQuery) {
            return $criteria;
        }
        $query = new \TheliaGiftCard\Model\GiftCardQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildGiftCard|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = GiftCardTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GiftCardTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildGiftCard A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, SPONSOR_CUSTOMER_ID, ORDER_ID, PRODUCT_ID, CODE, TO_NAME, TO_MESSAGE, AMOUNT, STATUS, EXPIRATION_DATE, CREATED_AT, UPDATED_AT FROM gift_card WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildGiftCard();
            $obj->hydrate($row);
            GiftCardTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildGiftCard|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GiftCardTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GiftCardTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GiftCardTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GiftCardTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiftCardTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the sponsor_customer_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySponsorCustomerId(1234); // WHERE sponsor_customer_id = 1234
     * $query->filterBySponsorCustomerId(array(12, 34)); // WHERE sponsor_customer_id IN (12, 34)
     * $query->filterBySponsorCustomerId(array('min' => 12)); // WHERE sponsor_customer_id > 12
     * </code>
     *
     * @see       filterByCustomer()
     *
     * @param     mixed $sponsorCustomerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterBySponsorCustomerId($sponsorCustomerId = null, $comparison = null)
    {
        if (is_array($sponsorCustomerId)) {
            $useMinMax = false;
            if (isset($sponsorCustomerId['min'])) {
                $this->addUsingAlias(GiftCardTableMap::SPONSOR_CUSTOMER_ID, $sponsorCustomerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sponsorCustomerId['max'])) {
                $this->addUsingAlias(GiftCardTableMap::SPONSOR_CUSTOMER_ID, $sponsorCustomerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiftCardTableMap::SPONSOR_CUSTOMER_ID, $sponsorCustomerId, $comparison);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId(1234); // WHERE order_id = 1234
     * $query->filterByOrderId(array(12, 34)); // WHERE order_id IN (12, 34)
     * $query->filterByOrderId(array('min' => 12)); // WHERE order_id > 12
     * </code>
     *
     * @see       filterByOrder()
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(GiftCardTableMap::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(GiftCardTableMap::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiftCardTableMap::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductId(1234); // WHERE product_id = 1234
     * $query->filterByProductId(array(12, 34)); // WHERE product_id IN (12, 34)
     * $query->filterByProductId(array('min' => 12)); // WHERE product_id > 12
     * </code>
     *
     * @see       filterByProduct()
     *
     * @param     mixed $productId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(GiftCardTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(GiftCardTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiftCardTableMap::PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $code)) {
                $code = str_replace('*', '%', $code);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(GiftCardTableMap::CODE, $code, $comparison);
    }

    /**
     * Filter the query on the to_name column
     *
     * Example usage:
     * <code>
     * $query->filterByToName('fooValue');   // WHERE to_name = 'fooValue'
     * $query->filterByToName('%fooValue%'); // WHERE to_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $toName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByToName($toName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($toName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $toName)) {
                $toName = str_replace('*', '%', $toName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(GiftCardTableMap::TO_NAME, $toName, $comparison);
    }

    /**
     * Filter the query on the to_message column
     *
     * Example usage:
     * <code>
     * $query->filterByToMessage('fooValue');   // WHERE to_message = 'fooValue'
     * $query->filterByToMessage('%fooValue%'); // WHERE to_message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $toMessage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByToMessage($toMessage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($toMessage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $toMessage)) {
                $toMessage = str_replace('*', '%', $toMessage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(GiftCardTableMap::TO_MESSAGE, $toMessage, $comparison);
    }

    /**
     * Filter the query on the amount column
     *
     * Example usage:
     * <code>
     * $query->filterByAmount(1234); // WHERE amount = 1234
     * $query->filterByAmount(array(12, 34)); // WHERE amount IN (12, 34)
     * $query->filterByAmount(array('min' => 12)); // WHERE amount > 12
     * </code>
     *
     * @param     mixed $amount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByAmount($amount = null, $comparison = null)
    {
        if (is_array($amount)) {
            $useMinMax = false;
            if (isset($amount['min'])) {
                $this->addUsingAlias(GiftCardTableMap::AMOUNT, $amount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amount['max'])) {
                $this->addUsingAlias(GiftCardTableMap::AMOUNT, $amount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiftCardTableMap::AMOUNT, $amount, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus(1234); // WHERE status = 1234
     * $query->filterByStatus(array(12, 34)); // WHERE status IN (12, 34)
     * $query->filterByStatus(array('min' => 12)); // WHERE status > 12
     * </code>
     *
     * @param     mixed $status The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(GiftCardTableMap::STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(GiftCardTableMap::STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiftCardTableMap::STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the expiration_date column
     *
     * Example usage:
     * <code>
     * $query->filterByExpirationDate('2011-03-14'); // WHERE expiration_date = '2011-03-14'
     * $query->filterByExpirationDate('now'); // WHERE expiration_date = '2011-03-14'
     * $query->filterByExpirationDate(array('max' => 'yesterday')); // WHERE expiration_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $expirationDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByExpirationDate($expirationDate = null, $comparison = null)
    {
        if (is_array($expirationDate)) {
            $useMinMax = false;
            if (isset($expirationDate['min'])) {
                $this->addUsingAlias(GiftCardTableMap::EXPIRATION_DATE, $expirationDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expirationDate['max'])) {
                $this->addUsingAlias(GiftCardTableMap::EXPIRATION_DATE, $expirationDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiftCardTableMap::EXPIRATION_DATE, $expirationDate, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(GiftCardTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(GiftCardTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiftCardTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(GiftCardTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(GiftCardTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GiftCardTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Customer object
     *
     * @param \Thelia\Model\Customer|ObjectCollection $customer The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByCustomer($customer, $comparison = null)
    {
        if ($customer instanceof \Thelia\Model\Customer) {
            return $this
                ->addUsingAlias(GiftCardTableMap::SPONSOR_CUSTOMER_ID, $customer->getId(), $comparison);
        } elseif ($customer instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GiftCardTableMap::SPONSOR_CUSTOMER_ID, $customer->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCustomer() only accepts arguments of type \Thelia\Model\Customer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Customer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function joinCustomer($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Customer');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Customer');
        }

        return $this;
    }

    /**
     * Use the Customer relation Customer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\CustomerQuery A secondary query class using the current class as primary query
     */
    public function useCustomerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCustomer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Customer', '\Thelia\Model\CustomerQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\Order object
     *
     * @param \Thelia\Model\Order|ObjectCollection $order The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByOrder($order, $comparison = null)
    {
        if ($order instanceof \Thelia\Model\Order) {
            return $this
                ->addUsingAlias(GiftCardTableMap::ORDER_ID, $order->getId(), $comparison);
        } elseif ($order instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GiftCardTableMap::ORDER_ID, $order->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOrder() only accepts arguments of type \Thelia\Model\Order or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Order relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function joinOrder($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Order');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Order');
        }

        return $this;
    }

    /**
     * Use the Order relation Order object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\OrderQuery A secondary query class using the current class as primary query
     */
    public function useOrderQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Order', '\Thelia\Model\OrderQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\Product object
     *
     * @param \Thelia\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \Thelia\Model\Product) {
            return $this
                ->addUsingAlias(GiftCardTableMap::PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GiftCardTableMap::PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \Thelia\Model\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function joinProduct($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Product');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Product');
        }

        return $this;
    }

    /**
     * Use the Product relation Product object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\Thelia\Model\ProductQuery');
    }

    /**
     * Filter the query by a related \TheliaGiftCard\Model\GiftCardCustomer object
     *
     * @param \TheliaGiftCard\Model\GiftCardCustomer|ObjectCollection $giftCardCustomer  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByGiftCardCustomer($giftCardCustomer, $comparison = null)
    {
        if ($giftCardCustomer instanceof \TheliaGiftCard\Model\GiftCardCustomer) {
            return $this
                ->addUsingAlias(GiftCardTableMap::ID, $giftCardCustomer->getCardId(), $comparison);
        } elseif ($giftCardCustomer instanceof ObjectCollection) {
            return $this
                ->useGiftCardCustomerQuery()
                ->filterByPrimaryKeys($giftCardCustomer->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGiftCardCustomer() only accepts arguments of type \TheliaGiftCard\Model\GiftCardCustomer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GiftCardCustomer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function joinGiftCardCustomer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GiftCardCustomer');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'GiftCardCustomer');
        }

        return $this;
    }

    /**
     * Use the GiftCardCustomer relation GiftCardCustomer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \TheliaGiftCard\Model\GiftCardCustomerQuery A secondary query class using the current class as primary query
     */
    public function useGiftCardCustomerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGiftCardCustomer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GiftCardCustomer', '\TheliaGiftCard\Model\GiftCardCustomerQuery');
    }

    /**
     * Filter the query by a related \TheliaGiftCard\Model\GiftCardCart object
     *
     * @param \TheliaGiftCard\Model\GiftCardCart|ObjectCollection $giftCardCart  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByGiftCardCart($giftCardCart, $comparison = null)
    {
        if ($giftCardCart instanceof \TheliaGiftCard\Model\GiftCardCart) {
            return $this
                ->addUsingAlias(GiftCardTableMap::ID, $giftCardCart->getGiftCardId(), $comparison);
        } elseif ($giftCardCart instanceof ObjectCollection) {
            return $this
                ->useGiftCardCartQuery()
                ->filterByPrimaryKeys($giftCardCart->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGiftCardCart() only accepts arguments of type \TheliaGiftCard\Model\GiftCardCart or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GiftCardCart relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function joinGiftCardCart($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GiftCardCart');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'GiftCardCart');
        }

        return $this;
    }

    /**
     * Use the GiftCardCart relation GiftCardCart object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \TheliaGiftCard\Model\GiftCardCartQuery A secondary query class using the current class as primary query
     */
    public function useGiftCardCartQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGiftCardCart($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GiftCardCart', '\TheliaGiftCard\Model\GiftCardCartQuery');
    }

    /**
     * Filter the query by a related \TheliaGiftCard\Model\GiftCardOrder object
     *
     * @param \TheliaGiftCard\Model\GiftCardOrder|ObjectCollection $giftCardOrder  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function filterByGiftCardOrder($giftCardOrder, $comparison = null)
    {
        if ($giftCardOrder instanceof \TheliaGiftCard\Model\GiftCardOrder) {
            return $this
                ->addUsingAlias(GiftCardTableMap::ID, $giftCardOrder->getGiftCardId(), $comparison);
        } elseif ($giftCardOrder instanceof ObjectCollection) {
            return $this
                ->useGiftCardOrderQuery()
                ->filterByPrimaryKeys($giftCardOrder->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGiftCardOrder() only accepts arguments of type \TheliaGiftCard\Model\GiftCardOrder or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GiftCardOrder relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function joinGiftCardOrder($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GiftCardOrder');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'GiftCardOrder');
        }

        return $this;
    }

    /**
     * Use the GiftCardOrder relation GiftCardOrder object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \TheliaGiftCard\Model\GiftCardOrderQuery A secondary query class using the current class as primary query
     */
    public function useGiftCardOrderQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGiftCardOrder($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GiftCardOrder', '\TheliaGiftCard\Model\GiftCardOrderQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGiftCard $giftCard Object to remove from the list of results
     *
     * @return ChildGiftCardQuery The current query, for fluid interface
     */
    public function prune($giftCard = null)
    {
        if ($giftCard) {
            $this->addUsingAlias(GiftCardTableMap::ID, $giftCard->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the gift_card table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GiftCardTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GiftCardTableMap::clearInstancePool();
            GiftCardTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildGiftCard or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildGiftCard object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GiftCardTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GiftCardTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        GiftCardTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GiftCardTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildGiftCardQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(GiftCardTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildGiftCardQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(GiftCardTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildGiftCardQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(GiftCardTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildGiftCardQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(GiftCardTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildGiftCardQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(GiftCardTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildGiftCardQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(GiftCardTableMap::CREATED_AT);
    }

} // GiftCardQuery

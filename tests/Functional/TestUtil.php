<?php

namespace Umbrellio\Postgres\Tests\Functional;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Illuminate\Support\Facades\DB;
use function explode;
use Umbrellio\Postgres\PostgresConnection;

/**
 * TestUtil is a class with static utility methods used during tests.
 */
class TestUtil
{
    /** @var bool Whether the database schema is initialized. */
    private static $initialized = false;

    /**
     * Gets a <b>real</b> database connection using the following parameters
     * of the $GLOBALS array:
     *
     * 'db_type' : The name of the Doctrine DBAL database driver to use.
     * 'db_username' : The username to use for connecting.
     * 'db_password' : The password to use for connecting.
     * 'db_host' : The hostname of the database to connect to.
     * 'db_server' : The server name of the database to connect to
     *               (optional, some vendors allow multiple server instances with different names on the same host).
     * 'db_name' : The name of the database to connect to.
     * 'db_port' : The port of the database to connect to.
     *
     * Usually these variables of the $GLOBALS array are filled by PHPUnit based
     * on an XML configuration file. If no such parameters exist, an SQLite
     * in-memory database is used.
     *
     * IMPORTANT: Each invocation of this method returns a NEW database connection.
     *
     * @return Connection The database connection instance.
     */
    public static function getConnection() : Connection
    {
        if (self::hasRequiredConnectionParams() && ! self::$initialized) {
            self::initializeDatabase();
            self::$initialized = true;
        }

        $conn = static::getDoctrineConnection();

        self::addDbEventSubscribers($conn);

        return $conn;
    }

    private static function hasRequiredConnectionParams() : bool
    {
        return isset(
            $GLOBALS['db_type'],
            $GLOBALS['db_username'],
            $GLOBALS['db_password'],
            $GLOBALS['db_host'],
            $GLOBALS['db_name'],
            $GLOBALS['db_port']
        )
        && isset(
            $GLOBALS['tmpdb_type'],
            $GLOBALS['tmpdb_username'],
            $GLOBALS['tmpdb_password'],
            $GLOBALS['tmpdb_host'],
            $GLOBALS['tmpdb_port']
        );
    }

    private static function initializeDatabase() : void
    {
        $realConn = static::createDoctrineConnection(self::getParamsForMainConnection());
        $tmpConn = static::createDoctrineConnection(self::getParamsForTemporaryConnection());


        $platform = $tmpConn->getDatabasePlatform();

        if ($platform->supportsCreateDropDatabase()) {
            $dbname = $realConn->getDatabase();
            $realConn->close();

            $tmpConn->getSchemaManager()->dropAndCreateDatabase($dbname);

            $tmpConn->close();
        } else {
            //UPDATE pg_database SET datallowconn = true WHERE datname = 'my_database';
            $sm = $realConn->getSchemaManager();

            $schema = $sm->createSchema();
            $stmts  = $schema->toDropSql($realConn->getDatabasePlatform());

            foreach ($stmts as $stmt) {
                $realConn->exec($stmt);
            }
        }
    }

    private static function addDbEventSubscribers(Connection $conn) : void
    {
        if (! isset($GLOBALS['db_event_subscribers'])) {
            return;
        }

        $evm = $conn->getEventManager();
        foreach (explode(',', $GLOBALS['db_event_subscribers']) as $subscriberClass) {
            $subscriberInstance = new $subscriberClass();
            $evm->addEventSubscriber($subscriberInstance);
        }
    }

    public static function getTempConnection() : Connection
    {
        return static::getDoctrineConnection('temporary');
    }

    private static function getDoctrineConnection(string $name = null): Connection
    {
        /** @var PostgresConnection $connection */
        $connection = DB::connection($name);
        return $connection->getDoctrineConnection();
    }

    private static function createDoctrineConnection($params): Connection
    {
        return DriverManager::getConnection($params);
    }

    public static function getParamsForMainConnection() : array
    {
        $connectionParams = [
            'driver' => $GLOBALS['db_type'],
            'user' => $GLOBALS['db_username'],
            'password' => $GLOBALS['db_password'],
            'host' => $GLOBALS['db_host'],
            'dbname' => $GLOBALS['db_name'],
            'port' => $GLOBALS['db_port'],
        ];

        if (isset($GLOBALS['db_server'])) {
            $connectionParams['server'] = $GLOBALS['db_server'];
        }

        if (isset($GLOBALS['db_unix_socket'])) {
            $connectionParams['unix_socket'] = $GLOBALS['db_unix_socket'];
        }

        return $connectionParams;
    }

    /**
     * @return mixed[]
     */
    public static function getParamsForTemporaryConnection() : array
    {
        $connectionParams = [
            'driver' => $GLOBALS['tmpdb_type'],
            'user' => $GLOBALS['tmpdb_username'],
            'password' => $GLOBALS['tmpdb_password'],
            'host' => $GLOBALS['tmpdb_host'],
            'dbname' => null,
            'port' => $GLOBALS['tmpdb_port'],
        ];

        if (isset($GLOBALS['tmpdb_name'])) {
            $connectionParams['dbname'] = $GLOBALS['tmpdb_name'];
        }

        if (isset($GLOBALS['tmpdb_server'])) {
            $connectionParams['server'] = $GLOBALS['tmpdb_server'];
        }

        if (isset($GLOBALS['tmpdb_unix_socket'])) {
            $connectionParams['unix_socket'] = $GLOBALS['tmpdb_unix_socket'];
        }

        return $connectionParams;
    }
}
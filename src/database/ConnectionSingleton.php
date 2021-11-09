<?php

namespace database;

class ConnectionSingleton
{
    private static ?PgConnection $pgConnect = null;

    public static function getPgConnection(): ?PgConnection
    {
        if (self::$pgConnect == null)
            self::$pgConnect = PgConnection::createFromJson(file_get_contents(__CONFIG__."/postgres.json"));
        return self::$pgConnect;
    }
}
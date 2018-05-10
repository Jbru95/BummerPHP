<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2018/3/24
 * Time: 23:55
 */

namespace Bummer;
require __DIR__ . "/../vendor/autoload.php";


class Validators extends Table {

    /**
     * Constructor
     * @param $site Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "validator");
    }

    /**
     * Create a new validator and add it to the table.
     * @param $userid string User this validator is for.
     * @return string new validator.
     */
    public function newValidator($userid) {
        $validator = $this->createValidator();

        // Write to the table
        $sql =<<<SQL
INSERT INTO $this->tableName(userid, validator)
VALUES (?, ?)
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if($statement->execute(array($userid,
                        $validator)
                ) === false) {
                return null;
            }
        } catch(\PDOException $e) {
            return null;
        }

        return $validator;
    }

    /**
     * Generate a random validator string of characters
     * @param $len
     * @returns  string
     */
    public function createValidator($len = 32) {
        $bytes = openssl_random_pseudo_bytes($len / 2);
        return bin2hex($bytes);
    }


    /**
     * Determine if a validator is valid. If it is,
     * return the user ID for that validator.
     * @param $validator Validator to look up
     * @return User ID or null if not found.
     */
    public function get($validator) {
        $sql =<<<SQL
SELECT userid from $this->tableName
where validator=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($validator));
        if($statement->rowCount() === 0) {
            return null;
        }
        return $statement->fetch(\PDO::FETCH_ASSOC)['userid'];
    }


    /**
     * Remove any validators for this user ID.
     * @param $userid The USER ID we are clearing validators for.
     */
    public function remove($userid) {
        $sql =<<<SQL
DELETE FROM $this->tableName
WHERE userid=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));
    }
}
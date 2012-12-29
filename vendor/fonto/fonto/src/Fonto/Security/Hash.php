<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Security
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\Security;

use Hautelook\Phpass\PasswordHash;

/**
 * Hash class uses Phpass and is responsible for hashing
 * passwords.
 *
 * @package Fonto_Security
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Hash
{
    /**
     * PasswordHash object
     *
     * @var \Hautelook\Phpass\PasswordHash
     */
    protected $phpass;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->phpass = new PasswordHash(8, false);
    }

    /**
     * Returns a hashed password string
     *
     * @param  string $password
     * @return string
     */
    public function hashPassword($password)
    {
        return $this->phpass->HashPassword($password);
    }

    /**
     * Validates a password against a stored password
     *
     * @param  string $password
     * @param  string $storedPassword
     * @return bool
     */
    public function checkPassword($password, $storedPassword)
    {
        return (bool)$this->phpass->CheckPassword($password, $storedPassword);
    }
}
<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Core\Security;

use Hautelook\Phpass\PasswordHash;

class Hash
{
    /**
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
     * Returnes a hashed password string
     *
     * @param $password
     * @return string
     */
    public function hashPassword($password)
    {
        return $this->phpass->HashPassword($password);
    }

    /**
     * Validates a password against a stored password
     *
     * @param $password
     * @param $storedPassword
     * @return bool
     */
    public function checkPassword($password, $storedPassword)
    {
        return (bool)$this->phpass->CheckPassword($password, $storedPassword);
    }
}
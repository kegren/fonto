<?php
/**
 * Fonto - PHP framework
 *
 * @author   Kenny Damgren <kenny.damgren@gmail.com>
 * @package  Fonto_Authentication
 * @link     https://github.com/kenren/fonto
 * @version  0.5
 */

namespace Fonto\Authentication;

use Fonto\Http\Session;
use Fonto\Security\Hash;
use Doctrine\ORM\EntityManager;

/**
 * Authentication class which uses doctrine as ORM.
 *
 * @package Fonto_Authentication
 * @link    https://github.com/kenren/fonto
 * @author  Kenny Damgren <kenny.damgren@gmail.com>
 */
class Auth
{
    /**
     * User data
     *
     * @var
     */
    protected $user;

    /**
     * Session object
     *
     * @var \Fonto\Http\Session
     */
    protected $session;

    /**
     * Hash object
     *
     * @var \Fonto\Security\Hash
     */
    protected $hash;

    /**
     * Doctrine Entity Manager object
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * User model
     *
     * @var
     */
    protected $model;

    /**
     * Constructor
     *
     * @param  \Fonto\Http\Session   $session
     * @param  \Fonto\Security\Hash  $hash
     */
    public function __construct(Session $session, Hash $hash)
    {
        $this->session = $session;
        $this->hash = $hash;
    }

    /**
     * Sets the entity manager object
     *
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Sets model
     *
     * @param $model
     */
    public function setModel($model)
    {
        $this->model = get_class($model); // Namespace rather
    }

    /**
     * Logs in an user based on input credentials
     *
     * @param   array  $credentials
     * @return  bool
     */
    public function login($credentials = array())
    {
        $this->user = $this->em->getRepository($this->model)->findOneBy(
            array('username' => $credentials['username'])
        );

        if ($this->user) {

            $matched = $this->hash->checkPassword($credentials['password'], $this->user->getPassword());

            if ($matched) {

                $roles = $this->user->getRoles(); // Gets an users roles

                if ($roles != null) {
                    $rolesArray = array();
                    foreach ($roles as $role) {
                        $rolesArray[$role->getName()] = $role->getName();
                    }
                }

                // Saves an user credentials to session
                $this->session->save(
                    'user',
                    array(
                        'id' => $this->user->getId(),
                        'username' => $this->user->getUsername(),
                        'email' => $this->user->getEmail(),
                        'name' => $this->user->getName(),
                        'roles' => $rolesArray
                    )
                );

                return true;
            } else {
                return false;
            }

        }

        return false;
    }

    /**
     * Checks if an user is logged in
     *
     * @return mixed
     */
    public function isAuthenticated()
    {
        return $this->session->has('user');
    }

    /**
     * Sets an users data to null and destroys the session data
     *
     * @return void
     */
    public function logout()
    {
        $this->user = null;
        $this->session->forget('user');
    }

    /**
     * Returns the user id
     *
     * @return mixed
     */
    public function getAuthedId()
    {
        $user = $this->session->get('user');
        $userId = $user['id'];
        return $userId;
    }

}
<?php

/**
 * sfGuardUserTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class sfGuardUserTable extends PluginsfGuardUserTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object sfGuardUserTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardUser');
    }
    public function retrieveByUsername($username, $isActive = true)
    {
    $query = self::getInstance()
        ->createQuery('u')
        ->where('u.email_address = ?', $username)
        ->orWhere('u.username = ?', $username)
        ->addWhere('u.is_active = ?', $isActive);
 
    return $query->fetchOne();
    }
}
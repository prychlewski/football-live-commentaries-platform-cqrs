<?php


namespace App\Query\User;


use App\View\UserView;
use Doctrine\DBAL\Connection;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\UserNotFoundException;

class DbalUserQuery implements UserQuery
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getById(int $userId): UserView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select('u.id, u.username, u.roles')
            ->from('user', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->execute();
        $userData = $statement->fetch();

        return $this->createUserView($userData);
    }

    public function getByUsername(string $username): UserView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder->select('u.id, u.username, u.roles')
            ->from('user', 'u')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->execute();
        $userData = $statement->fetch();

        return $this->createUserView($userData);
    }

    private function createUserView(&$userData): UserView
    {
        if (!$userData) {
            throw new UserNotFoundException();
        }

        return new UserView(
            $userData['id'],
            $userData['username'],
            unserialize($userData['roles'])
        );
    }
}

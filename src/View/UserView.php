<?php

namespace App\View;

use JMS\Serializer\Annotation\Type;

final class UserView
{
    /**
     * @var int
     *
     * @Type("integer")
     */
    private $id;

    /**
     * @var string
     *
     * @Type("string")
     */
    private $username;

    /**
     * @var array
     *
     * @Type("array")
     */
    private $roles;

    public function __construct(int $id, string $username, array $roles)
    {
        $this->id = $id;
        $this->roles = $roles;
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}

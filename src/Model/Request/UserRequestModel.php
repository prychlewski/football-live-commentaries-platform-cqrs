<?php


namespace App\Model\Request;

use JMS\Serializer\Annotation\Type;

class UserRequestModel
{
    /**
     * @var string
     *
     * @Type("string")
     */
    protected $username;

    /**
     * @var string
     *
     * @Type("string")
     */
    protected $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}

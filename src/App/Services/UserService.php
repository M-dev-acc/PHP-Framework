<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
    public function __construct(
        private Database $db
    )
    {
    }

    public function checkEmailExists(string $email) : void {
        $isEmailExists = $this->db->query(
            "SELECT COUNT(*) FROM users WHERE email = :email",
            [
                'email' => $email
            ]
        )->count();
        if ((bool) $isEmailExists) {
            throw new ValidationException([
                'email' => "Email already taken."
            ]);
        }
    }

    public function create(array $data) : void {
        $this->db->query(
            "INSERT INTO users
            (email, password, age, country, social_media_url)
            VALUES(:email, :password, :age, :country, :social_media_url)",
            [
                'email' => $data['email'],
                'password' => password_hash(
                    $data['password'], 
                    PASSWORD_BCRYPT,
                    [
                        'cost' => 12
                    ]),
                'age' => $data['age'],
                'country' => $data['country'],
                'social_media_url' => $data['social_media_url'],
            ]
        );
    }
}

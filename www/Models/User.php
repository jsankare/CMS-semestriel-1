<?php
namespace App\Models;
use App\Core\SQL;

class User extends SQL
{


    private ?int $id = null;
    protected string $firstname;
    protected string $lastname;
    protected string $email;
    protected string $password;
    protected ?string $validation_code;
    protected int $status = 0;

    protected ?string $reset_token = null;

    protected ?string $token_expiration = null;


    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }

        /**
     * @return ?string
     */
    public function getValidationCode(): string
    {
        return $this->validation_code;
    }

    /**
     * @param ?string $validation_code
     */
    public function setValidationCode(string $validation_code): void
    {
        $this->validation_code = $validation_code;
    }

    /**
     * @return string
     */
    public function getResetToken(): string
    {
        return $this->reset_token;
    }

    /**
     * @param ?string $reset_token
     */
    public function setResetToken(?string $reset_token): void
    {
        $this->reset_token = $reset_token;
    }

    /**
     * @return ?string
     */
    public function getTokenExpiration(): string
    {
        return $this->token_expiration;
    }

    /**
     * @param ?string $token_expiration
     */
    public function setTokenExpiration(?string $token_expiration): void
    {
        $this->token_expiration = $token_expiration;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = strtoupper(trim($lastname));
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function findOneByEmail(string $email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([":email" => $email]);
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\User');
        return $queryPrepared->fetch();
    }

    public function findOneById(int $id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute([":id" => $id]);
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\User');
        return $queryPrepared->fetch();
    }

    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";

        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        $queryPrepared->setFetchMode(\PDO::FETCH_CLASS, 'App\Models\User');
        return $queryPrepared->fetchAll();
    }

    public function delete(): void
    {
        if (!empty($this->getId())) {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute([':id' => $this->getId()]);
        }
    }

    public function count(): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $queryPrepared = $this->pdo->prepare($sql);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch(\PDO::FETCH_ASSOC);
        return (int) $result['count'];
    }
}

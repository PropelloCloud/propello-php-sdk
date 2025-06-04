<?php

declare(strict_types=1);

namespace PropelloCloud;

use PropelloCloud\Abstracts\ClientAbstract;
use stdClass;
use Throwable;

class UserClient extends ClientAbstract
{
    /**
     * @throws Throwable
     */
    public function __call(string $name, array $arguments): stdClass
    {
        $resolve = fn (string $id, string|int $val, ?array $body = []) => [$id, $val, $body];
        $name = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $name));

        [$identifier, $value, $this->body] = $resolve(...$arguments);
        $this->setUserUrl($name, $identifier, $value);

        return $this->call();
    }

    private function setUserUrl(string $prefix, string $identifier = 'email', string $value = ''): void
    {
        $this->url = "user/{$prefix}/{$identifier}/{$value}";
    }

    /**
     * @throws Throwable
     */
    public function create(array $user = []): stdClass
    {
        $this->url = 'user/create';
        $this->body = $user;

        return $this->call();
    }

    /**
     * @throws Throwable
     */
    public function createBulk(array $users = [], bool $sendEmails = false): stdClass
    {
        $this->url = 'user/create/bulk';
        $this->body = [
            "send_activation_email" => $sendEmails,
            "data" => $users,
        ];

        return $this->call();
    }

    /**
     * @throws Throwable
     */
    public function createWithLogin(array $user = []): stdClass
    {
        $this->url = 'user/create/login-url';
        $this->body = $user;

        return $this->call();
    }

    /**
     * @throws Throwable
     */
    public function getUserByEmail(string $email = ''): stdClass
    {
        return $this->get('email', $email);
    }

    /**
     * @throws Throwable
     */
    public function getUserByUid(string $uid = ''): stdClass
    {
        return $this->get('UID', $uid);
    }

    /**
     * @throws Throwable
     */
    public function getUserById(int|string $id = ''): stdClass
    {
        return $this->get('id', $id);
    }

    /**
     * @throws Throwable
     */
    public function getLoginByEmail(string $email = ''): stdClass
    {
        return $this->loginUrl('email', $email);
    }

    /**
     * @throws Throwable
     */
    public function getLoginByUid(string $uid = ''): stdClass
    {
        return $this->loginUrl('UID', $uid);
    }

    /**
     * @throws Throwable
     */
    public function getLoginById(int|string $id = ''): stdClass
    {
        return $this->loginUrl('id', $id);
    }

    /**
     * @throws Throwable
     */
    public function deleteByEmail(string $email = ''): stdClass
    {
        return $this->delete('email', $email);
    }

    /**
     * @throws Throwable
     */
    public function deleteByUid(string $uid = ''): stdClass
    {
        return $this->delete('UID', $uid);
    }

    /**
     * @throws Throwable
     */
    public function deleteById(int|string $id = ''): stdClass
    {
        return $this->delete('id', $id);
    }

    /**
     * @throws Throwable
     */
    public function restoreByEmail(string $email = ''): stdClass
    {
        return $this->restore('email', $email);
    }

    /**
     * @throws Throwable
     */
    public function restoreByUid(string $uid = ''): stdClass
    {
        return $this->restore('UID', $uid);
    }

    /**
     * @throws Throwable
     */
    public function restoreById(int|string $id = ''): stdClass
    {
        return $this->restore('id', $id);
    }

    /**
     * @throws Throwable
     */
    public function anonymiseByEmail(string $email = ''): stdClass
    {
        return $this->anonymise('email', $email);
    }

    /**
     * @throws Throwable
     */
    public function anonymiseByUid(string $uid = ''): stdClass
    {
        return $this->anonymise('UID', $uid);
    }

    /**
     * @throws Throwable
     */
    public function anonymiseById(int|string $id = ''): stdClass
    {
        return $this->anonymise('id', $id);
    }

    /**
     * @throws Throwable
     */
    public function makeKnownByUid(string $uid = '', array $user = []): stdClass
    {
        return $this->makeKnown('UID', $uid, $user);
    }

    /**
     * @throws Throwable
     */
    public function makeKnownById(int|string $id = '', array $user = []): stdClass
    {
        return $this->makeKnown('id', $id, $user);
    }
}

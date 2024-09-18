<?php

namespace App\Repository;

use App\Entity\Address;

class AddressRepository extends AbstractRepository
{
    function getTable(): string
    {
        return 'address';
    }

    function getEntity(): string
    {
        return Address::class;
    }

    function getCity(): array
    {
        $sql = "SELECT id, name FROM city";
        return $this->connection->execute($sql) ?? [];
    }

    public function findAll($order): array
    {
        $query = "SELECT c.name as cityName, a.* FROM {$this->getTable()} as a JOIN city as c ON a.city_id = c.id order by {$order}";
        return $this->connection->execute($query) ?? [];
    }

    public function create(Address $address)
    {
        $query = "INSERT INTO {$this->getTable()} (street, city_id, zip, email, name, firstName) VALUES (:street, :city_id, :zip, :email, :name, :firstName)";
        $this->connection->execute($query, [
            'street' => $address->street,
            'city_id' => $address->city,
            'zip' => $address->zip,
            'email' => $address->email,
            'name' => $address->name,
            'firstName' => $address->firstName
        ]);

        return $this->connection->lastInsertId;
    }

    public function update(Address $address): void
    {
        $query = "UPDATE {$this->getTable()}
            SET street = :street, city_id = :city_id, zip = :zip, email = :email, name = :name, firstName = :firstName 
            WHERE id = :id";

        $this->connection->execute($query, [
            'street' => $address->street,
            'city_id' => $address->city,
            'zip' => $address->zip,
            'email' => $address->email,
            'name' => $address->name,
            'firstName' => $address->firstName,
            'id' => $address->id
        ]);
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM {$this->getTable()} WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id' => $id]);
        $this->connection->pdo->commit();
    }
}
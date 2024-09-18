<?php

namespace App\Controller;

use App\Kernel\AppException;
use App\Kernel\Http\Request;
use App\Kernel\Http\Response;
use App\Kernel\Router\RouteAttribute;
use App\Repository\AddressRepository;
use \App\Entity\Address as AddressEntity;

class Address
{
    private const sortingDictionary = [
        'Id' => 'a.id',
        'Street' => 'a.street',
        'Zip code' => 'a.zip',
        'Email' => 'a.email',
        'Name' => 'a.name',
        'First name' => 'a.firstName',
        'City' => 'c.name'
    ];

    public function __construct(
        private AddressRepository $addressRepository,
        private Request           $request
    )
    {
    }

    #[RouteAttribute('GET', '/address')]
    public function getAll(): string
    {
        try {
            $order = self::sortingDictionary[$this->request->get('orderBy')] . ' ' . $this->request->get('order');
        } catch (AppException $e) {
            $order = 'id asc';
        }
        return Response::response($this->addressRepository->findAll($order));
    }

    #[RouteAttribute('GET', '/address/xml')]
    public function getAllXml(): string
    {
        try {
            $order = self::sortingDictionary[$this->request->get('orderBy')] . ' ' . $this->request->get('order');
        } catch (AppException $e) {
            $order = 'id asc';
        }
        return Response::xmlResponse($this->addressRepository->findAll($order));
    }


    #[RouteAttribute('GET', '/address/{id}')]
    public function getOne($id): string
    {
        return Response::response($this->addressRepository->find($id));
    }

    #[RouteAttribute('POST', '/address')]
    public function create(): string
    {
        try {
            $address = new AddressEntity(
                $this->request->get('street'),
                $this->request->get('city_id'),
                $this->request->get('zip'),
                $this->request->get('email'),
                $this->request->get('name'),
                $this->request->get('firstName')
            );
            return $this->addressRepository->create($address);
        } catch (AppException $e) {
            return Response::response(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return Response::response(['error' => 'Invalid data sent']);
        }
    }

    #[RouteAttribute('PUT', '/address/{id}')]
    public function update($id): string
    {
        try {
            $address = new AddressEntity(
                $this->request->get('street'),
                $this->request->get('city_id'),
                $this->request->get('zip'),
                $this->request->get('email'),
                $this->request->get('name'),
                $this->request->get('firstName'),
                $id
            );
            $this->addressRepository->update($address);
            return Response::response('success');
        } catch (AppException $e) {
            return Response::response(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return Response::response(['error' => 'Invalid data sent']);
        }
    }

    #[RouteAttribute('DELETE', '/address/{id}')]
    public function delete($id): void
    {
        try {
            $address = $this->addressRepository->find($id);
            if ($address['email'] !== $this->request->get('email')) {
                http_response_code(410);
            }
            $this->addressRepository->delete($id);
            http_response_code(204);
        } catch (\Exception $e) {
            http_response_code(410);
        }
        exit();
    }
}
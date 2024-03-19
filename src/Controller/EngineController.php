<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Engine;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api', name: 'api_')]
class EngineController extends AbstractController
{
    #[Route('/engines', name: 'engine_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $engines = $entityManager
                ->getRepository(Engine::class)
                ->findAll();

            $data = [];

            foreach ($engines as $engine) {
                $data[] = [
                    'id' => $engine->getSerialCode(),
                    'name' => $engine->getName(),
                    'serial_code' => $engine->getSerialCode(),
                    'horsepower' => $engine->getHorsepower(),
                    'manufacturer' => $engine->getManufacturer(),
                ];
            }

            return $this->json($data);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    #[Route('/engines', name: 'engine_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $name = $request->request->get('name');
        $serialCode = $request->request->get('serial_code');
        $horsepower = $request->request->get('horsepower');
        $manufacturer = $request->request->get('manufacturer');


        if ($name === null || $serialCode === null || $horsepower === null || $manufacturer === null) {
            return $this->json(['error' => 'Mandatory fields cannot be null.'], 400);
        }


        $engine = new Engine();
        $engine->setName($name);
        $engine->setSerialCode($serialCode);
        $engine->setHorsepower((int)$horsepower);
        $engine->setManufacturer($manufacturer);

        $errors = $validator->validate($engine);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $entityManager->persist($engine);
        $entityManager->flush();

        return $this->json([
            'id' => $engine->getSerialCode(),
            'name' => $engine->getName(),
            'serial_code' => $engine->getSerialCode(),
            'horsepower' => $engine->getHorsepower(),
            'manufacturer' => $engine->getManufacturer(),
        ]);
    }

    #[Route('/engines/{serial_code}', name: 'engine_show', methods: ['GET'])]
    public function show(EntityManagerInterface $entityManager, string $serial_code): JsonResponse
    {
        $engine = $entityManager->getRepository(Engine::class)->findOneBy(['SerialCode' => $serial_code]);

        if (!$engine) {
            return $this->json('No engine found for serial code: ' . $serial_code, 404);
        }

        return $this->json([
            'id' => $engine->getSerialCode(),
            'name' => $engine->getName(),
            'serial_code' => $engine->getSerialCode(),
            'horsepower' => $engine->getHorsepower(),
            'manufacturer' => $engine->getManufacturer(),
        ]);
    }

    #[Route('/engines/{serial_code}', name: 'engine_update', methods: ['PUT', 'PATCH'])]
    public function update(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator, string $serial_code): JsonResponse
    {
        $engine = $entityManager->getRepository(Engine::class)->findOneBy(['SerialCode' => $serial_code]);

        if (!$engine) {
            return $this->json('No engine found for serial code: ' . $serial_code, 404);
        }

        $engine->setName($request->request->get('name', $engine->getName()));
        $engine->setSerialCode($request->request->get('serial_code', $engine->getSerialCode()));
        $engine->setHorsepower((int)$request->request->get('horsepower', $engine->getHorsepower()));
        $engine->setManufacturer($request->request->get('manufacturer', $engine->getManufacturer()));

        $errors = $validator->validate($engine);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $entityManager->flush();

        return $this->json([
            'id' => $engine->getSerialCode(),
            'name' => $engine->getName(),
            'serial_code' => $engine->getSerialCode(),
            'horsepower' => $engine->getHorsepower(),
            'manufacturer' => $engine->getManufacturer(),
        ]);
    }

    #[Route('/engines/{serial_code}', name: 'engine_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, string $serial_code): JsonResponse
    {
        $engine = $entityManager->getRepository(Engine::class)->findOneBy(['SerialCode' => $serial_code]);

        if (!$engine) {
            return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }

        $entityManager->remove($engine);
        $entityManager->flush();

        return $this->json('The engine with serial code ' . $serial_code . ' has been successfully deleted');
    }
}

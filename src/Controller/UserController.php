<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractFOSRestController
{
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->em = $entityManager;
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Return details of an user",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"user"}))
     *     )
     * )
     * @SWG\Tag(name="Return details of an user")
     * @Rest\Get("/api/users/{id}")
     * @Rest\View(serializerGroups={"user"})
     * @param User $user
     * @return \FOS\RestBundle\View\View
     */
    public function getApiUser(User $user)
    {
        return $this->view($user);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="All of users",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"user"}))
     *     )
     * )
     * @SWG\Tag(name="All of users")
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/api/users")
     * @param User $user
     * @return \FOS\RestBundle\View\View
     */
    public function getApiUsers()
    {
        $users = $this->userRepository->findAll();

        return $this->view($users);
        // "get_users"
    }

    /**
     * @Rest\Get("/api/articles")
     * @Rest\View(serializerGroups={"articles"})
     * @return \FOS\RestBundle\View\View
     */
    public function getApiArticlesUser()
    {
        $articles = $this->getUser();
        return $this->view( $articles );
        // "get_articles
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="A new user",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"user"}))
     *     )
     * )
     * @SWG\Tag(name="A new user")
     * @Rest\Post("/api/users")
     * @return \FOS\RestBundle\View\View
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @Rest\View(serializerGroups={"user"})
     */
    public function postApiUser(User $user, ConstraintViolationListInterface $validationErrors)
    {
        $errors = array();
        if ($validationErrors->count() > 0) {
            /** @var ConstraintViolation $constraintViolation */
            foreach ($validationErrors as $constraintViolation) {
                // Returns the violation message. (Ex. This value should not be blank.)
                $message = $constraintViolation->getMessage();
                // Returns the property path from the root element to the violation. (Ex. lastname)
                $propertyPath = $constraintViolation->getPropertyPath();
                $errors[] = ['message' => $message, 'propertyPath' => $propertyPath];
            }
        }
        if (!empty( $errors )) {
            // Throw a 400 Bad Request with all errors messages (Not readable, you can do better)
            throw new BadRequestHttpException( \json_encode( $errors ) );
        }
        $this->em->persist( $user );
        $this->em->flush();
        return $this->view( $user );
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Updating an user",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"user"}))
     *     )
     * )
     * @SWG\Tag(name="Updating an user")
     * @Rest\Patch("/api/users/{id}")
     * @return string
     */
    public function patchApiUser(User $user, Request $request,  ValidatorInterface $validator)
    {
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        $birthday = $request->get('birthday');
        $apiKey = $request->get('api_key');

        if($firstname !== null){
            $user->setFirstname($firstname);
        }
        if($lastname !== null){
            $user->setLastname($lastname);
        }
        if($email !== null){
            $user->setEmail($email);
        }
        if($birthday !== null){
            $user->setBirthday($birthday);
        }
        if ($apiKey !== null) {
            $user->setApiKey($apiKey);
        }

        $validationErrors = $validator->validate($user);
        if ($validationErrors->count() > 0) {
            /** @var ConstraintViolation $constraintViolation */
            foreach ($validationErrors as $constraintViolation) {
                // Returns the violation message. (Ex. This value should not be blank.)
                $message = $constraintViolation->getMessage();
                // Returns the property path from the root element to the violation. (Ex. lastname)
                $propertyPath = $constraintViolation->getPropertyPath();
                $errors[] = ['message' => $message, 'propertyPath' => $propertyPath];
            }
        }
        $this->em->persist($user);
        $this->em->flush();
        return $this->json($user);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Removing of an user",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"user"}))
     *     )
     * )
     * @SWG\Tag(name="Removing of a user")
     * @Rest\Delete("/api/users/{id}")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteApiUser(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
        return $this->json('OK');
    }
}
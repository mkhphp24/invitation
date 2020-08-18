<?php


	namespace App\Services;

	use App\Exceptions\InvalidNullException;
	use App\Services\AbstractApiService;
	use Doctrine\ORM\EntityManager;
	use App\Entity\user;

	class ServiceUser extends AbstractApiService
	{

		public function __construct(EntityManager $em, $entityName)
		{
			$this->em    = $em;
			$this->model = $em->getRepository($entityName);
		}

		public function getUser($id)
		{
			$result= $this->find($id);
			if (is_null( $result ) )
				throw new InvalidNullException(
					sprintf(
						'"%s" don\'t Find Id  ' ,$id
					)
				);

			return $result;
		}

		public function editUser($RestPutData)
		{
			return $this->editquery($RestPutData);
		}

		public function insertUser(User $entity)
		{
			return $this->insertquery($entity);
		}



	}


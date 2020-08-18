<?php


	namespace App\Services;

	use App\Services\AbstractApiService;
	use Doctrine\ORM\EntityManager;
	use App\Entity\Invitation;

	class ServiceInvitation extends AbstractApiService
	{

		public function __construct(EntityManager $em, $entityName)
		{
			$this->em    = $em;
			$this->model = $em->getRepository($entityName);
		}

		public function getInvitation($id)
		{
			$result= $this->find($id);
			if( is_null ( $result) ){
				throw new \Exception("Invalid $id NOT Found");
			}
			return $result;
		}

		public function editInvitation($RestPutData)
		{
			return $this->editquery($RestPutData);
		}

		public function insertInvitation(Invitation $entity)
		{
			return $this->insertquery($entity);
		}



	}


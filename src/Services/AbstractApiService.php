<?php


	namespace App\Services;

	use Doctrine\DBAL\LockMode;
	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\Query;
	use Doctrine\ORM\EntityManagerInterface;
	use phpDocumentor\Reflection\Types\Integer;

	abstract class AbstractApiService
	{
		/**
		 * @var \Doctrine\ORM\EntityRepository
		 */
		protected $model;
		protected $em;
		protected $entityName;
		/**
		 * @param   EntityManager  $em
		 * @param                  $entityName
		 */
		protected function __construct(EntityManager $em, $entityName)
		{
			$this->entityName   = $entityName;
			$this->em    = $em;
			$this->model = $em->getRepository($this->entityName);
		}

		/**
		 * @return EntityManager
		 */
		protected function entityManager()
		{
			return $this->em;
		}

		/**
		 * /**
		 * @param         $id
		 * @param   int   $lockMode
		 * @param   null  $lockVersion
		 *
		 */
		protected function find(
			$id,
			$lockMode = LockMode::NONE,
			$lockVersion = null
		) {
			return $this->model->find($id, $lockMode,$lockVersion);
		}

		/**
		 * @param   array  $RestPutData
		 */
        protected  function editquery(array $RestPutData){

            $query = $this->model->createQueryBuilder('tabel')
                ->update($this->entityName);
            $query=$this->makeUpdateQuery($query,$RestPutData);
            $query->where('tabel.id = :id')
                ->setParameter('id', $RestPutData['id'])
                ->getQuery()->execute();
        }

		/**
		 * @param          $query
		 * @param   array  $RestPutData
		 *
		 * @return mixed
		 */
        private function makeUpdateQuery($query,array $RestPutData){
            foreach($RestPutData as $key =>$value)
            {
                if( $key === 'id' ) continue;
                $query->set("tabel.$key", ":$key")->setParameter("$key", "$value");
            }

            return $query;
        }

		/**
		 * @param $entity
		 *
		 * @throws \Doctrine\ORM\ORMException
		 * @throws \Doctrine\ORM\OptimisticLockException
		 */
        protected  function insertquery($entity){
            $this->em->persist($entity);
            $this->em->flush();
        }


	}

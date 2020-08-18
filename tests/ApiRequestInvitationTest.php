<?php


	namespace App\Tests;

		use App\Entity\Invitation;
		use Doctrine\ORM\EntityManager;
		use Symfony\Component\HttpFoundation\Response;
		use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
		use App\Exceptions\InvalidNullException;

	class ApiRequestInvitationTest  extends WebTestCase
	{
		/** @var EntityManager $manager */
		private $em;

		/** @var Client $client */
		protected $client;
        protected $token;
        protected $header;

		public function setUp()
		{
			$this->client = static::createClient();
			$this->em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
			$this->token= $this->createToken();
			//var_dump($this->token);die();
			$this->header = array(
				'HTTP_Authorization'=>  sprintf('%s %s', 'Bearer', $this->token),
				'CONTENT_TYPE' => 'application/json',
			);
		}
//#########################################################################################
		public function testJwtLoginCheck()
		{
			$this->client->request('POST', '/api/test');
			$response = $this->client->getResponse();
			$this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
			$this->client->request('POST', '/api/test',array(),array(),$this->header,'');
			$response = $this->client->getResponse();
			$this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

		}
//#########################################################################################

		public function testdoInsertRequestInvitation()
		{
			$this->client->request('POST', '/api/invitation/request/',
				array(),
				array(),
				$this->header,
				'{"user_sender": 1 , "user_invited":1,"message":"test","accept":"0","cancel":"0"}');
			$response = $this->client->getResponse();
			$this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
			$result= json_decode($response->getContent() ,true);
		    $invitation = $this->em->getRepository(Invitation::class)->find($result['id']);
			$this->assertEquals($invitation->getId(), $result['id']);

			$this->client->request('PUT', '/api/invitation/request/');
			$response = $this->client->getResponse();
			$this->assertEquals(Response::HTTP_METHOD_NOT_ALLOWED, $response->getStatusCode());

			$this->client->request('POST', '/api/invitation/request/',
				array(),
				array(),
				$this->header,
				'{"user_sender": 1 , "user_invited":123,"message":"test","accept":"g","cancel":"g"}');
			$response = $this->client->getResponse();
			$this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());

		}
//#########################################################################################

		public function testdoAcceptInvitation()
		{
			$this->client->request('PUT', '/api/invitation/accept/',
				array(),
				array(),
				$this->header,
				'{"id":1 ,"accept":"1"}');
			$response = $this->client->getResponse();

			$this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
			$invitation = $this->em->getRepository(Invitation::class)->find(1);
			$this->assertEquals($invitation->getAccept(), true);

			$this->client->request('PUT', '/api/invitation/accept/',
				array(),
				array(),
				$this->header,
				'{"id":1 ,"accept":"11111"}');
			$response = $this->client->getResponse();

			$this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());

		}
//#########################################################################################

		public function testdoCancelInvitation()
		{
			$this->client->request('PUT', '/api/invitation/cancel/',
				array(),
				array(),
				$this->header,
				'{"id":1 ,"cancel":"1"}');
			$response = $this->client->getResponse();

			$this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
			$invitation = $this->em->getRepository(Invitation::class)->find(1);
			$this->assertEquals($invitation->getCancel(), true);

			$this->client->request('PUT', '/api/invitation/cancel/',
				array(),
				array(),
				$this->header,
				'{"id":1 ,"cancel":"11111"}');
			$response = $this->client->getResponse();

			$this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());


		}
//#########################################################################################


		private function createToken(){

			$server = array('CONTENT_TYPE' => 'application/json');
			$this->client->request('POST', '/api/login_check',
				array(),
				array(),
				$server,
				'{"username":"User1" , "password":"123456"}');
			$response = $this->client->getResponse();
			$result= json_decode($response->getContent() ,true);
			return $result['token'];
		}

	}


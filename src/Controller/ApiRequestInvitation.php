<?php

	namespace App\Controller;

	use App\Validation\ValidateInvitationCancel;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\Routing\Annotation\Route;
	use App\Services\ServiceInvitation;
	use App\Services\ServiceUser;
	use App\Validation\ValidateInvitationRequest;
	use App\Validation\ValidateInvitationAccept;
	use Symfony\Component\HttpFoundation\Request;

	use App\Entity\Invitation;
	use App\Entity\User;

	class ApiRequestInvitation extends AbstractController
	{
		/**
		 * @Route("/api/invitation/request/", name="api_invitation_request" ,  methods={"POST","HEAD"})
		 * @param   Request  $request
		 *
		 * @return JsonResponse
		 */
		public function doInsertRequestInvitation(Request $request)
		{

			$objectServiceInvitation
				= new ServiceInvitation($this->getDoctrine()->getManager(),
				Invitation::class);

			if (0 === strpos($request->headers->get('Content-Type'),
					'application/json')
			) {
				$restPostData = json_decode($request->getContent(), true);
			}

			$datavalidate   = new ValidateInvitationRequest($restPostData);
			$validationData = $datavalidate->validateCheck($restPostData['user_invited']);

			if (empty($validationData['Error'])) {
				$ObjectInvitation
					= $this->setVariabelInvitation(new Invitation(),
					$restPostData);
				$objectServiceInvitation->insertInvitation($ObjectInvitation);

			}

			return new JsonResponse(['id'=>$ObjectInvitation->getId(),'validate'=>$validationData]);

		}
//############################################################################
		/**
		 * @Route("/api/invitation/accept/", name="api_invitation_accept" ,  methods={"PUT","HEAD"})
		 * @param   Request  $request
		 *
		 * @return JsonResponse
		 */
		public function doAcceptInvitation(Request $request)
		{

			$objectServiceInvitation
				= new ServiceInvitation($this->getDoctrine()->getManager(),
				Invitation::class);

			if (0 === strpos($request->headers->get('Content-Type'),
					'application/json')
			) {
				$restPutData = json_decode($request->getContent(), true);
			}

			$datavalidate   = new ValidateInvitationAccept($restPutData);
			$validationData = $datavalidate->validateCheck();

			if (empty($validationData['Error'])) {
				$objectServiceInvitation->editInvitation($restPutData);
			}

			return new JsonResponse($validationData);
		}
//############################################################################
		/**
		 * @Route("/api/invitation/cancel/", name="api_invitation_cancel" ,  methods={"PUT","HEAD"})
		 * @param   Request  $request
		 *
		 * @return JsonResponse
		 */
		public function doCancelInvitation(Request $request)
		{

			$objectServiceInvitation
				= new ServiceInvitation($this->getDoctrine()->getManager(),
				Invitation::class);

			if (0 === strpos($request->headers->get('Content-Type'),
					'application/json')
			) {
				$restPutData = json_decode($request->getContent(), true);
			}

			$datavalidate   = new ValidateInvitationCancel($restPutData);
			$validationData = $datavalidate->validateCheck();
			if (empty($validationData['Error'])) {
				$objectServiceInvitation->editInvitation($restPutData);
			}

			return new JsonResponse($validationData);
		}
//############################################################################
		/**
		 * @param   Invitation  $ObjectInvitation
		 * @param   array       $restPostData
		 *
		 * @return Invitation
		 */
		private function setVariabelInvitation(
			Invitation $ObjectInvitation,
			array $restPostData
		): Invitation {

			$objectServiceUser = new ServiceUser($this->getDoctrine()
				->getManager(),
				User::class);

				$ObjectInvitation
					->setUserSender($objectServiceUser->getUser($restPostData['user_sender']))
					->setUserInvited($objectServiceUser->getUser($restPostData['user_invited']))
					->setMessage($restPostData['message'])
					->setAccept($restPostData['accept'])
					->setCancel($restPostData['cancel']);




			return $ObjectInvitation;

		}

	}

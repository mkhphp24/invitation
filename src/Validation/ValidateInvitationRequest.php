<?php


	namespace App\Validation;

	use App\Validation\AbstractValidate;
	use Symfony\Component\Validator\Constraints as Assert;


	class ValidateInvitationRequest extends AbstractValidate
	{

		/**
		 * @return array
		 */
		public function validateCheck($user_invited): array
		{
			$groups     = new Assert\GroupSequence(['Default', 'custom']);
			$constraint = new Assert\Collection([
				'user_sender'  => [new Assert\NotBlank(),new Assert\NotEqualTo($user_invited)],
				'user_invited' => [new Assert\NotBlank()],
				'message'      => [],
				'accept'       => [new Assert\NotBlank()],
				'cancel'       => [new Assert\NotBlank()]
			]);

			return $this->setValidate($constraint, $groups);
		}

	}

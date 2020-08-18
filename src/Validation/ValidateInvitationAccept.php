<?php


	namespace App\Validation;

	use Symfony\Component\Validator\Constraints as Assert;
	use App\Validation\AbstractValidate;

	//

	class ValidateInvitationAccept extends AbstractValidate
	{

		/**
		 * @return array
		 */
		public function validateCheck(): array
		{
			$groups     = new Assert\GroupSequence(['Default', 'custom']);
			$constraint = new Assert\Collection([
				'id'     => [new Assert\NotBlank()],
				'accept' => [new Assert\NotBlank()]
			]);

			return $this->setValidate($constraint, $groups);
		}

	}

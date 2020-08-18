<?php


	namespace App\Validation;

	use Symfony\Component\Validator\Constraints as Assert;
	use App\Validation\AbstractValidate;

	//

	class ValidateInvitationCancel extends AbstractValidate
	{

		/**
		 * @return array
		 */
		public function validateCheck(): array
		{
			$groups     = new Assert\GroupSequence(['Default', 'custom']);
			$constraint = new Assert\Collection([
				'id'     => [new Assert\NotBlank()],
				'cancel' => [new Assert\NotBlank()]
			]);

			return $this->setValidate($constraint, $groups);
		}

	}

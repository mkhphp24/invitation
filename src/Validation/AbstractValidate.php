<?php


	namespace App\Validation;


	use Symfony\Component\Validator\Validation;

	abstract class AbstractValidate
	{

		private $validateManager;
		private $requestData;
		private $constraint;

		public function __construct(array $requestData)
		{
			$this->requestData = $requestData;
			$this->validateManager = Validation::createValidator();
		}

		/**
		 * @param $constraint
		 * @param $groups
		 *
		 * @return array[]
		 */
		protected function setValidate($constraint, $groups)
		{
			$messageError = [];
			$values       = [];
			$violations   = $this->validateManager->validate($this->requestData,
				$constraint, $groups);

			foreach ($violations as $violation) {
				$messageError[]
					= array(
					'nameProperty' => $violation->getPropertyPath(),
					'message'      => $violation->getMessage(),
					'value'        => $violation->getInvalidValue()
				);
			}

			return ['Error' => $messageError, 'values' => $values];


		}
	}
<?php


namespace App\Helper;


use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConsoleHelper
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param mixed $value
     * @param SymfonyStyle $io
     */
    public function validate($objectOrClass, SymfonyStyle $io): void
    {
        /** @var ConstraintViolationList $violations */
        $violations = $this->validator->validate($objectOrClass);
        if ($violations->count() > 0) {
            foreach ($violations as $violation) {
                $io->error($this->constraintViolationToConsoleMessage($violation));
            }
            throw new RuntimeException('Validation error.');
        }
    }

    /**
     * @param $objectOrClass
     * @param $property
     * @return callable
     */
    public function getAskValidation($objectOrClass, $property): callable
    {
        $validator = $this->validator;
        return static function ($value) use ($validator, $objectOrClass, $property) {
            $valid = $validator->validatePropertyValue($objectOrClass, $property, $value);
            if ($valid->count() > 0) {
                throw new InvalidArgumentException($valid->get(0)->getMessage());
            }
            return $value;
        };
    }


    /**
     * @param ConstraintViolation $violation
     * @return string
     */
    private function constraintViolationToConsoleMessage(ConstraintViolation $violation): string
    {
        return ucfirst($violation->getPropertyPath()) . ' -> '
            . $violation->getMessage() . ' (' . $violation->getInvalidValue() . ') ';
    }
}
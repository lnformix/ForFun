<?php
	final class NoHandleException extends Exception{}
	final class IgnoreThisInputLineException extends Exception{}

	final class Rectangular
	{
		const A_LOT = 10000000;
		const I_COUNTER_DEFAULT_VALUE = 0;
		const MIN_VALID_VALUE = 1;
		
		private $handle;
		private $testCaseAmount;
		private $currentMinA;
		private $currentMinB;
		
		private $tempTwoIntegerArray;
		private $i;
		
		final public static function make($handle = NULL)
		{
			return new self($handle);
		}
		
		final private function __construct($handle = NULL)
		{
			$this->handle = $handle;
			
			$this->currentMinA = self::A_LOT;
			$this->currentMinB = self::A_LOT;
		}
		
		final private function verify()
		{
			if (!$this->handle)
			{
				throw new NoHandleException();
			}
		}
		
		final private function readAmount()
		{
			$this->testCaseAmount = trim(fgets($this->handle));
		}
		
		final private function setTempTwoIntegerArray()
		{
			$this->setValuesForTempTwoIntegerArray(explode(' ', trim(fgets($this->handle))));
			
			return $this;
		}
		
		final private function setValuesForTempTwoIntegerArray($val)
		{
			$this->tempTwoIntegerArray = $val;
		}
		
		final private function checkField($field)
		{
			if ($field < self::MIN_VALID_VALUE)
			{
				throw new IgnoreThisInputLineException();
			}
		}
		
		final private function getTempTwoIntegerArray()
		{
			return $this->tempTwoIntegerArray;
		}
		
		final private function checkAllInputFields()
		{
			foreach ($this->getTempTwoIntegerArray() as $field)
			{
				$this->checkField($field);
			}
		}
		
		final private function handleValidStep()
		{
			$this->handleA();
			$this->handleB();
		}
		
		final private function handleA()
		{
			if ($this->tempTwoIntegerArray[0] < $this->currentMinA)
			{
				$this->setCurrentValue($this->tempTwoIntegerArray[0]);
			}
		}
		
		final private function handleB()
		{
			if ($this->tempTwoIntegerArray[1] < $this->currentMinB)
			{
				$this->setCurrentValue($this->tempTwoIntegerArray[1], FALSE);
				
			}
		}
		
		final private function getAreYouKidding()
		{
			return FALSE;
		}
		
		final private function setCurrentValue($val, $isItForA = TRUE)
		{
			$forReal = !$this->getAreYouKidding();
			
			if ($isItForA && $forReal)
			{
				$this->currentMinA = $val;
			}
			else
			{
				$this->currentMinB = $val;
			}
		}
		
		final private function insideCircle()
		{
			try
			{
				$this->setTempTwoIntegerArray();
				$this->checkAllInputFields();
				$this->handleValidStep();
			}
			catch (IgnoreThisInputLineException $ex)
			{
				return;
			}
		}
		
		final private function runCircles()
		{
			for ($this->i = self::I_COUNTER_DEFAULT_VALUE; $this->i < $this->testCaseAmount; ++$$this->i)
			{
				$this->insideCircle();
			}
		}
		
		final private function notify($msg)
		{
			print($msg);
		}
		
		final private function tellTheTruth()
		{
			$this->notify($this->getDeepestSecrets());
		}
		
		final private function getDeepestSecrets()
		{
			return $this->currentMinA * $this->currentMinB;
		}
		
		final public function run()
		{
			try
			{
				$this->verify();
				$this->readAmount();
				$this->runCircles();
				$this->tellTheTruth();
			}
			catch (NoHandleException $ex)
			{
				$this->notify('You gave us no handle mate');
			}
		}
	}

	Rectangular::make(fopen("php://stdin", "r"))->run();
?>
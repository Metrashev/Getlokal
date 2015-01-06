<?php
class ArticlePhotoValidatorSchema extends sfValidatorBase
{
	protected function configure($options = array(), $messages = array())
	{
		$this->addMessage('source', 'The source is required.');
		$this->addMessage('filename', 'The filename is required.');
	}

	protected function doClean($values)
	{
		$errorSchema = new sfValidatorErrorSchema($this);

		foreach($values as $key => $value)
		{
			$errorSchemaLocal = new sfValidatorErrorSchema($this);

			// filename is filled but no source
			if ($value['filename'] && !$value['source'])
			{
				$errorSchemaLocal->addError(new sfValidatorError($this, 'required'), 'source');
			}

			// source is filled but no filename
			if ($value['source'] && !$value['filename'])
			{
				$errorSchemaLocal->addError(new sfValidatorError($this, 'required'), 'filename');
			}

			// no source and no filename, remove the empty values
			if (!$value['filename'] && !$value['source'])
			{
				unset($values[$key]);
			}

			// some error for this embedded-form
			if (count($errorSchemaLocal))
			{
				$errorSchema->addError($errorSchemaLocal, (string) $key);
			}
		}

		// throws the error for the main form
		if (count($errorSchema))
		{
			throw new sfValidatorErrorSchema($this, $errorSchema);
		}

		return $values;
	}
}